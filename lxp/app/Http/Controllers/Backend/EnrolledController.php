<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Course;
use App\Models\Test;
use App\Models\TestsResult;
use App\Models\ChapterStudent;

class EnrolledController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$courses = Course::has('category')->ofTeacher()->pluck('title', 'id')->prepend('Please select', '');
        return view('backend.enrolled.index');
    }
    public function getCourses(){
        $courses = Course::has('category')->ofTeacher()->pluck('title', 'id')->prepend('Please select', '');
        return $courses;
    }

    public function getData(Request $request){
        $courses = Course::findOrFail($request->get('course_id'));
        $students = $courses->students->toArray();
        $tests = $courses->tests->toArray();

        $student_ids = array_column($students,'id');
        $test_ids = array_column($tests,'id');

        $test_result = TestsResult::whereIn('test_id', $test_ids)->whereIn('user_id', $student_ids)->get()->groupBy('user_id')->map->keyBy('test_id')->toArray();

        $timeline = 0;
        $main_chapter_timeline = $courses->lessons()->pluck('id')->merge($courses->tests()->pluck('id'));
         
        //$student_chapters = ChapterStudent::whereIn('user_id', $student_ids)->where('course_id',$request->get('course_id'))->count()->groupBy('user_id')->toArray();
        
        $student_chapters = DB::table('chapter_students')
             ->select('user_id', DB::raw('count(*) as total'))
             ->where('course_id',$request->get('course_id'))
             ->groupBy('user_id')
             ->pluck('total','user_id')->all();

        $student_list = array();

        foreach ($students as $skey => $svalue) {
            $s_id = $svalue["id"];

            $progress = 0;
            if(isset( $student_chapters[$s_id] )){
                $progress = intval($student_chapters[$s_id] / $main_chapter_timeline->count() * 100);
            }

            $svalue["progress"][] = $progress . "%";
            
            foreach ($tests as $tkey => $tvalue) {
                $t_id = $tvalue["id"];
                
                $tr = isset( $test_result[$s_id][$t_id] )? $test_result[$s_id][$t_id] : 0;
                
                $dt_test = $tvalue;
                $dt_test["score"] = isset( $tr["test_result"] ) ? $tr["test_result"] : 0;

                $svalue['tests'][] = $dt_test;
            }
            $student_list[] = $svalue;
        }
        
        return $student_list;
    }

    public function getTestResult(Request $request){
        //print_r("Sample");

        $testid = $request->get('testid');
        $userid = $request->get('userid');

        $lesson = Test::where('id', $testid)->where('published', '=', 1)->firstOrFail();
        $lesson->full_text = $lesson->description;
        $test_result = NULL;
        if ($lesson) {
            $test_result = TestsResult::where('test_id', $lesson->id)
                ->where('user_id', $userid)
                ->first();
        }
        
        $course_lessons = ($lesson->course->tests ) ? $lesson->course->tests->pluck('id')->toArray() : [];        
        $test_exists = FALSE;

        if (get_class($lesson) == 'App\Models\Test') {
            $test_exists = TRUE;
        }

        return view('backend.enrolled.edit', compact('lesson', 'test_result', 'test_exists', 'course_lessons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
