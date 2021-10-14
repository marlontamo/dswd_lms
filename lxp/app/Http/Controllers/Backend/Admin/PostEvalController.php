<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Auth\User;
use App\Models\PostEvaluation;
use App\Models\PostEvaluationQuestions;
use App\Models\PostEvaluationSurveyQuestions;
use function foo\func;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;

class PostEvalController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Events.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.postevaluation.index');
    }

    public function getPostEvalData(Request $request){
        // DB::enableQueryLog();
        $postevaluation = PostEvaluation::get()->toArray();
        return $postevaluation;

    }


    public function create()
    {
        $questions = PostEvaluationQuestions::pluck('question','peq_id');

        return view('backend.postevaluation.create', compact('questions'));
    }

    /**
     * Store a newly created Event in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $postevaluation = new PostEvaluation();
        $postevaluation->title = $request->title;
        $postevaluation->description = $request->description;
        $postevaluation->created_by = auth()->user()->id;
        $postevaluation->date_created = date("Y-m-d H:i:s");

        $postevaluation->save();

        $pes_id = $postevaluation->pes_id;

        $data_questions = [];
        foreach ($request->peq_id as $key => $value) {
           $data_questions[] = ["pes_id"=>$pes_id,
                                "peq_id"=>$value,
                                "added_by"=>auth()->user()->id,
                                "date_created"=>date("Y-m-d H:i:s"),
                               ];
        }

        if(!empty($data_questions))
        {
            PostEvaluationSurveyQuestions::insert($data_questions);
        }

        return redirect()->route('admin.post-evaluation-survey')->withFlashSuccess(trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing events.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $postevaluation = PostEvaluation::findOrFail($id);
        $questions = PostEvaluationQuestions::pluck('question','peq_id');
        $peq = PostEvaluationSurveyQuestions::where('pes_id',$id)->get()->toArray();
        $peq_ids = (!empty($peq))?array_column($peq, 'peq_id'):[];

        return view('backend.postevaluation.edit', compact('postevaluation','questions','peq_ids'));
    }

    /**
     * Update events in storage.
     *
     * @param  \Illuminate\Http\Requests $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $postevaluation = PostEvaluation::findOrFail($id);
        $postevaluation->title = $request->title;
        $postevaluation->description = $request->description;
        $postevaluation->update();


        $peq = PostEvaluationSurveyQuestions::where('pes_id', '=', $id);

        $peq->delete();


        $data_questions = [];
        foreach ($request->peq_id as $key => $value) {
           $data_questions[] = ["pes_id"=>$id,
                                "peq_id"=>$value,
                                "added_by"=>auth()->user()->id,
                                "date_created"=>date("Y-m-d H:i:s"),
                               ];
        }

        if(!empty($data_questions))
        {
            PostEvaluationSurveyQuestions::insert($data_questions);
        }

        return redirect()->route('admin.post-evaluation-survey')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


    /**
     * Display events.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Events::findOrFail($id);
        $participants = $event->participants;
        $activities = $event->activities;
        return view('backend.event.show', compact('event','participants','activities'));
    }


    /**
     * Remove event from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $postevaluation = PostEvaluation::findOrFail($id);
        $postevaluation->delete();

        $peq = PostEvaluationSurveyQuestions::where('pes_id', '=', $id);

        $peq->delete();


        return redirect()->route('admin.post-evaluation-survey')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }


}
