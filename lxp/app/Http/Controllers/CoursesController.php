<?php

namespace App\Http\Controllers;

use App\Models\Blog;
//use App\Models\Bundle;
use App\Models\Category;
use App\Models\Auth\User;
use App\Models\Course;
use App\Models\CourseTimeline;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Notifications\EnrollNotification;
use Illuminate\Support\Facades\Notification;
use QCod\Gamify\Gamify;
use App\Gamify\Points\EnrollCourse;

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Cart;
use Auth;

class CoursesController extends Controller
{

    private $path;

    public function __construct()
    {
        $path = 'frontend';
        $this->path = $path;
    }

    public function all()
    {
        if (request('type') == 'featured') {
            $courses = Course::withoutGlobalScope('filter')->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(9);
        } else {
            $courses = Course::withoutGlobalScope('filter')->where('published', 1)->orderBy('id', 'desc')->paginate(9);
        }
        $purchased_courses = NULL;
        $purchased_bundles = NULL;
        $categories = Category::where('status', '=', 1)->get();

        if (\Auth::check()) {
            $purchased_courses = Course::withoutGlobalScope('filter')->whereHas('students', function ($query) {
                $query->where('id', \Auth::id());
            })
                ->with('lessons')
                ->orderBy('id', 'desc')
                ->get();
        }
        $featured_courses = Course::withoutGlobalScope('filter')->where('published', '=', 1)
            ->where('featured', '=', 1)->take(8)->get();

        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        return view($this->path . '.courses.index', compact('courses', 'purchased_courses', 'recent_news', 'featured_courses', 'categories'));
    }

    public function show($course_slug)
    {
        $continue_course = NULL;
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $course = Course::withoutGlobalScope('filter')->where('slug', $course_slug)->with('publishedLessons')->firstOrFail();

        $purchased_course = \Auth::check() && $course->students()->where('user_id', \Auth::id())->count() > 0;
        if (($course->published == 0) && ($purchased_course == false)) {
            abort(404);
        }
        $course_rating = 0;
        $total_ratings = 0;
        $completed_lessons = "";
        $is_reviewed = false;
        if (auth()->check() && $course->reviews()->where('user_id', '=', auth()->user()->id)->first()) {
            $is_reviewed = true;
        }
        if ($course->reviews->count() > 0) {
            $course_rating = $course->reviews->avg('rating');
            $total_ratings = $course->reviews()->where('rating', '!=', "")->get()->count();
        }
        $lessons = $course->courseTimeline()->orderby('sequence', 'asc')->get();

        if (\Auth::check()) {

            $completed_lessons = \Auth::user()->chapters()->where('course_id', $course->id)->get()->pluck('model_id')->toArray();
            $course_lessons = $course->lessons->pluck('id')->toArray();
            $continue_course  = $course->courseTimeline()
                ->whereIn('model_id', $course_lessons)
                ->orderby('sequence', 'asc')
                ->whereNotIn('model_id', $completed_lessons)

                ->first();
            if ($continue_course == null) {
                $continue_course = $course->courseTimeline()
                    ->whereIn('model_id', $course_lessons)
                    ->orderby('sequence', 'asc')->first();
            }
        }

        $date = date("Y-m-d");

        $can_enroll = ($date >= $course->start_date && $date <= $course->end_date) ? TRUE : FALSE;

        $print_enroll = "";


        if ($date < $course->start_date) {
            $print_enroll = "Enrollment for this course will be available: \n  " . date("F d", strtotime($course->start_date)) . " until " . date("F d Y", strtotime($course->end_date));
        } elseif ($date > $course->end_date) {
            $print_enroll = "Enrollment for this course has ended";
        } elseif ($date >= $course->start_date && $date <= $course->end_date) {
            $print_enroll = "Enrollment for this course will end on " . date("F d, Y", strtotime($course->end_date));
        }
        $valid_user_type = false;
        if (auth()->check()) {
            $valid_user_type = ($course->user_type === auth()->user()->user_type || $course->user_type === "all") ? TRUE : FALSE;
            if ($course->user_type === "internal" && auth()->user()->user_type === "external") {


                $print_enroll = "sorry This course is only available for Internal or DSWD personnel only";
            } elseif ($course->user_type === "external" && auth()->user()->user_type === "internal") {

                $print_enroll = "sorry This course is only available for external personnel only";
            }
        }

        //ADD prerequisite
        $get_all_prereq_lessons = [];
        if (!empty($course->prerequisite)) {
            $get_all_prereq_lessons = Course::whereIn('id', $course->prerequisite)->select('id', 'title', 'slug')->get()->toArray();
        }
        //ADD prerequisite


        $compactdata = compact('course', 'purchased_course', 'recent_news', 'course_rating', 'completed_lessons', 'total_ratings', 'is_reviewed', 'lessons', 'continue_course', 'can_enroll', 'print_enroll', 'get_all_prereq_lessons', 'valid_user_type');
        // echo "<pre>";
        //dd($compactdata);
        // die();
        return view($this->path . '.courses.course', $compactdata);
    }



    public function rating($course_id, Request $request)
    {
        $course = Course::findOrFail($course_id);
        $course->students()->updateExistingPivot(\Auth::id(), ['rating' => $request->get('rating')]);

        return redirect()->back()->with('success', 'Thank you for rating.');
    }

    public function getByCategory(Request $request)
    {
        $category = Category::where('slug', '=', $request->category)
            ->where('status', '=', 1)
            ->first();
        $categories = Category::where('status', '=', 1)->get();

        if ($category != "") {
            $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
            $featured_courses = Course::where('published', '=', 1)
                ->where('featured', '=', 1)->take(8)->get();

            if (request('type') == 'featured') {
                $courses = $category->courses()->withoutGlobalScope('filter')->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(9);
            } else {
                $courses = $category->courses()->withoutGlobalScope('filter')->where('published', 1)->orderBy('id', 'desc')->paginate(9);
            }


            return view($this->path . '.courses.index', compact('courses', 'category', 'recent_news', 'featured_courses', 'categories'));
        }
        return abort(404);
    }

    public function addReview(Request $request)
    {
        $this->validate($request, [
            'review' => 'required'
        ]);
        $course = Course::findORFail($request->id);
        $review = new Review();
        $review->user_id = auth()->user()->id;
        $review->reviewable_id = $course->id;
        $review->reviewable_type = Course::class;
        $review->rating = $request->rating;
        $review->content = $request->review;
        $review->save();

        return back();
    }

    public function editReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $course = $review->reviewable;
            $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
            $purchased_course = \Auth::check() && $course->students()->where('user_id', \Auth::id())->count() > 0;
            $course_rating = 0;
            $total_ratings = 0;
            $lessons = $course->courseTimeline()->orderby('sequence', 'asc')->get();

            if ($course->reviews->count() > 0) {
                $course_rating = $course->reviews->avg('rating');
                $total_ratings = $course->reviews()->where('rating', '!=', "")->get()->count();
            }
            if (\Auth::check()) {

                $completed_lessons = \Auth::user()->chapters()->where('course_id', $course->id)->get()->pluck('model_id')->toArray();
                $continue_course  = $course->courseTimeline()->orderby('sequence', 'asc')->whereNotIn('model_id', $completed_lessons)->first();
                if ($continue_course == "") {
                    $continue_course = $course->courseTimeline()->orderby('sequence', 'asc')->first();
                }
            }
            return view($this->path . '.courses.course', compact('course', 'purchased_course', 'recent_news', 'completed_lessons', 'continue_course', 'course_rating', 'total_ratings', 'lessons', 'review'));
        }
        return abort(404);
    }


    public function updateReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $review->rating = $request->rating;
            $review->content = $request->review;
            $review->save();

            return redirect()->route('courses.show', ['slug' => $review->reviewable->slug]);
        }
        return abort(404);
    }

    public function deleteReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $slug = $review->reviewable->slug;
            $review->delete();
            return redirect()->route('courses.show', ['slug' => $slug]);
        }
        return abort(404);
    }

    public function getNow(Request $request)
    {

        $course_check = null;
        $completed_prereq_lessons = 1;
        //ADD Prerequisite
        $course_check = Course::where('id', $request->course_id)->with('teachers')->first();
        $teacher_id = [];
        if (!empty($course_check->teachers)) {
            foreach ($course_check->teachers as $eck => $ecv) {
                $teacher_id[] = $ecv->id;
            }
        }

        $completed_prereq_lessons = 0;
        $get_all_prereq_lessons = 0;

        if (!empty($course_check->prerequisite)) {
            $completed_prereq_lessons = \Auth::user()->chapters()->whereIn('course_id', $course_check->prerequisite)->get()->count();
            $get_all_prereq_lessons = CourseTimeline::whereIn('course_id', $course_check->prerequisite)->get()->count();
        }

        //ADD Prerequisite
        if ($completed_prereq_lessons == $get_all_prereq_lessons || $course_check == null) {

            $c_id = $request->course_id;
            $course = Course::findOrFail($c_id);
            $course->students()->attach(auth()->user()->id);
            Session::flash('success', trans('labels.frontend.cart.purchase_successful'));
            $enrollData = [
                'title' => "New Course enrolled: <b>" . $course_check->title . "</b>",
                'body' => $course_check->description,
                'course_image' => $course_check->course_image,
                'course_id' => $c_id
            ];
            $userSchema = User::whereIn('id', $teacher_id)->get();
            Notification::send($userSchema, new EnrollNotification($enrollData));
            $testSch = \Auth::user();
            givePoint(new EnrollCourse($testSch));
            return back();
        }


        return back()->withErrors(['Please finish all prerequisite courses to be able to enroll for this course.', 'The Message']);
    }
}
