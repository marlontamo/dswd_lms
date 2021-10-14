<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Auth\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseTimeline;
use App\Models\Media;
use function foo\func;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCoursesRequest;
use App\Http\Requests\Admin\UpdateCoursesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;

use App\Models\PostEvaluation;
use App\Models\PostEvaluationSurveyQuestions;
use App\Models\Course_student;
use App\Models\CourseEvaluationAnswers;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromView;
use Excel;

class CoursesController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Course.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!Gate::allows('course_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (!Gate::allows('course_delete')) {
                return abort(401);
            }
            $courses = Course::onlyTrashed()->ofTeacher()->get();
        } else {
            $courses = Course::ofTeacher()->get();
        }

        return view('backend.courses.index', compact('courses'));
    }

    /**
     * Display a listing of Courses via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $courses = "";

        if (request('show_deleted') == 1) {
            if (!Gate::allows('course_delete')) {
                return abort(401);
            }
            $courses = Course::onlyTrashed()
                ->whereHas('category')
                ->ofTeacher()->orderBy('created_at', 'desc')->get();


        } else if (request('teacher_id') != "") {
            $id = request('teacher_id');
            $courses = Course::ofTeacher()
                ->whereHas('category')
                ->whereHas('teachers', function ($q) use ($id) {
                    $q->where('course_user.user_id', '=', $id);
                })->orderBy('created_at', 'desc')->get();


        } else if (request('cat_id') != "") {
            $id = request('cat_id');
            $courses = Course::ofTeacher()
                ->whereHas('category')
                ->where('category_id', '=', $id)->orderBy('created_at', 'desc')->get();
                
        } else {
            $courses = Course::ofTeacher()
                ->whereHas('category')
                ->orderBy('created_at', 'desc')->get();
                //die("Sample");
        }


        if (auth()->user()->can('course_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('course_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('lesson_delete')) {
            $has_delete = true;
        }

        return DataTables::of($courses)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.courses', 'label' => 'lesson', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.courses.show', ['course' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.courses.edit', ['course' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.courses.destroy', ['course' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                if($q->published == 1){
                    $type = 'action-unpublish';
                }else{
                    $type = 'action-publish';
                }
                
                $download = '<a class = "float-right" href="'. route('admin.course.downloadExcel', ['id' => $q->id]) . '"><button class="btn btn-success float-right">Download PES Report</button></a>';
                $view .= $download;

                $view .= view('backend.datatable.'.$type)
                    ->with(['route' => route('admin.courses.publish', ['course' => $q->id])])->render();
                return $view;

            })
            ->editColumn('teachers', function ($q) {
                $teachers = "";
                foreach ($q->teachers as $singleTeachers) {
                    $teachers .= '<span class="label label-info label-many">' . $singleTeachers->name . ' </span>';
                }
                return $teachers;
            })
            ->addColumn('lessons', function ($q) {
                $lesson = '<a href="' . route('admin.lessons.create', ['course_id' => $q->id]) . '" class="btn btn-success mb-1"><i class="fa fa-plus-circle"></i></a>  <a href="' . route('admin.lessons.index', ['course_id' => $q->id]) . '" class="btn mb-1 btn-warning text-white"><i class="fa fa-arrow-circle-right"></a>';
                return $lesson;
            })
            ->editColumn('course_image', function ($q) {
                return ($q->course_image != null) ? '<img height="50px" src="' . asset('storage/uploads/' . $q->course_image) . '">' : 'N/A';
            })
            ->editColumn('status', function ($q) {
                $text = "";
                $text = ($q->published == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-dark p-1 mr-1' >" . trans('labels.backend.courses.fields.published') . "</p>" : "";
                $text .= ($q->featured == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-warning p-1 mr-1' >" . trans('labels.backend.courses.fields.featured') . "</p>" : "";
                return $text;
            })
            ->addColumn('category', function ($q) {
                return $q->category->name;
            })
            ->rawColumns(['teachers', 'lessons', 'course_image', 'actions', 'status'])
            ->make();
    }


    /**
     * Show the form for creating new Course.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('course_create')) {
            return abort(401);
        }
        $teachers = \App\Models\Auth\User::whereHas('roles', function ($q) {
            $q->where('role_id', 2);
        })->get()->pluck('name', 'id');

        $categories = Category::where('status', '=', 1)->pluck('name', 'id');
        $courses = Course::pluck('title','id');
        
        $postevaluations = PostEvaluation::pluck('title','pes_id');
        
        $user_types = array("all" => "All", "internal" => "Internal (DSWD Personnel)",  "external" => "External (Intermediaries)");

        return view('backend.courses.create', compact('teachers', 'categories','courses','user_types','postevaluations'));
    }

    /**
     * Store a newly created Course in storage.
     *
     * @param  \App\Http\Requests\StoreCoursesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCoursesRequest $request)
    {
        if (!Gate::allows('course_create')) {
            return abort(401);
        }

        $_path =  public_path('storage/uploads');
        $request = $this->saveNonVideoFiles($request,$_path);

        $course = Course::create($request->all());

        //Saving  videos
        if ($request->media_type != "") {
            $model_type = Course::class;
            $model_id = $course->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $course->title . ' - video';

            if (($request->media_type == 'youtube') || ($request->media_type == 'vimeo')) {
                $video = $request->video;
                $url = $video;
                $video_id = array_last(explode('/', $request->video));
                $media = Media::where('url', $video_id)
                    ->where('type', '=', $request->media_type)
                    ->where('model_type', '=', 'App\Models\Course')
                    ->where('model_id', '=', $course->id)
                    ->first();
                $size = 0;

            } elseif ($request->media_type == 'upload') {
                if (\Illuminate\Support\Facades\Request::hasFile('video_file')) {
                    $file = \Illuminate\Support\Facades\Request::file('video_file');
                    $size = $file->getSize() / 1024;
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $path = storage_path() . '/storage/uploads/';
                    $file->move($path, $filename);
                    $video_id = $filename;
                    $url = storage_path('storage/uploads/' . $filename);

                    $media = Media::where('type', '=', $request->media_type)
                        ->where('model_type', '=', 'App\Models\Lesson')
                        ->where('model_id', '=', $course->id)
                        ->first();
                }
            } else if ($request->media_type == 'embed') {
                $url = $request->video;
                $filename = $course->title . ' - video';
            }

            if ($media == null) {
                $media = new Media();
                $media->model_type = $model_type;
                $media->model_id = $model_id;
                $media->name = $name;
                $media->url = $url;
                $media->type = $request->media_type;
                $media->file_name = $video_id;
                $media->size = 0;
                $media->save();
            }
        }


        if (($request->slug == "") || $request->slug == null) {
            $course->slug = str_slug($request->title);
            $course->save();
        }
        
        $course->save();


        $teachers = \Auth::user()->isAdmin() || \Auth::user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [\Auth::user()->id];
        $course->teachers()->sync($teachers);


        return redirect()->route('admin.courses.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Course.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('course_edit')) {
            return abort(401);
        }
        $teachers = \App\Models\Auth\User::whereHas('roles', function ($q) {
            $q->where('role_id', 2);
        })->get()->pluck('name', 'id');
        $categories = Category::where('status', '=', 1)->pluck('name', 'id');
        $courses = Course::pluck('title','id');
        $user_types = array("all" => "All", "internal" => "Internal (DSWD Personnel)",  "external" => "External (Intermediaries)");

        $course = Course::findOrFail($id);
        $postevaluations = PostEvaluation::pluck('title','pes_id');

        return view('backend.courses.edit', compact('course', 'teachers', 'categories','courses','user_types','postevaluations'));
    }

    /**
     * Update Course in storage.
     *
     * @param  \App\Http\Requests\UpdateCoursesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoursesRequest $request, $id)
    {     
        if (!Gate::allows('course_edit')) {
            return abort(401);
        }
        $course = Course::findOrFail($id);
        //$request = $this->saveFiles($request);
        $_path =  public_path('storage/uploads');
        $request = $this->saveNonVideoFiles($request,$_path);
        $course->slug = str_slug($request->title);
        //Saving  videos
        if ($request->media_type != "" || $request->media_type  != null) {
            if($course->mediavideo){
                $course->mediavideo->delete();
            }
            $model_type = Course::class;
            $model_id = $course->id;
            $size = 0;
            $media = '';
            $url = '';
            $video_id = '';
            $name = $course->title . ' - video';
            $media = $course->mediavideo;
            if ($media == "") {
                $media = new  Media();
            }
            if ($request->media_type != 'upload') {
                if (($request->media_type == 'youtube') || ($request->media_type == 'vimeo')) {
                    $video = $request->video;
                    $url = $video;
                    $video_id = array_last(explode('/', $request->video));
                    $size = 0;

                } else if ($request->media_type == 'embed') {
                    $url = $request->video;
                    $filename = $course->title . ' - video';
                }
                $media->model_type = $model_type;
                $media->model_id = $model_id;
                $media->name = $name;
                $media->url = $url;
                $media->type = $request->media_type;
                $media->file_name = $video_id;
                $media->size = 0;
                $media->save();
            }

            if ($request->media_type == 'upload') {

                if ($request->video_file != null) {

                    $media = Media::where('type', '=', $request->media_type)
                        ->where('model_type', '=', 'App\Models\Course')
                        ->where('model_id', '=', $course->id)
                        ->first();

                    if ($media == null) {
                        $media = new Media();
                    }
                    $media->model_type = $model_type;
                    $media->model_id = $model_id;
                    $media->name = $name;
                    $media->url = url('storage/uploads/'.$request->video_file);
                    $media->type = $request->media_type;
                    $media->file_name = $request->video_file;
                    $media->size = 0;
                    $media->save();

                }
            }
        }
       
        $course->update($request->all());

        $teachers = \Auth::user()->isAdmin() || \Auth::user()->isSuperAdmin() ? array_filter((array)$request->input('teachers')) : [\Auth::user()->id];
        $course->teachers()->sync($teachers);
       
        return redirect()->route('admin.courses.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


    /**
     * Display Course.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('course_view')) {
            return abort(401);
        }
        $teachers = User::get()->pluck('name', 'id');
        $lessons = \App\Models\Lesson::where('course_id', $id)->get();
        $tests = \App\Models\Test::where('course_id', $id)->get();

        $course = Course::findOrFail($id);
        $courseTimeline = $course->courseTimeline()->orderBy('sequence', 'asc')->get();

        $all_answers = CourseEvaluationAnswers::select(DB::raw('COUNT(pea_id) AS total,answer,peq_id,sme'))->where('course_id',$id)->groupBy('answer','peq_id','sme')->get()->toArray();
        $survey_questions = PostEvaluationSurveyQuestions::leftJoin('post_evaluation_questions', 'post_evaluation_survey_questions.peq_id', '=', 'post_evaluation_questions.peq_id')->where('pes_id',$course->pes_id)->get()->toArray();
        $res = Course_student::select(DB::raw('COUNT(user_id) AS respondents'))->where('course_id',$id)->first()->toArray();

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

        if(isset($course->smes) && !empty($course->smes))
        {
            foreach ($course->smes as $key_sme => $value_sme) {
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

        return view('backend.courses.show', compact('course', 'lessons', 'tests', 'courseTimeline','full_questions','qtext_ans'));
    }


    /**
     * Remove Course from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('course_delete')) {
            return abort(401);
        }
        $course = Course::findOrFail($id);
        if ($course->students->count() >= 1) {
            return redirect()->route('admin.courses.index')->withFlashDanger(trans('alerts.backend.general.delete_warning'));
        } else {
            $course->delete();
        }


        return redirect()->route('admin.courses.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Course at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('course_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Course::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Course from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('course_delete')) {
            return abort(401);
        }
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->restore();

        return redirect()->route('admin.courses.index')->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Course from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('course_delete')) {
            return abort(401);
        }
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->forceDelete();

        return redirect()->route('admin.courses.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Permanently save Sequence from storage.
     *
     * @param  Request
     */
    public function saveSequence(Request $request)
    {
        if (!Gate::allows('course_edit')) {
            return abort(401);
        }

        foreach ($request->list as $item) {
            $courseTimeline = CourseTimeline::find($item['id']);
            $courseTimeline->sequence = $item['sequence'];
            $courseTimeline->save();
        }

        return 'success';
    }


    /**
     * Publish / Unpublish courses
     *
     * @param  Request
     */
    public function publish($id)
    {
        if (!Gate::allows('course_edit')) {
            return abort(401);
        }

        $course = Course::findOrFail($id);
        if ($course->published == 1) {
            $course->published = 0;
        } else {
            $course->published = 1;
        }
        $course->save();

        return back()->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    public function downloadExcel($id){
        $data = new CourseExport($id,"stat");
        return Excel::download($data, 'PES_report.xlsx');
    }
}

class CourseExport implements FromView
{
    protected $id;
    protected $type = "stat";

    public function __construct($id,$type){
        $this->id = $id;
        $this->type = $type;
    }

    public function view(): View
    {
        return $this->stat();
        // $type = $this->type;
        // if($type == "stat"){
        //     return $this->stat();
        // }else{
        //     return $this->attendance();
        // } 
    }

    public function stat(){
        $course = Course::findOrFail($this->id);
        $courseTimeline = $course->courseTimeline()->orderBy('sequence', 'asc')->get();

        $all_answers = CourseEvaluationAnswers::select(DB::raw('COUNT(pea_id) AS total,answer,peq_id,sme'))->where('course_id',$this->id)->groupBy('answer','peq_id','sme')->get()->toArray();
        $survey_questions = PostEvaluationSurveyQuestions::leftJoin('post_evaluation_questions', 'post_evaluation_survey_questions.peq_id', '=', 'post_evaluation_questions.peq_id')->where('pes_id',$course->pes_id)->get()->toArray();
        $res = Course_student::select(DB::raw('COUNT(user_id) AS respondents'))->where('course_id',$this->id)->first()->toArray();

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

        if(isset($course->smes) && !empty($course->smes))
        {
            foreach ($course->smes as $key_sme => $value_sme) {
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

        return view('backend.exports.pesReport', [
            'qtext_ans' => $qtext_ans,
            'full_questions' => $full_questions
        ]);
    }
}
