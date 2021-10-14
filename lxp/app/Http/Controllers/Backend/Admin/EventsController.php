<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventData;


class EventsController extends Controller
{
    public function index()
    {
        return view('backend.event.index');
    }

    public function store(Request $request)
    {
        $success = true;
        $message = "Success";
        $event = new Event();

        $event->title = $request->title;
        $event->description = $request->description;
        $event->save();
        $parent = $event->id;
        $subTask = [];
        $task = $request->task;
        if (!empty($task)) {
            foreach ($task as $tk => $tv) {
                $event_data = new EventData();
                $event_data->title =   $tv['title'];
                $event_data->parent =   $parent;
                $event_data->save();
                if (!empty($tv['sub'])) {
                    foreach ($tv['sub'] as $sk => $sv) {
                        $subTask[] = [
                            "title" =>   $sv['title'],
                            "sub_parent" =>   $event_data->id,
                            "parent" =>   $parent,
                            "deadline" =>   $sv['deadline'],
                            "complete" => ($sv['complete']) ? 1 : 0,
                        ];
                    }
                }
            }
            if (!empty($subTask))
                EventData::insert($subTask);
        }

        return response()
            ->json(['success' => $success, 'message' => $message]);
    }
}
