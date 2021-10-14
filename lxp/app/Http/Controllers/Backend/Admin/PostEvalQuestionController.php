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

class PostEvalQuestionController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Events.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.postevalquestion.index');
    }

    public function getPostEvalQuestionData(Request $request){

        $postevalquestion = PostEvaluationQuestions::get()->toArray();
        return $postevalquestion;

    }


    public function create()
    {
        return view('backend.postevalquestion.create');
    }

    /**
     * Store a newly created Event in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $postevalquestion = new PostEvaluationQuestions();
        $postevalquestion->question = $request->question;

        $postevalquestion->sme = $request->sme;

        $postevalquestion->answer_type = $request->answer_type;

        $postevalquestion->created_by = auth()->user()->id;
        $postevalquestion->date_created = date("Y-m-d H:i:s");
        $postevalquestion->save();

        return redirect()->route('admin.post-evaluation-questions')->withFlashSuccess(trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing events.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $postevaluationquestion = PostEvaluationQuestions::findOrFail($id);

        return view('backend.postevalquestion.edit', compact('postevaluationquestion'));
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

        $postevalquestion = PostEvaluationQuestions::findOrFail($id);
        $postevalquestion->question = $request->question;

        $postevalquestion->sme = $request->sme;

        $postevalquestion->answer_type = $request->answer_type;

        $postevalquestion->update();

        return redirect()->route('admin.post-evaluation-questions')->withFlashSuccess(trans('alerts.backend.general.updated'));
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
        $postevalquestion = PostEvaluationQuestions::findOrFail($id);
        $postevalquestion->delete();

        return redirect()->route('admin.post-evaluation-questions')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }


}
