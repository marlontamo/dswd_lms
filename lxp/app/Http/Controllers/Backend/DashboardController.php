<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Event\Events;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $attendedEvents = NULL;

        $purchased_courses = NULL;
        $students_count = NULL;
        $recent_reviews = NULL;
        $threads = NULL;
        $teachers_count = NULL;
        $courses_count = NULL;
        $recent_contacts = NULL;
        //$purchased_bundles = NULL;
        if (\Auth::check()) {

            $attendedEvents = auth()->user()->attendedEvents();

            $purchased_courses = auth()->user()->purchasedCourses();

            if(auth()->user()->hasRole('teacher')){
                //IF logged in user is teacher
                $students_count = Course::whereHas('teachers', function ($query) {
                    $query->where('user_id', '=', auth()->user()->id);
                })
                    ->withCount('students')
                    ->get()
                    ->sum('students_count');


                $courses_id = auth()->user()->courses()->has('reviews')->pluck('id')->toArray();
                $recent_reviews = Review::where('reviewable_type','=','App\Models\Course')
                    ->whereIn('reviewable_id',$courses_id)
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();



                $unreadThreads = [];
                $threads = [];
                if(auth()->user()->threads){
                    foreach(auth()->user()->threads as $item){
                        if($item->unreadMessagesCount > 0){
                            $unreadThreads[] = $item;
                        }else{
                            $threads[] = $item;
                        }
                    }
                    $threads = Collection::make(array_merge($unreadThreads,$threads))->take(10) ;

                }

            }elseif(auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('admin')){
                $students_count = User::role('student')->count();
                $teachers_count = User::role('teacher')->count();
                $courses_count = \App\Models\Course::all()->count(); // + \App\Models\Bundle::all()->count();
                $recent_contacts = Contact::orderBy('created_at','desc')->take(10)->get();
            }
        }

        return view('backend.dashboard',compact('attendedEvents','purchased_courses','students_count','recent_reviews','threads','teachers_count','courses_count','recent_contacts'));
    }
}
