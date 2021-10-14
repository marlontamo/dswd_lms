<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Config;
use App\Models\Course;
use App\Models\CourseTimeline;
use App\Models\Faq;
use App\Models\Lesson;
use App\Models\Page;
use App\Models\Sponsor;
use App\Models\System\Session;
use App\Models\Tag;
use App\Models\Expertise;
use App\Models\DirCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Gamify\Points\PageVisit;

/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */

    private $path;

    public function __construct()
    {

        $path = 'frontend';
        $this->path = $path;
    }

    public function index()
    {
        if (request('page')) {
            $page = Page::where('slug', '=', request('page'))
                ->where('published', '=', 1)->first();
            if ($page != "") {
                $pointsTitle = "";
                if ($page->slug == "about-us") {
                    $pointsTitle = "AboutUsPage";
                }
                if ($pointsTitle != "") {
                    givePoint(new PageVisit($pointsTitle));
                }
                return view($this->path . '.pages.index', compact('page'));
            }

            abort(404);
        }
        $type = config('theme_layout');
        $sections = Config::where('key', '=', 'layout_' . $type)->first();
        $sections = json_decode($sections->value);

        $featured_courses = Course::withoutGlobalScope('filter')->where('published', '=', 1)
            ->whereHas('category')
            ->where('featured', '=', 1)->take(8)->get();

        //$course_categories = Category::with('courses')->where('icon', '!=', "")->take(12)->get();

        //$teachers = User::role('teacher')->with('courses')->where('active', '=', 1)->take(7)->get();

        //$sponsors = Sponsor::where('status', '=', 1)->get();

        //$news = Blog::orderBy('created_at', 'desc')->take(2)->get();

        //$faqs = Category::with('faqs')->get()->take(6);

        // if ((int)config('counter') == 1) {
        //     $total_students = config('total_students');
        //     $total_courses = config('total_courses');
        //     $total_teachers = config('total_teachers');
        // } else {
        $total_courses = Course::where('published', '=', 1)->get()->count();
        //$total_bundle = Bundle::where('published', '=', 1)->get()->count();
        //$total_students = User::role('student')->get()->count();
        //$total_courses = $total_course;
        //$total_teachers = User::role('teacher')->get()->count();
        //}

        $categories = Category::get();

        return view('frontend.index', compact('featured_courses', 'total_courses', 'sections', 'categories'));
        //return view($this->path . '.index-' . config('theme_layout'), compact( 'featured_courses', 'sponsors', 'total_students', 'total_courses', 'total_teachers', 'news' , 'teachers', 'faqs', 'course_categories', 'sections','categories'));
    }

    public function getFaqs()
    {
        $faq_categories = Category::has('faqs', '>', 0)->get();
        return view($this->path . '.faq', compact('faq_categories'));
    }

    public function getTeachers()
    {
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $teachers = User::role('teacher')->paginate(12);
        return view($this->path . '.teachers.index', compact('teachers', 'recent_news'));
    }

    public function showTeacher(Request $request)
    {
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $teacher = User::role('teacher')->where('id', '=', $request->id)->first();
        $courses = $teacher->courses;
        if (count($teacher->courses) > 0) {
            $courses = $teacher->courses()->paginate(12);
        }
        return view($this->path . '.teachers.show', compact('teacher', 'recent_news', 'courses'));
    }

    public function getDownload(Request $request)
    {
        if (auth()->check()) {
            $lesson = Lesson::findOrfail($request->lesson);
            $course_id = $lesson->course_id;
            $course = Course::findOrfail($course_id);
            $purchased_course = \Auth::check() && $course->students()->where('user_id', \Auth::id())->count() > 0;
            if ($purchased_course) {
                $file = public_path() . "/storage/uploads/" . $request->filename;

                return Response::download($file);
            }
            return abort(404);
        }
        return abort(404);
    }

    public function searchCourse(Request $request)
    {

        $date_today = date("Y-m-d");

        if (request('type') == 'featured') {
            $courses = Course::withoutGlobalScope('filter')->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(12);
        } else {
            $courses = Course::withoutGlobalScope('filter')->where('published', 1)->orderBy('id', 'desc')->paginate(12);
        }


        if ($request->category != null) {
            $category = Category::find((int)$request->category);
            if ($category) {
                $ids = $category->courses->pluck('id')->toArray();
                $types = ['featured'];
                if ($category) {

                    if (in_array(request('type'), $types)) {
                        $type = request('type');
                        $courses = $category->courses()->where(function ($query) use ($request) {
                            $query->where('title', 'LIKE', '%' . $request->q . '%');
                            $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
                        })
                            ->whereIn('id', $ids)
                            ->where('published', '=', 1)
                            ->where($type, '=', 1)
                            ->paginate(12);
                    } else {
                        $courses = $category->courses()
                            ->where(function ($query) use ($request) {
                                $query->where('title', 'LIKE', '%' . $request->q . '%');
                                $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
                            })
                            ->where('published', '=', 1)
                            ->whereIn('id', $ids)
                            ->paginate(12);
                    }
                }
            }
        } else {
            $courses = Course::where('published', '=', 1)
                ->where(function ($query) use ($request) {
                    $query->where('title', 'LIKE', '%' . $request->q . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->q . '%');
                })
                ->paginate(12);
        }

        $categories = Category::where('status', '=', 1)->get();


        $q = $request->q;
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();

        return view($this->path . '.search-result.courses', compact('courses', 'q', 'recent_news', 'categories'));
    }


    public function searchBundle(Request $request)
    {

        if (request('type') == 'featured') {
            $bundles = Bundle::withoutGlobalScope('filter')->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(12);
        } else {
            $bundles = Bundle::withoutGlobalScope('filter')->where('published', 1)->orderBy('id', 'desc')->paginate(12);
        }


        if ($request->category != null) {
            $category = Category::find((int)$request->category);
            $ids = $category->bundles->pluck('id')->toArray();
            $types = ['featured'];
            if ($category) {

                if (in_array(request('type'), $types)) {
                    $type = request('type');
                    $bundles = $category->bundles()->where(function ($query) use ($request) {
                        $query->where('title', 'LIKE', '%' . $request->q . '%');
                        $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
                    })
                        ->whereIn('id', $ids)
                        ->where('published', '=', 1)
                        ->where($type, '=', 1)
                        ->paginate(12);
                } else {
                    $bundles = $category->bundles()
                        ->where(function ($query) use ($request) {
                            $query->where('title', 'LIKE', '%' . $request->q . '%');
                            $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
                        })
                        ->where('published', '=', 1)
                        ->whereIn('id', $ids)
                        ->paginate(12);
                }
            }
        } else {
            $bundles = Bundle::where('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('description', 'LIKE', '%' . $request->q . '%')
                ->where('published', '=', 1)
                ->paginate(12);
        }

        $categories = Category::where('status', '=', 1)->get();


        $q = $request->q;
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();

        return view($this->path . '.search-result.bundles', compact('bundles', 'q', 'recent_news', 'categories'));
    }

    public function searchBlog(Request $request)
    {
        $blogs = Blog::where('title', 'LIKE', '%' . $request->q . '%')
            ->paginate(12);
        $categories = Category::has('blogs')->where('status', '=', 1)->paginate(10);
        $popular_tags = Tag::has('blogs', '>', 4)->get();


        $q = $request->q;
        return view($this->path . '.search-result.blogs', compact('blogs', 'q', 'categories', 'popular_tags'));
    }

    public function getExpertise(Request $request)
    {
        $cattype = $request->type;

        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        //$expertise = Expertise::where('cat_type',"=",$cattype)->paginate(12);
        $expertise = Expertise::join('dir_category', 'dir_expertise.category_id', '=', 'dir_category.id')
            ->select('*', 'dir_expertise.id as exp_id')->where('cat_type', "=", $cattype)->get()->groupBy('name');

        //var_dump($expertise->toarray());

        return view($this->path . '.expertise.index', compact('expertise', 'recent_news', 'cattype'));
    }

    public function showExpertise(Request $request)
    {
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $expertise = Expertise::with('category')->findOrFail($request->id);
        //var_dump($expertise);
        return view($this->path . '.expertise.show', compact('expertise', 'recent_news'));
    }
}
