<?php

namespace App\Http\Controllers\Backend;

use App\Models\Bundle;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\CourseTimeline;

class ReportController extends Controller
{
    public function getStudentsReport()
    {
        return view('backend.reports.students');
    }

    public function getCourseData(Request $request)
    {

        $courses = Course::ofTeacher()->pluck('id');

        return \DataTables::of($courses)
            ->addIndexColumn()
            ->addColumn('course', function ($q) {
                $course_name = $q->title;
                $course_slug = $q->slug;
                $link = "<a href='".route('courses.show', [$course_slug])."' target='_blank'>".$course_name."</a>";
                return $link;
            })
            ->rawColumns(['course'])
            ->make();
    }

    public function getStudentsData(Request $request){
        // DB::enableQueryLog();

        $courses = Course::ofTeacher()->select(DB::raw("courses.*,SUM(users.gender = 'female') AS count_female,SUM(users.gender = 'male') AS count_male"))
                                      ->leftJoin('course_student', 'courses.id', '=', 'course_student.course_id')
                                      ->leftJoin('users', 'course_student.user_id', '=', 'users.id')
                                      // ->leftJoin('course_timeline', 'courses.id', '=', 'course_timeline.course_id')
                                      ->has('students','>',0)
                                      ->withCount('students')
                                      ->groupBy('courses.id')
                                      ->get()->toArray();
                                      // dd(DB::getQueryLog());

        $course_timelines_data =  CourseTimeline::select(DB::raw("course_id,count(id) as total"))
                                       ->groupBy('course_id')
                                       ->get()->toArray();          

        $course_timelines = [];
        if(!empty($course_timelines_data))
        {
            $course_timelines = array_column($course_timelines_data, "total","course_id");
        }                 


        $accomplished = User::select(DB::raw("users.id as uid,users.first_name,users.middle_name,users.last_name,users.gender,course_student.course_id,COUNT(chapter_students.id) AS completed"))
                         ->leftJoin('course_student',function($join){
                            $join->on('users.id','=','course_student.user_id')
                                 ->whereNotNull('course_student.course_id');
                         }) 
                         ->leftJoin('chapter_students',function($join){
                            $join->on('users.id','=','chapter_students.user_id');
                            $join->on('course_student.course_id','=','chapter_students.course_id');
                         })
                         ->whereNotNull('course_student.course_id')  
                         ->groupBy(DB::raw('course_student.course_id,users.id'))
                         ->get()->toArray();

        $accomplished_per_course = [];

        if(!empty($accomplished))
        {
            foreach ($accomplished as $key => $value) 
            {
                $accomplished_per_course[$value['course_id']][] = $value;
            }                 
        }

        $references = ['course_timelines'=>$course_timelines,'accomplished_per_course'=>$accomplished_per_course];


        $new_courses = array_map(function($arr) use ($references){

            $arr['course_completed'] = 0;

            $new_accomplished = [];
            if(!empty($references['accomplished_per_course'][$arr['id']]))
            {
               $arr['lesson_count'] = $references['course_timelines'][$arr['id']];

               $new_accomplished = array_map(function($child_arr) use ($arr){
                  $child_arr['progress'] = '0%';

                  $child_arr['progress'] = ($arr['lesson_count'] != 0)?(ceil(($child_arr['completed']/$arr['lesson_count'])*100)).'%':'100%';

                  $child_arr['course_complete'] = ($child_arr['progress'] == '100%')?true:false;

                  return $child_arr;

               }, $references['accomplished_per_course'][$arr['id']]);

               $arr['female_completed_count'] = count(array_filter($new_accomplished,function($v){
                    return $v['course_complete'] == 1 && $v['gender'] == 'female';
               }));

               $arr['male_completed_count'] = count(array_filter($new_accomplished,function($v){
                    return $v['course_complete'] == 1 && $v['gender'] == 'male';
               }));

               $arr['course_completed'] = count(array_filter(array_column($new_accomplished, 'course_complete')));
            }

            $arr['students'] = (!empty($references['accomplished_per_course'][$arr['id']]))?$new_accomplished:[];
            return $arr;
        }, $courses);

        return $new_courses;
    }
}
