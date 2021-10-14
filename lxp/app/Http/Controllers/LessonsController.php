<?php

namespace App\Http\Controllers;

use App\Helpers\Auth\Auth;
use App\Models\Lesson;
use App\Models\Media;
use App\Models\Question;
use App\Models\QuestionsOption;
use App\Models\Test;
use App\Models\TestsResult;
use App\Models\VideoProgress;
use App\Models\LessonTimeControl;
use App\Models\Course;
use Illuminate\Http\Request;

use App\Models\PostEvaluationSurveyQuestions;
use App\Models\PostEvaluationAnswers;
use App\Models\Course_student;
use App\Models\CourseEvaluationAnswers;
use App\Models\Certificate;
use Carbon\Carbon;

class LessonsController extends Controller
{

    private $path;

    public function __construct()
    {
        $path = 'frontend';
        $this->path = $path;
    }

    public function show($course_id, $lesson_slug)
    {
        $test_result = "";
        $completed_lessons = "";
        $lesson = Lesson::where('slug', $lesson_slug)->where('course_id', $course_id)->where('published', '=', 1)->first();

        if ($lesson == "") {
            $lesson = Test::where('slug', $lesson_slug)->where('course_id', $course_id)->where('published', '=', 1)->firstOrFail();
            $lesson->full_text = $lesson->description;

            $test_result = NULL;
            if ($lesson) {
                $test_result = TestsResult::where('test_id', $lesson->id)
                    ->where('user_id', \Auth::id())
                    ->first();
            }
        }

        //Finish Lesson if
        // if ((int)config('lesson_timer') == 0) {
        //     if ($lesson->chapterStudents()->where('user_id', \Auth::id())->count() == 0) {
        //         $lesson->chapterStudents()->create([
        //             'model_type' => get_class($lesson),
        //             'model_id' => $lesson->id,
        //             'user_id' => auth()->user()->id,
        //             'course_id' => $lesson->course->id
        //         ]);
        //     }
        // }

        //Finish Lesson if passed with test result
        if($test_result){
            if ((int)$test_result->test_result >= (int)$lesson->passing_score) {
                if ($lesson->chapterStudents()->where('user_id', \Auth::id())->count() == 0) {
                    $lesson->chapterStudents()->create([
                        'model_type' => get_class($lesson),
                        'model_id' => $lesson->id,
                        'user_id' => auth()->user()->id,
                        'course_id' => $lesson->course->id
                    ]);
                }
            }
        }

        $course_lessons = $lesson->course->lessons->pluck('id')->toArray();
        $course_tests = ($lesson->course->tests ) ? $lesson->course->tests->pluck('id')->toArray() : [];
        $course_lessons = array_merge($course_lessons,$course_tests);

        $previous_lesson = $lesson->course->courseTimeline()
            ->where('sequence', '<', $lesson->courseTimeline->sequence)
            ->whereIn('model_id',$course_lessons)
            ->orderBy('sequence', 'desc')
            ->first();

        $next_lesson = $lesson->course->courseTimeline()
            ->whereIn('model_id',$course_lessons)
            ->where('sequence', '>', $lesson->courseTimeline->sequence)
            ->orderBy('sequence', 'asc')
            ->first();

        $lessons = $lesson->course->courseTimeline()
            ->whereIn('model_id',$course_lessons)
            ->orderby('sequence', 'asc')
            ->get();



        $purchased_course = $lesson->course->students()->where('user_id', \Auth::id())->count() > 0;
        $test_exists = FALSE;

        if (get_class($lesson) == 'App\Models\Test') {
            $test_exists = TRUE;
        }

        $completed_lessons = \Auth::user()->chapters()
            ->where('course_id', $lesson->course->id)
            ->get()
            ->pluck('model_id')
            ->toArray();

        $check_next_button = FALSE;
        $time_consumed = 0;
        $time_id = 0;

        if(empty($lesson->mediaVideo) && get_class($lesson) != 'App\Models\Test')
        {
            $getLessonTime = LessonTimeControl::where('user_id',\Auth::id())->where('lesson_id',$lesson->id)->get()->first();

            if(!empty($getLessonTime))
            {
                $glt = $getLessonTime->toArray();
                // echo '<pre>';
                // var_dump($glt);
                // die();

                if($glt['time_spent'] < 120)
                {
                    //$time_consumed = $glt['time_spent'] + (strtotime($glt['time_stop']) - strtotime($glt['time_first_visit']));
                    $time_consumed = $glt['time_spent'];
                    $time_id = $glt['id'];
                    $check_next_button = TRUE;


                    //LessonTimeControl::where('user_id',\Auth::id())->where('lesson_id',$lesson->id)->update(['time_first_visit'=>date('Y-m-d H:i:s'),'time_stop'=>date('Y-m-d H:i:s'),'time_spent'=>$time_consumed]);

                    LessonTimeControl::where('user_id',\Auth::id())->where('lesson_id',$lesson->id)->update(['time_first_visit'=>date('Y-m-d H:i:s'),'time_stop'=>date('Y-m-d H:i:s')]);
                }

            }
            else
            {
                $time_id = LessonTimeControl::insertGetId(['user_id'=>\Auth::id(),
                                           'lesson_id'=>$lesson->id,
                                           'time_first_visit'=>date('Y-m-d H:i:s'),
                                           'time_stop'=>date('Y-m-d H:i:s'),
                                           'time_spent'=>0,
                                         ]);

                $check_next_button = TRUE;
            }
        }


        // echo '<pre>';
        // var_dump($next_lesson);
        // die();

        $course = Course::withoutGlobalScope('filter')->where('id', $course_id)->with('publishedLessons')->firstOrFail();


        return view($this->path . '.courses.lesson', compact('course','lesson', 'previous_lesson', 'next_lesson', 'test_result',
            'purchased_course', 'test_exists', 'lessons', 'completed_lessons','check_next_button','time_consumed','time_id'));
    }

    public function test($lesson_slug, Request $request)
    {        
        $test = Test::where('slug', $lesson_slug)->firstOrFail();
        $answers = [];
        $test_score = 0;
        $questions = $request->get('questions');
        $act_answers = $request->get('answer_text');
        

        if(!empty($questions)){
            foreach ($request->get('questions') as $question_id => $answer_id) {
                $question = Question::find($question_id);
                $correct = QuestionsOption::where('question_id', $question_id)
                        ->where('id', $answer_id)
                        ->where('correct', 1)->count() > 0;
                $answers[] = [
                    'question_id' => $question_id,
                    'option_id' => $answer_id,
                    'answer_text' => "",
                    'correct' => $correct
                ];
                if ($correct) {
                    if($question->score) {
                        $test_score += $question->score;
                    }
                }
                /*
                 * Save the answer
                 * Check if it is correct and then add points
                 * Save all test result and show the points
                 */
            }
        }
        $answer_text = [];
        if(!empty($act_answers)){
            foreach ($request->get('answer_text') as $question_id => $answer) {
                $test = Test::where('slug', $lesson_slug)->firstOrFail();

                $question = Question::find($question_id);

                $option_id = QuestionsOption::where('question_id', $question_id)->first()->id;

                $answers[] = [
                    'question_id' => $question_id,
                    'option_id' => $option_id,
                    'answer_text' => $answer,
                    'correct' => 0
                ];
            }
        }

        $test_result = TestsResult::create([
            'test_id' => $test->id,
            'user_id' => \Auth::id(),
            'test_result' => $test_score,
        ]);

        if(!empty($answers)){
            $test_result->answers()->createMany($answers);
        }

        if($test_score >= $test->passing_score){
            if ($test->chapterStudents()->where('user_id', \Auth::id())->get()->count() == 0) {
                $test->chapterStudents()->create([
                    'model_type' => $test->model_type,
                    'model_id' => $test->id,
                    'user_id' => auth()->user()->id,
                    'course_id' => $test->course->id
                ]);
            }
        }
        return back()->with(['message'=>'Test score: ' . $test_score,'result'=>$test_result]);
    }

    public function retest(Request $request)
    {
        $test = TestsResult::where('id', '=', $request->result_id)
            ->where('user_id', '=', auth()->user()->id)
            ->first();
        $test->delete();
        return back();
    }

    public function videoProgress(Request $request)
    {
        $user = auth()->user();
        $video = Media::findOrFail($request->video);
        $video_progress = VideoProgress::where('user_id', '=', $user->id)
            ->where('media_id', '=', $video->id)->first() ?: new VideoProgress();
        $video_progress->media_id = $video->id;
        $video_progress->user_id = $user->id;
        $video_progress->duration = $video_progress->duration ?: round($request->duration, 2);
        $video_progress->progress = round($request->progress, 2);
        if ($video_progress->duration - $video_progress->progress < 5) {
            $video_progress->progress = $video_progress->duration;
            $video_progress->complete = 1;
        }
        $video_progress->save();
        return $video_progress->progress;
    }

    //Get if video is completed
    public function videoCompleted(Request $request)
    {
        $user = auth()->user();
        $video = Media::findOrFail($request->video);
        $video_progress = VideoProgress::where('user_id', '=', $user->id)
            ->where('media_id', '=', $video->id)->first() ?: new VideoProgress();
        $ret = false;
        if($video_progress->complete == 1){

            $ret = true;
            $lesson = Lesson::find($request->model_id);

            if ($lesson != null) {
                if ($lesson->chapterStudents()->where('user_id', \Auth::id())->get()->count() == 0) {
                    $lesson->chapterStudents()->create([
                        'model_type' => $request->model_type,
                        'model_id' => $request->model_id,
                        'user_id' => auth()->user()->id,
                        'course_id' => $lesson->course->id
                    ]);
                    $ret = true;
                }
            }
        }

        $data = array("success" => true, "complete" => $ret);

        return $data;
    }


    public function courseProgress(Request $request)
    {
        $return = array("success" => true);
        if (\Auth::check()) {
            $lesson = Lesson::find($request->model_id);

            if ($lesson != null) {
                if ($lesson->chapterStudents()->where('user_id', \Auth::id())->get()->count() == 0) {
                    $lesson->chapterStudents()->create([
                        'model_type' => $request->model_type,
                        'model_id' => $request->model_id,
                        'user_id' => auth()->user()->id,
                        'course_id' => $lesson->course->id
                    ]);
                    $return["success"] = true;
                }
            }else{
                $return["success"] = false;
            }
        }else{
            $return["success"] = false;
        }

        return json_encode($return);
    }


    public function timeControl(Request $request)
    {
        $lesson = LessonTimeControl::find($request->id);
        // if(!$request->unload)
        // {
        //     $lesson->time_spent = 120;
        // }
        // else
        // {
            $lesson->time_stop = date("Y-m-d H:i:s");
            $time_spent = $lesson->time_spent;
            $lesson->time_spent = $time_spent + (strtotime($lesson->time_stop) - strtotime($lesson->time_first_visit));
        //}
        
        $lesson->save();
    }


    public function surveyQuestions(Request $request)
    {
        $response = [ "success"=>true, "message" => "sucess","data"=> []];
        $survey_questions = [];
        if (\Auth::check()) {
                $course = Course::where('id',$request->course)->first()->toArray();
                $survey_questions = PostEvaluationSurveyQuestions::leftJoin('post_evaluation_questions', 'post_evaluation_survey_questions.peq_id', '=', 'post_evaluation_questions.peq_id')->where('pes_id',$request->pes_id)->get()->toArray();

                if(empty($survey_questions))
                {
                    $response["success"] = false;
                    $response["message"] = "There's something wrong. Please contact your administrator.";
                }
                else
                {
                    $response['smes'] = $course['smes'];
                    $response['data'] = $survey_questions;
                }

        }

        return json_encode($response);
    }


    public function saveSurvey(Request $request)
    {

        //Save Evaluation Entry
        $check_course_student = Course_student::where('course_id',$request->course_id)->
                        where('user_id',auth()->user()->id);

        $check_evaluation = $check_course_student->first()->toArray();

        if(isset($check_evaluation['evaluation']) && $check_evaluation['evaluation'] == 0)
        {
            $survey_questions = PostEvaluationSurveyQuestions::leftJoin('post_evaluation_questions', 'post_evaluation_survey_questions.peq_id', '=', 'post_evaluation_questions.peq_id')->where('pes_id',$request->pes_id)->get()->toArray();

            $questions = array_column($survey_questions, 'question','peq_id');

            $data_answers = [];
            foreach ($request->question as $key => $value) {
               $check_key = explode('_', $key);
               $data_answers[] = ["course_id"=>$request->course_id,
                                    "pes_id"=>$request->pes_id,
                                    "user_id"=>auth()->user()->id,
                                    "peq_id"=>$check_key[0],
                                    "question"=>isset($questions[$check_key[0]])?$questions[$check_key[0]]:'',
                                    "sme"=>isset($check_key[1])?$check_key[1]:'',
                                    "answer"=>$value,
                                    "date_created"=>date("Y-m-d H:i:s"),
                                   ];
            }

            if(!empty($data_answers))
            {
                CourseEvaluationAnswers::insert($data_answers);
            }

            $check_course_student->update(['evaluation' => 1]);
            //return back()->withFlashSuccess(trans('alerts.frontend.course.completed'));

        }

        //Save Certificate
        $course = Course::whereHas('students', function ($query) {
            $query->where('id', \Auth::id());
        })->where('id', '=', $request->course_id)->first();

        if (($course != null) && ($course->progress() == 100)) {

            $certificate = Certificate::firstOrCreate([
                'user_id' => auth()->user()->id,
                'course_id' => $request->course_id
            ]);

            $data = [
                'name' => auth()->user()->name,
                'course_name' => $course->title,
                'date' => Carbon::now()->format('d M, Y'),
            ];

            $certificate_name = 'Certificate-' . $course->id . '-' . auth()->user()->id . '.pdf';
            $certificate->name = auth()->user()->id;
            $certificate->url = $certificate_name;
            $certificate->save();

            $pdf = \PDF::loadView('certificate.index', compact('data'))->setPaper('', 'landscape');

            $pdf->save(public_path('storage/certificates/' . $certificate_name));

            return back()->withFlashSuccess(trans('alerts.frontend.course.completed'));
        }

        return abort(404);
    }


}
