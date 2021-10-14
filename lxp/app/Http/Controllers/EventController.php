<?php

namespace App\Http\Controllers;

use App\Gamify\Points\PageVisit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event\Event_activities;
use App\Models\Event\Events;
use App\Models\Event\Eventact_users;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use App\Models\Category;
use App\Models\PostEvaluationSurveyQuestions;
use App\Models\PostEvaluationAnswers;

class EventController extends Controller
{

    private $path;

    public function __construct()
    {
        date_default_timezone_set('Asia/Manila');
        $path = 'frontend';
        $this->path = $path;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Events::with('category')->paginate(9);
        $categories = Category::where('status', '=', 1)->get();
        $recent_events = Events::orderBy('created_at', 'desc')->take(2)->get();
        $userSchem = \Auth::user();
        givePoint(new PageVisit("EventPage"));
        return view($this->path . '.event.index', compact('events', 'categories', 'recent_events'));
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
    public function show($event_slug)
    {
        $event = "";
        $registered_event = "";
        $participants = "";
        $activities = "";
        $completed_acts = [];

        if ($event_slug) {

            $event = Events::withoutGlobalScope('filter')->where('slug', $event_slug)->with('activities')->firstOrFail();
            $registered_event = \Auth::check() && $event->participants()->where('user_id', \Auth::id())->count() > 0;

            $participants = $event->participants;
            $activities     = $event->activities;


            $activities_id = [];
            $with_attendance = [];
            $activate_post_eval = [];

            if (!empty($activities->toArray())) {
                $activities_id = array_column($activities->toArray(), 'id');
                $with_attendance = Eventact_users::where('event_id', '=', $event->id)->whereIn('eventact_id', $activities_id)->get()->toArray();

                foreach ($activities as $key => $value) {
                    if (!empty($with_attendance) && in_array($value->id, array_column($with_attendance, 'eventact_id'))) {
                        $activate_post_eval[$value->id] = true;
                    } else {
                        $activate_post_eval[$value->id] = false;
                    }
                }
            }


            if (\Auth::check()) {
                $completed_acts = \Auth::user()->eventActivities()->where('event_id', $event->id)->get()->pluck('eventact_id')->toArray();
            }
        }
        return view($this->path . '.event.show', compact('event', 'registered_event', 'participants', 'activities', 'completed_acts', 'activate_post_eval'));
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

    public function register(Request $request)
    {

        if ($request->event_id != null) {
            $event_id = $request->event_id;
            $office = $request->office;
            $odsu = $request->odsu;
            $org = $request->org;
            $reason = $request->reason;
            $event = Events::findOrFail($event_id);
            $event->participants()->attach(auth()->user()->id, ['reason' => $reason, 'odsu' => $odsu, 'office' => $office, 'org' => $org]);
            Session::flash('success', 'You have Successfully registered. You may now join the activity.');
            return back();
        }

        return back()->withErrors('Error');
    }

    public function eventactProgress(Request $request)
    {
        $response = ["success" => true, "message" => "sucess"];
        if (\Auth::check()) {
            $eventact = Event_activities::where('id', $request->activity_id)->first();
            if ($eventact != null) {
                if ($eventact->eventactUsers()->where('user_id', \Auth::id())->get()->count() == 0) {
                    Eventact_users::create([
                        'eventact_id' => $request->activity_id,
                        'user_id' => auth()->user()->id,
                        'event_id' => $eventact->event_id
                    ]);
                    $response["success"] = true;
                }
            } else {
                $response["success"] = false;
                $response["message"] = "There's something wrong. Please contact your administrator.";
            }
        }

        return json_encode($response);
    }

    public function getDownload(Request $request)
    {
        if (auth()->check()) {
            $eventact = Event_activities::findOrfail($request->eventact_id);
            $event_id = $eventact->event_id;
            $event = Events::findOrfail($event_id);

            $attended_event = \Auth::check() && $event->participants()->where('user_id', \Auth::id())->count() > 0;

            if ($attended_event) {
                $file = public_path() . "/storage/uploads/" . $request->filename;

                return Response::download($file);
            }
            return abort(404);
        }
        return abort(404);
    }

    public function surveyQuestions(Request $request)
    {
        $response = ["success" => true, "message" => "sucess", "data" => []];
        $survey_questions = [];
        if (\Auth::check()) {
            $eventact = Event_activities::where('id', $request->activity)->first()->toArray();
            $survey_questions = PostEvaluationSurveyQuestions::leftJoin('post_evaluation_questions', 'post_evaluation_survey_questions.peq_id', '=', 'post_evaluation_questions.peq_id')->where('pes_id', $request->pes_id)->get()->toArray();

            if (empty($survey_questions)) {
                $response["success"] = false;
                $response["message"] = "There's something wrong. Please contact your administrator.";
            } else {
                $response['smes'] = $eventact['smes'];
                $response['data'] = $survey_questions;
            }
        }

        return json_encode($response);
    }


    public function saveSurvey(Request $request)
    {

        $check_eventact_user = Eventact_users::where('eventact_id', $request->activity)->where('user_id', auth()->user()->id)->where('event_id', $request->event);

        $check_evaluation = $check_eventact_user->first()->toArray();

        if (isset($check_evaluation['evaluation']) && $check_evaluation['evaluation'] == 0) {
            $survey_questions = PostEvaluationSurveyQuestions::leftJoin('post_evaluation_questions', 'post_evaluation_survey_questions.peq_id', '=', 'post_evaluation_questions.peq_id')->where('pes_id', $request->survey)->get()->toArray();

            $questions = array_column($survey_questions, 'question', 'peq_id');

            $data_answers = [];
            foreach ($request->question as $key => $value) {
                $check_key = explode('_', $key);
                $data_answers[] = [
                    "event_id" => $request->event,
                    "activity_id" => $request->activity,
                    "pes_id" => $request->survey,
                    "user_id" => auth()->user()->id,
                    "peq_id" => $check_key[0],
                    "question" => isset($questions[$check_key[0]]) ? $questions[$check_key[0]] : '',
                    "sme" => isset($check_key[1]) ? $check_key[1] : '',
                    "answer" => $value,
                    "date_created" => date("Y-m-d H:i:s"),
                ];
            }

            if (!empty($data_answers)) {
                PostEvaluationAnswers::insert($data_answers);
            }

            $check_eventact_user->update(['evaluation' => 1]);
        }

        return redirect()->back();
    }
}
