<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Event\Events;
use App\Models\Event\Event_activities;
use App\Models\Event\Eventact_users;
use App\Models\PostEvaluation;
use App\Models\PostEvaluationAnswers;
use App\Models\PostEvaluationSurveyQuestions;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\Psgc\Municipality;
use App\Models\Psgc\Region;
use App\Models\Psgc\Province;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromView;
use Excel;

class EventActController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = Events::pluck('title', 'id')->prepend('Please select', '');
        return view('backend.eventact.index', compact('events'));
    }

    /**
     * Display a listing of Lessons via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {

        $has_view = true;
        $has_delete = true;
        $has_edit = true;
        $event_acts = "";

        $provinces = Province::All()->where('region_code',"140000000")->pluck('province_name', 'province_code')->toArray();
        $car_prov = array_keys($provinces);
        $municipality = Municipality::whereIn('province_code', $car_prov)->pluck('city_name', 'city_code')->toArray();

        $event_acts = Event_activities::whereIn('event_id', Events::pluck('id'));

        if ($request->event_id != "") {
            $event_acts = $event_acts->where('event_id', (int)$request->event_id)->orderBy('created_at', 'desc')->get();
        }

        if ($request->show_deleted == 1) {
            $event_acts = Event_activities::query()->with('events')->orderBy('created_at', 'desc')->onlyTrashed()->get();
        }

        return DataTables::of($event_acts)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.eventacts', 'label' => 'eventacts', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.eventacts.show', ['id' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.eventacts.edit', ['id' => $q->id])])
                        ->render();
                    $view .= $edit;
                }
                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.eventacts.destroy', ['id' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                
                $download = '<a class = "float-right" href="'. route('admin.eventacts.dlAttendance', ['id' => $q->id]) . '"><button class="btn btn-success float-right">Download Attendance</button></a>';
                $view .= $download;

                $download = '<a class = "float-right" href="'. route('admin.eventacts.downloadExcel', ['id' => $q->id]) . '"><button class="btn btn-success float-right">Download PES Report</button></a>';
                $view .= $download;

                return $view;

            })
            ->editColumn('events', function ($q) {
                return ($q->events) ? $q->events->title : 'N/A';
            })
            ->editColumn('act_posters', function ($q) {
                return ($q->act_posters != null) ? '<img height="50px" src="' . asset('storage/uploads/' . $q->act_posters) . '">' : 'N/A';
            })
            ->editColumn('activity_date', function ($q) {
                $sdate = date("F j, Y", strtotime($q->activity_date));
                return $sdate;
            })
            ->editColumn('eventactUsers', function ($q) {
                return $q->eventactUsers;
            })
            ->editColumn('provinces', function ($q) use($provinces){
                return $provinces;
            })
            ->editColumn('municipality', function ($q) use($municipality) {
                return $municipality;
            })
            ->rawColumns(['act_posters', 'actions'])
            ->make();
    }

    /**
     * Show the form for creating new Lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $postevaluations = PostEvaluation::pluck('title','pes_id');
        $events = Events::pluck('title', 'id')->prepend('Please select', '');
        return view('backend.eventact.create', compact('events','postevaluations'));
    }

    /**
     * Store a newly created Lesson in storage.
     *
     * @param  \Illuminate\Http\Requests $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $this->saveMultipleFiles($request);
        $eventacts = Event_activities::create($request->except('act_posters','downloadable_files'));

        if (($request->slug == "") || $request->slug == null) {
            $eventacts->slug = str_slug($request->title);
        }
        if (($request->act_posters != "") || $request->act_posters != null) {
            $eventacts->act_posters = json_encode($request->act_posters);
        }
        $eventacts->pes_id = $request->pes_id;
        $eventacts->smes = $request->smes;

        $eventacts->sequence = Event_activities::where('event_id', $request->event_id)->max('sequence') + 1;
        $eventacts->save();

        return redirect()->route('admin.eventacts.index', ['event_id' => $request->event_id])->withFlashSuccess(__('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Lesson.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $events = Events::pluck('title', 'id')->prepend('Please select', '');
        $eventact = Event_activities::findOrFail($id);
        $postevaluations = PostEvaluation::pluck('title','pes_id');
        return view('backend.eventact.edit', compact('events', 'eventact','postevaluations'));
    }

    /**
     * Update Lesson in storage.
     *
     * @param  \Illuminate\Http\Requests $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $eventact = Event_activities::findOrFail($id);
        $request = $this->saveMultipleFiles($request, 'downloadable_files', Event_activities::class, $eventact);
        $eventact->pes_id = $request->pes_id;
        $eventact->smes = $request->smes;
        $eventact->update($request->except('act_posters','downloadable_files'));


        if (($request->slug == "") || $request->slug == null) {
            $eventact->slug = str_slug($request->title);
            $eventact->save();
        }

        if (($request->act_posters != "") || $request->act_posters != null) {
            $eventact->act_posters = json_encode($request->act_posters);
            $eventact->save();
        }

        return redirect()->route('admin.eventacts.index', ['event_id' => $request->event_id])->withFlashSuccess(__('alerts.backend.general.updated'));
    }


    /**
     * Display Lesson.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $events = Events::get()->pluck('title', 'id')->prepend('Please select', '');

        $eventact = Event_activities::with('events')->findOrFail($id);

        $all_answers = PostEvaluationAnswers::select(DB::raw('COUNT(pea_id) AS total,answer,peq_id,sme'))->where('activity_id',$id)->groupBy('answer','peq_id','sme')->get()->toArray();

        $survey_questions = PostEvaluationSurveyQuestions::leftJoin('post_evaluation_questions', 'post_evaluation_survey_questions.peq_id', '=', 'post_evaluation_questions.peq_id')->where('pes_id',$eventact->pes_id)->get()->toArray();


        $res = Eventact_users::select(DB::raw('COUNT(id) AS respondents'))->where('eventact_id',$id)->first()->toArray();

        $group_answers = [];

        foreach ($all_answers as $key => $value) {
            $group_answers[$value['sme']][$value['peq_id']][$value['answer']] = $value['total'];
        }

        $full_questions = [];

        foreach ($survey_questions as $key => $value) {
            if($value["answer_type"] == 1 && $value['sme'] == 0)
            {
                $value['respondents'] = $res['respondents'];
                $value['sme_charge'] = "";
                
                $value['stats'] = [];
                $value['rate'] = '';
                $value['adjective'] = '';

                if(isset($group_answers[$value['sme_charge']][$value['peq_id']]))
                {
                    $value['stats'] = $group_answers[$value['sme_charge']][$value['peq_id']];

                    if($res['respondents'] != 0)
                    {
                        foreach ($group_answers[$value['sme_charge']][$value['peq_id']] as $key_calcu => $value_calcu) {
                            $rate_calcu = ($key_calcu*$value_calcu)/$res['respondents'];
                            if($value['rate'] != '')
                            {
                               $value['rate'] = $value['rate'] + $rate_calcu; 
                            }
                            else
                            {
                               $value['rate'] = $rate_calcu;
                            }
                            
                        }
                    }

                }
                //here
                if($value['rate'] != '')
                {
                    if($value['rate'] >= 4.5 && $value['rate'] <= 5)
                    {
                        $value['adjective'] = 'Outstanding';
                    }elseif ($value['rate'] >= 3.5 && $value['rate'] < 4.5) {
                        $value['adjective'] = 'Very Satisfactory';
                    }elseif ($value['rate'] >= 2.5 && $value['rate'] < 3.5) {
                        $value['adjective'] = 'Satisfactory';
                    }elseif ($value['rate'] >= 1.5 && $value['rate'] < 2.5) {
                        $value['adjective'] = 'Fair';
                    }elseif ($value['rate'] < 1.5) {
                        $value['adjective'] = 'Poor';
                    }
                }
                //here

                $full_questions[$value['sme_charge']][] = $value;
            }   
        }

        if(isset($eventact->smes) && !empty($eventact->smes))
        {
            foreach ($eventact->smes as $key_sme => $value_sme) {
                foreach ($survey_questions as $key => $value) {
                    if($value["answer_type"] == 1 && $value['sme'] == 1)
                    {
                        $value['respondents'] = $res['respondents'];
                        $value['sme_charge'] = $value_sme;

                        $value['stats'] = [];
                        $value['rate'] = '';
                        $value['adjective'] = '';

                        if(isset($group_answers[$value['sme_charge']][$value['peq_id']]))
                        {
                            $value['stats'] = $group_answers[$value['sme_charge']][$value['peq_id']];

                            if($res['respondents'] != 0)
                            {
                                foreach ($group_answers[$value['sme_charge']][$value['peq_id']] as $key_calcu => $value_calcu) {
                                    $rate_calcu = ($key_calcu*$value_calcu)/$res['respondents'];
                                    if($value['rate'] != '')
                                    {
                                       $value['rate'] = $value['rate'] + $rate_calcu; 
                                    }
                                    else
                                    {
                                       $value['rate'] = $rate_calcu;
                                    }
                                    
                                }
                            }

                        }
                        //here
                        if($value['rate'] != '')
                        {
                            if($value['rate'] >= 4.5 && $value['rate'] <= 5){
                                $value['adjective'] = 'Outstanding';
                            }elseif ($value['rate'] >= 3.5 && $value['rate'] < 4.5) {
                                $value['adjective'] = 'Very Satisfactory';
                            }elseif ($value['rate'] >= 2.5 && $value['rate'] < 3.5) {
                                $value['adjective'] = 'Satisfactory';
                            }elseif ($value['rate'] >= 1.5 && $value['rate'] < 2.5) {
                                $value['adjective'] = 'Fair';
                            }elseif ($value['rate'] < 1.5) {
                                $value['adjective'] = 'Poor';
                            }
                        }
                        //here

                        $full_questions[$value['sme_charge']][] = $value;
                    }
                }
            }
        }

        $qtext_ans = [];

        foreach ($survey_questions as $key => $value) {

            if($value["answer_type"] != 1){
                $question = $value["question"];
                $peq_id = $value["peq_id"];
                
                foreach ($all_answers as $a_key => $a_value) {
                    if($peq_id == $a_value["peq_id"]){
                        $sme = $a_value['sme'];
                        $qtext_ans[$sme][$question][] = $a_value['answer'];
                    }
                }
            }
        }

        return view('backend.eventact.show', compact('eventact', 'events','full_questions','qtext_ans'));
    }


    /**
     * Remove Lesson from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eventact = Event_activities::findOrFail($id);
        $eventact->delete();
        return back()->withFlashSuccess(__('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Lesson at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Event_activities::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Lesson from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $eventact = Event_activities::onlyTrashed()->findOrFail($id);
        $eventact->restore();

        return back()->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Lesson from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        $eventact = Event_activities::onlyTrashed()->findOrFail($id);

        if(File::exists(public_path('/storage/uploads/'.$eventact->event_image))) {
            File::delete(public_path('/storage/uploads/'.$eventact->event_image));
            File::delete(public_path('/storage/uploads/thumb/'.$eventact->event_image));
        }
        
        foreach (json_decode($eventact->act_posters) as $key => $eventimage) {
            if(File::exists(public_path('/storage/uploads/'.$eventimage))) {
                File::delete(public_path('/storage/uploads/'.$eventimage));
                File::delete(public_path('/storage/uploads/thumb/'.$eventimage));
            }
        }

        $eventact->forceDelete();
        return back()->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    public function downloadExcel($id){
        $data = new EventActExport($id,"stat");
        return Excel::download($data, 'PES_report.xlsx');
    }

    public function dlAttendance($id){
        $data = new EventActExport($id, "attendance");

        //return $data->attendance();
        return Excel::download($data, 'attendance_report.xlsx');
    }
}


// class DataExport implements FromCollection
// {
//     protected $dataCollection;

//     public function __construct($dt){
//         $this->dataCollection = $dt;
//     }

//     public function collection(){
//            return $this->dataCollection;
//     }
// }

class EventActExport implements FromView
{
    protected $id;
    protected $type = "stat";

    public function __construct($id,$type){
        $this->id = $id;
        $this->type = $type;
    }

    public function view(): View
    {
        $type = $this->type;
        if($type == "stat"){
            return $this->stat();
        }else{
            return $this->attendance();
        } 
    }

    public function stat(){
        $eventact = Event_activities::with('events')->findOrFail($this->id);
        $type = $this->type;

        $all_answers = PostEvaluationAnswers::select(DB::raw('COUNT(pea_id) AS total,answer,peq_id,sme'))->where('activity_id',$this->id)->groupBy('answer','peq_id','sme')->get()->toArray();

        $survey_questions = PostEvaluationSurveyQuestions::leftJoin('post_evaluation_questions', 'post_evaluation_survey_questions.peq_id', '=', 'post_evaluation_questions.peq_id')->where('pes_id',$eventact->pes_id)->get()->toArray();


        $res = Eventact_users::select(DB::raw('COUNT(id) AS respondents'))->where('eventact_id',$this->id)->first()->toArray();

        $group_answers = [];

        foreach ($all_answers as $key => $value) {
            $group_answers[$value['sme']][$value['peq_id']][$value['answer']] = $value['total'];
        }

        $full_questions = [];

        foreach ($survey_questions as $key => $value) {
            if($value["answer_type"] == 1 && $value['sme'] == 0)
            {
                $value['respondents'] = $res['respondents'];
                $value['sme_charge'] = "";
                
                $value['stats'] = [];
                $value['rate'] = '';
                $value['adjective'] = '';

                if(isset($group_answers[$value['sme_charge']][$value['peq_id']]))
                {
                    $value['stats'] = $group_answers[$value['sme_charge']][$value['peq_id']];

                    if($res['respondents'] != 0)
                    {
                        foreach ($group_answers[$value['sme_charge']][$value['peq_id']] as $key_calcu => $value_calcu) {
                            $rate_calcu = ($key_calcu*$value_calcu)/$res['respondents'];
                            if($value['rate'] != '')
                            {
                                $value['rate'] = $value['rate'] + $rate_calcu; 
                            }
                            else
                            {
                                $value['rate'] = $rate_calcu;
                            }
                            
                        }
                    }

                }
                //here
                if($value['rate'] != '')
                {
                    if($value['rate'] >= 4.5 && $value['rate'] <= 5)
                    {
                        $value['adjective'] = 'Outstanding';
                    }elseif ($value['rate'] >= 3.5 && $value['rate'] < 4.5) {
                        $value['adjective'] = 'Very Satisfactory';
                    }elseif ($value['rate'] >= 2.5 && $value['rate'] < 3.5) {
                        $value['adjective'] = 'Satisfactory';
                    }elseif ($value['rate'] >= 1.5 && $value['rate'] < 2.5) {
                        $value['adjective'] = 'Fair';
                    }elseif ($value['rate'] < 1.5) {
                        $value['adjective'] = 'Poor';
                    }
                }
                //here

                $full_questions[$value['sme_charge']][] = $value;
            }   
        }

        if(isset($eventact->smes) && !empty($eventact->smes))
        {
            foreach ($eventact->smes as $key_sme => $value_sme) {
                foreach ($survey_questions as $key => $value) {
                    if($value["answer_type"] == 1 && $value['sme'] == 1)
                    {
                        $value['respondents'] = $res['respondents'];
                        $value['sme_charge'] = $value_sme;

                        $value['stats'] = [];
                        $value['rate'] = '';

                        if(isset($group_answers[$value['sme_charge']][$value['peq_id']]))
                        {
                            $value['stats'] = $group_answers[$value['sme_charge']][$value['peq_id']];

                            if($res['respondents'] != 0)
                            {
                                foreach ($group_answers[$value['sme_charge']][$value['peq_id']] as $key_calcu => $value_calcu) {
                                    $rate_calcu = ($key_calcu*$value_calcu)/$res['respondents'];
                                    if($value['rate'] != '')
                                    {
                                        $value['rate'] = $value['rate'] + $rate_calcu; 
                                    }
                                    else
                                    {
                                        $value['rate'] = $rate_calcu;
                                    }
                                    
                                }
                            }

                        }
                        //here
                        if($value['rate'] != '')
                        {
                            if($value['rate'] >= 4.5 && $value['rate'] <= 5){
                                $value['adjective'] = 'Outstanding';
                            }elseif ($value['rate'] >= 3.5 && $value['rate'] < 4.5) {
                                $value['adjective'] = 'Very Satisfactory';
                            }elseif ($value['rate'] >= 2.5 && $value['rate'] < 3.5) {
                                $value['adjective'] = 'Satisfactory';
                            }elseif ($value['rate'] >= 1.5 && $value['rate'] < 2.5) {
                                $value['adjective'] = 'Fair';
                            }elseif ($value['rate'] < 1.5) {
                                $value['adjective'] = 'Poor';
                            }
                        }
                        //here

                        $full_questions[$value['sme_charge']][] = $value;
                    }
                }
            }
        }

        $qtext_ans = [];

        foreach ($survey_questions as $key => $value) {

            if($value["answer_type"] != 1){
                $question = $value["question"];
                $peq_id = $value["peq_id"];
                
                foreach ($all_answers as $a_key => $a_value) {
                    if($peq_id == $a_value["peq_id"]){
                        $sme = $a_value['sme'];
                        $qtext_ans[$sme][$question][] = $a_value['answer'];
                    }
                }
            }
        }

        return view('backend.exports.pesReport', [
            'qtext_ans' => $qtext_ans,
            'full_questions' => $full_questions
        ]);
    }

    public function attendance(){

        $users = [];
        
        $provinces = Province::All()->where('region_code',"140000000")->pluck('province_name', 'province_code')->toArray();
        $car_prov = array_keys($provinces);
        $municipality = Municipality::whereIn('province_code', $car_prov)->pluck('city_name', 'city_code')->toArray();

        $eventact = Event_activities::with('events')->findOrFail($this->id);
        if($eventact){
            $users = $eventact->eventactUsers;
        }

        return view('backend.exports.actAttendance', [
            'users' => $users,
            'prov'  => $provinces,
            'mun'   => $municipality,
        ]);

    }
}

// class DataArrayExport implements FromArray 
// {
//     protected $dataCollection;

//     public function __construct(array $dt){
//         $this->dataCollection = $dt;
//     }

//     public function collection(): array{
//         return $this->dataCollection;
//     }
// }