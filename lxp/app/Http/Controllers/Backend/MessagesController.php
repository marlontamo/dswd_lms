<?php

namespace App\Http\Controllers\Backend;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use Messenger;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        $thread = "";
        $teachers = User::role('teacher')->get()->pluck('name', 'id');
        auth()->user()->load('threads.messages.sender');

        $unreadThreads = [];
        $threads = [];
        foreach (auth()->user()->threads as $item) {
            if ($item->unreadMessagesCount > 0) {
                $unreadThreads[] = $item;
            } else {
                $threads[] = $item;
            }
        }
        $threads = Collection::make(array_merge($unreadThreads, $threads));

        if (request()->has('thread') && ($request->thread != null)) {

            if (request('thread')) {
                $thread = auth()->user()->threads()
                    ->where('message_threads.id', '=', $request->thread)
                    ->first();

                //Read Thread
                auth()->user()->markThreadAsRead($thread->id);
            } else if ($thread == "") {
                abort(404);
            }
        }

        $agent = new Agent();

        if ($agent->isMobile()) {
            $view = 'backend.messages.index-mobile';
        } else {
            $view = 'backend.messages.index-desktop';
        }
        $returndata =  [
            //            'threads' => auth()->user()->threads,
            'threads' => $threads,
            'teachers' => $teachers,
            'thread' => $thread
        ];
        if ($request->return_type == 'json') {
            return response()
                ->json($returndata);
        }
        return view($view, $returndata);
    }

    public function getData(Request $request)
    {
        auth()->user()->load('threads.messages.sender');
        $thread_data =  auth()->user()->threads()
            ->where('message_threads.id', '=', $request->thread)
            ->first();
        $returndata =  [
            'threads' => $thread_data,
            'ud' => auth()->user()->id
        ];
        return response()
            ->json($returndata);
    }

    public function send(Request $request)
    {
        $this->validate($request, [
            'recipients' => 'required',
            'message' => 'required'
        ], [
            'recipients.required' => 'Please select at least one recipient',
            'message.required' => 'Please input your message'
        ]);

        $message = Messenger::from(auth()->user())->to($request->recipients)->message($request->message)->send();
        if (!empty($request->return_type)) {
            if ($request->return_type == "json") {
                return response()
                    ->json(['thread' => $this->getUnreadMessages($request, 'json'), 'message' => $message]);
            }
        }

        return redirect(route('admin.messages') . '?thread=' . $message->thread_id);
    }

    public function reply(Request $request)
    {
        $this->validate($request, [
            'message' => 'required'
        ], [
            'message.required' => 'Please input your message'
        ]);

        $thread = auth()->user()->threads()
            ->where('message_threads.id', '=', $request->thread_id)
            ->first();
        $message = Messenger::from(auth()->user())->to($thread)->message($request->message)->send();

        return redirect(route('admin.messages') . '?thread=' . $message->thread_id)->withFlashSuccess('Message sent successfully');
    }

    public function getUnreadMessages(Request $request)
    {
        $unreadMessageCount = auth()->user()->unreadMessagesCount;
        $unreadThreads = [];
        foreach (auth()->user()->threads as $item) {
            if ($item->unreadMessagesCount > 0) {
                $data = [
                    'thread_id' => $item->id,
                    'message' => str_limit($item->lastMessage->body, 35),
                    'unreadMessagesCount' => $item->unreadMessagesCount,
                    'title' => $item->title
                ];
                $unreadThreads[] = $data;
            }
        }
        return ['unreadMessageCount' => $unreadMessageCount, 'threads' => $unreadThreads];
    }
    public function getNotification()
    {
        $user = User::find(auth()->user()->id);
        return  $user->notifications;
    }

    public function notificationList(Request $request)
    {
        $agent = new Agent();

        if ($agent->isMobile()) {
            $view = 'backend.messages.index-mobile';
        } else {
            $view = 'backend.notification.index-desktop';
        }


        return view($view);
    }

    public function getNotificationList(Request $request)
    {
        # code...
        $user = User::find(auth()->user()->id);
        $returndata =  [
            //            'threads' => auth()->user()->threads,
            'notification' => $user->notifications,
        ];

        return $returndata;
    }

    public function deleteNotification(Request $request)
    {
        DB::table('notifications')->where('id', $request->id)->delete();
        return ['success' => true, 'message' => "Successfully delete"];
    }
}
