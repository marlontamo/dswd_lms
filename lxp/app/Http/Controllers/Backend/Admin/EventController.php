<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Auth\User;
use App\Models\Event\Events;
use App\Models\Event\Eventact_users;
use App\Models\Event\Event_categories;
use function foo\func;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Events.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('show_deleted') == 1) {
            $swdforum = Events::onlyTrashed()->get();
        } else {
            $swdforum = Events::get();
        }

        return view('backend.event.index', compact('swdforum'));
    }

    /**
     * Display a listing of Events via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        
        if (request('show_deleted') == 1) {
            $event = Events::onlyTrashed()->orderBy('created_at', 'desc')->get();
        } else if (request('cat_id') != "") {
            $event = Events::where('category_id', '=', request('cat_id'))->orderBy('created_at', 'desc')->get();
        }else {
            $event = Events::orderBy('created_at', 'desc')->get();
        }

        $has_view = true;
        $has_edit = true;
        $has_delete = true;

        return DataTables::of($event)
            ->addIndexColumn()
            ->addColumn('type', function ($q){
                return $q->category->name;
            })
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.event', 'label' => 'lesson', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.event.show', ['event' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.event.edit', ['event' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.event.destroy', ['event' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                if($q->published == 1){
                    $type = 'action-unpublish';
                }else{
                    $type = 'action-publish';
                }

                $view .= view('backend.datatable.'.$type)
                    ->with(['route' => route('admin.event.publish', ['event' => $q->id])])->render();
                return $view;

            })
            ->editColumn('event_image', function ($q) {
                return ($q->event_image != null) ? '<img height="50px" src="' . asset('storage/uploads/' . $q->event_image) . '">' : 'N/A';
            })
            ->editColumn('status', function ($q) {
                $text = "";
                $text = ($q->published == 1) ? "<p class='text-white mb-1 font-weight-bold text-center bg-green p-1 mr-1' > Active </p>" : "<p class='text-white mb-1 font-weight-bold text-center bg-dark p-1 mr-1' > Inactive </p>";
                return $text;
            })
            ->addColumn('duration', function ($q) {
                $st_date = date("F j, Y", strtotime($q->start_date));
                $end_date = date("F j, Y", strtotime($q->end_date));
                $text = $st_date . " to " . $end_date;
                return $text;
            })
            ->addColumn('activities', function ($q) {
                $activities = '<a href="' . route('admin.eventacts.create', ['event_id' => $q->id]) . '" class="btn btn-success mb-1"><i class="fa fa-plus-circle"></i></a>  
                <a href="' . route('admin.eventacts.index', ['event_id' => $q->id]) . '" class="btn mb-1 btn-warning text-white"><i class="fa fa-arrow-circle-right"></a>';
                return $activities;
            })
            ->addColumn('participants', function ($q) {
                $participants = count($q->participants) . '  <a href="' . route('admin.eventparticipants', ['event_id' => $q->id]) . '" class="btn mb-1 btn-warning text-white"><i class="fa fa-arrow-circle-right"></a>';
                return $participants;  
            })
            ->rawColumns(['event_image', 'actions', 'status','activities','participants'])
            ->make();
    }


    /**
     * Show the form for creating new Event.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $event = Events::pluck('title','id');
        $categories = Event_categories::pluck('name','id');
        
        return view('backend.event.create', compact('event','categories'));
    }

    /**
     * Store a newly created Event in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->all();

        $request = $this->saveMultipleFiles($request);

        $event = Events::create($request->except('event_poster'));
        $event->slug = str_slug($request->title);
        if (($request->event_poster != "") || $request->event_poster != null) {
            $event->event_poster = json_encode($request->event_poster);
        }
        $event->save();

        return redirect()->route('admin.event.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Swdforum.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Events::findOrFail($id);
        $categories = Event_categories::pluck('name','id');
        return view('backend.event.edit', compact('event','categories'));
    }

    /**
     * Update swdforum in storage.
     *
     * @param  \Illuminate\Http\Requests $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Events::findOrFail($id);
        $request = $this->saveMultipleFiles($request);
        $event->update($request->except('event_poster'));
        
        if (($request->event_poster != "") || $request->event_poster != null) {
            $event->event_poster = json_encode($request->event_poster);
            $event->save();
        }
        return redirect()->route('admin.event.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


    /**
     * Display swdforums.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Events::findOrFail($id);
        $participants = $event->participants;
        $activities = $event->activities;
        return view('backend.event.show', compact('event','participants','activities'));
    }


    /**
     * Remove event from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Events::findOrFail($id);
        $event->delete();
        return redirect()->route('admin.event.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected event at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Events::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore event from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $event = Events::onlyTrashed()->findOrFail($id);
        $event->restore();

        return redirect()->route('admin.event.index')->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Swdforum from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        $event = Events::onlyTrashed()->findOrFail($id);
        $event->forceDelete();

        return redirect()->route('admin.event.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Publish / Unpublish swdforum
     *
     * @param  Request
     */
    public function publish($id)
    {
        $event = Events::findOrFail($id);
        if ($event->published == 1) {
            $event->published = 0;
        } else {
            $event->published = 1;
        }
        $event->save();

        return back()->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Display a listing of Participants.
     *
     * @return \Illuminate\Http\Response
     */
    public function participants(Request $request)
    {
        $events = Events::pluck('title', 'id')->prepend('Please select', '');
        return view('backend.event.participants', compact('events'));
    }

    /**
     * Display a listing of Swdforum via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getParticipants(Request $request)
    {

        $event = Events::withoutGlobalScope('filter')->where('id', $request->event_id)->with('activities','participants','participants.provinces','participants.municipality')->firstOrFail();

        // $p_totalActs = DB::table('eventact_users')->select('user_id', DB::raw('count(*) as total'))
        // ->where('event_id',$request->get('event_id'))->groupBy('user_id')->pluck('total','user_id')->all();

        $participants   = $event->participants;
        $activities     = $event->activities;
        $act_count      = $activities->count();
        $activities     = $activities->toArray();
        $event_act      = [];

        $participants_acts = Eventact_users::where('event_id',$request->get('event_id'))->get();
        $p_totalActs = [];
        
        foreach ($participants as $key => $value) {

            $p_id = $value->id;
            $event_act[$p_id] = [];

            foreach ($activities as $act_key => $act_value) {

                $act_id = $act_value["id"];

                $event_act[$p_id][$act_id]["title"] = $act_value["title"];
                $event_act[$p_id][$act_id]["activity_image"] = $act_value["activity_image"];
                $event_act[$p_id][$act_id]["activity_date"] = $act_value["activity_date"];
                $event_act[$p_id][$act_id]["link"] = $act_value["link"];
                $event_act[$p_id][$act_id]["attended"] = "NO";

                foreach ($participants_acts as $pa_key => $pa_value) {
                    if($pa_value->eventact_id == $act_id && $pa_value->user_id == $p_id ){
                        $p_totalActs[$p_id] = (isset($p_totalActs[$p_id]) ? $p_totalActs[$p_id] + 1 : 1);

                        $event_act[$p_id][$act_id]["attended"] = "YES";
                    }
                }
            }
        }

        return DataTables::of($participants)
            ->addIndexColumn()
            ->addColumn('event_act', function ($q) use ($event_act){
                return $event_act[$q->id];
            })
            ->addColumn('reason', function ($q){
                return $q->pivot->reason;
            })
            ->addColumn('odsu', function ($q){
                return $q->pivot->odsu;
            })
            ->addColumn('office', function ($q){
                return $q->pivot->office;
            })
            ->addColumn('prov', function ($q){
                return $q->provinces->province_name;
            })
            ->addColumn('mun', function ($q){
                return $q->municipality->city_name;
            })
            ->addColumn('progress', function ($q) use ($p_totalActs, $activities,$act_count) {
                $progress = 0;
                if(isset( $p_totalActs[$q->id] )){
                    $progress = intval($p_totalActs[$q->id] / $act_count * 100);
                }

                $progress_html ='<div class="progress my-2">
                    <div class="progress-bar"
                         style="width:' . $progress . '%">' . $progress . '%
                    </div>
                </div>';
    
                return $progress_html;
            })
            ->rawColumns(['progress'])
            ->make();
    }

    public function swdforumReport(){
        
        $swdforum = Events::All();
        return view('backend.swdforum.report', compact('swdforum'));

    }

    public function getswdforumReport(Request $request){

    }

//////////////////////////////////////////////// Events Category ////////////////////////////////////////////////////

    /**
     * Display a listing of Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function category()
    {
        if (request('show_deleted') == 1) {
            $categories = Event_categories::onlyTrashed()->get();
        } else {
            $categories = Event_categories::all();
        }

        return view('backend.event.category', compact('categories'));
    }

    /**
     * Display a listing of Courses via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCatData(Request $request)
    {
        $has_view = true;
        $has_edit = true;
        $has_delete = true;
        $categories = "";

        if (request('show_deleted') == 1) {
            $categories = Event_categories::onlyTrashed()->orderBy('created_at', 'desc')->get();
        } else {
            $categories = Event_categories::orderBy('created_at', 'desc')->get();
        }

        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                $allow_delete = false;

                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.eventcategory', 'label' => 'category', 'value' => $q->id]);
                }

                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.event.cat_edit', ['category' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $data = $q->events->count();
                    if($data == 0){
                        $allow_delete = true;
                    }
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.event.cat_destroy', ['category' => $q->id]),'allow_delete'=> $allow_delete])
                        ->render();
                    $view .= $delete;
                }

                $view .= '<a class="btn btn-warning mb-1" href="' . route('admin.event.index') . "?cat_id=" . $q->id . '">Events</a>';
                return $view;

            })
            ->editColumn('icon', function ($q) {
                if ($q->icon != "") {
                    return '<i style="font-size:40px;" class="'.$q->icon.'"></i>';
                }else{
                    return 'N/A';
                }
            })
            ->editColumn('events', function ($q) {
                return $q->events->count();
            })
            ->editColumn('status', function ($q) {
                return ($q->status == 1) ? "Enabled" : "Disabled";
            })
            ->rawColumns(['actions', 'icon'])
            ->make();
    }

    /**
     * Show the form for creating new Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function cat_create()
    {
        return view('backend.event.cat_create');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param  \App\Http\Requests\StoreCategorysRequest $request
     * @return \Illuminate\Http\Response
     */
    public function cat_store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category = Event_categories::where('slug','=',str_slug($request->name))->first();
        if($category == null){
            $category = new  Event_categories();
        }
        $category->name = $request->name;
        $category->slug = str_slug($request->name);
        $category->icon = $request->icon;
        $category->save();

        return redirect()->route('admin.eventcategory')->withFlashSuccess(trans('alerts.backend.general.created'));
    }

    /**
     * Show the form for editing Category.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function cat_edit($id)
    {
        $category = Event_categories::findOrFail($id);

        return view('backend.event.cat_edit', compact('category'));
    }

    /**
     * Update Category in storage.
     *
     * @param  \App\Http\Requests\UpdateCategorysRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function cat_update(Request $request, $id)
    {
        $category = Event_categories::findOrFail($id);
        $category->name = $request->name;
        $category->slug = str_slug($request->name);
        $category->icon = $request->icon;
        $category->save();

        return redirect()->route('admin.eventcategory')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Display Category.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function cat_show($id)
    {
        $category = Event_categories::findOrFail($id);

        return view('backend.event.cat_show', compact('category'));
    }

    /**
     * Remove Category from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function cat_destroy($id)
    {
        $category = Event_categories::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.eventcategory')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Category at once.
     *
     * @param Request $request
     */
    public function cat_massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Event_categories::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    /**
     * Restore Category from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function cat_restore($id)
    {
        $category = Event_categories::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('admin.eventcategory')->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Category from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function cat_perma_del($id)
    {
        $category = Event_categories::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route('admin.eventcategory')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
//////////////////////////////////////////////// END EVENT Category /////////////////////////////////////////////////
}
