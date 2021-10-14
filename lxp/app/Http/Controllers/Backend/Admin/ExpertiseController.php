<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\DirCategory;
use App\Models\Expertise;

class ExpertiseController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('backend.expertise.index');
    }

    public function getData(){

        if (!(auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))){
            return abort(401);
        }

        $expertise = Expertise::join('dir_category', 'dir_expertise.category_id', '=', 'dir_category.id')->select('*', 'dir_expertise.id as exp_id')->get();
        $cgs = [];
        $individual = [];
        $org = [];

        foreach ($expertise as $key => $value) {
            $fullname = $value['first_name'] . ' ' . $value['middle_name'] . ' ' . $value['last_name'];
            $cat_type = $value['cat_type'];
            $catslug = $value['cat_slug'];
            $id = $value['exp_id'];

            
            $img = asset('storage/uploads/'. $value['image']);
            $action = array(
                "show"  => route('admin.expertise.show', ['id' => $id]),
                "edit" => route('admin.expertise.edit', ['id' => $id]),
                "delete" => route('admin.expertise.destroy', ['id' => $id]),
            );

            $dt = array(
                'id' => $value['exp_id'],
                'fullname' => $fullname,
                'image' => $img,
                'email' => $value['email'],
                'position' => $value['position'],
                'office' => $value['office'],
                'slug' => $value['cat_slug'],
                'cat_name' => $value['name'],
                'action' => $action,
            );

            if($cat_type == 0){
                $cgs[] = $dt;
            }else{
                if($catslug == "org"){
                    $org[] = $dt;
                }else{
                    $individual[] = $dt;
                }
            }
        }

        $data = array(
            "cgs"   => $cgs,
            "individual"   => $individual,
            "org"   => $org,
        );

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (!(auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))){
            return abort(401);
        }
        $category = DirCategory::pluck('name', 'id')->prepend('Please select', '');

        return view('backend.expertise.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!(auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))){
            return abort(401);
        }

        $expertise = new Expertise();
        //$expertise->org_name = $request->org_name;
        $expertise->office = $request->office;
        $expertise->first_name = $request->first_name;
        $expertise->middle_name = $request->middle_name;
        $expertise->last_name = $request->last_name;
        $expertise->email = $request->email;
        $expertise->position = $request->position;
        $expertise->office = $request->office;

        if ($request->slug == "") {
            $expertise->slug = str_slug($request->first_name . $request->middle_name . $request->last_name);
        } else {
            $expertise->slug = $request->slug;
        }
        $expertise->category_id = $request->category;

        $message = $request->get('content');
        $dom = new \DOMDocument();
        $dom->loadHtml(mb_convert_encoding($message,  'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        // foreach <img> in the submited message
        foreach ($images as $img) {

            $src = $img->getAttribute('src');
            // if the img source is 'data-url'
            if (preg_match('/data:image/', $src)) {
                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];
                // Generating a random filename
                $filename = uniqid();
                $filepath = storage_path("/app/public/uploads/expertise/$filename.$mimetype");
                // @see http://image.intervention.io/api/
                $image = Image::make($src)
                    // resize if required
                    /* ->resize(300, 200) */
                    ->encode($mimetype, 100) // encode file to the specified mimetype
                    ->save($filepath);
                $new_src = asset("storage/uploads/$filename.$mimetype");
                $dirname = dirname($filename);

                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
            } // <!--endif
        } // <!-
        $expertise->content = $dom->saveHTML();

        $request = $this->saveFiles($request);
        $expertise->image = $request->featured_image;
        $expertise->save();

        if ($expertise->id) {
            return redirect()->route('admin.expertise.index')->withFlashSuccess(__('alerts.backend.general.created'));
        } else {
            return redirect()->route('admin.expertise.create')->withFlashDanger(__('alerts.backend.general.error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!(auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))){
            return abort(401);
        }
        $expertise = Expertise::findOrFail($id);
        return view('backend.expertise.show', compact('expertise'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!(auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))){
            return abort(401);
        }
        $expertise = Expertise::where('id', '=', $id)->first();
        $category = DirCategory::pluck('name', 'id')->prepend('Please select', '');
        
        return view('backend.expertise.edit', compact('expertise', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!(auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))){
            return abort(401);
        }
        $expertise = Expertise::findOrFail($id);

        $expertise->office = $request->office;
        $expertise->first_name = $request->first_name;
        $expertise->middle_name = $request->middle_name;
        $expertise->last_name = $request->last_name;
        $expertise->email = $request->email;
        $expertise->position = $request->position;
        $expertise->office = $request->office;


        if ($request->slug == "") {
            $expertise->slug = str_slug($request->title);
        } else {
            $expertise->slug = $request->slug;
        }
        $expertise->category_id = $request->category;

        $message = $request->get('content');

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHtml(mb_convert_encoding($message,  'HTML-ENTITIES', 'UTF-8'));
        $images = $dom->getElementsByTagName('img');
        // foreach <img> in the submited message
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            // if the img source is 'data-url'
            if (preg_match('/data:image/', $src)) {
                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];
                // Generating a random filename
                $filename = uniqid();
                info($filename);
                $filepath = storage_path("/app/public/uploads/expertise/$filename.$mimetype");
                // @see http://image.intervention.io/api/
                $image = Image::make($src)
                    ->encode($mimetype, 100) // encode file to the specified mimetype
                    ->save($filepath);
                $new_src = asset("storage/uploads/$filename.$mimetype");
            } // <!--endif
            else {
                $new_src = $src;
            }
            $img->removeAttribute('src');
            $img->setAttribute('src', $new_src);
        } // <!
        //-
        $expertise->content = $dom->saveHTML();

        if ($request->featured_image != "") {
            $request = $this->saveFiles($request);
            $expertise->image = $request->featured_image;
        }
        $expertise->save();

        return redirect()->route('admin.expertise.index')->withFlashSuccess(__('alerts.backend.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!(auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))){
            return abort(401);
        }
        $expertise = Expertise::findOrfail($id);
        $expertise->delete();
        return redirect()->route('admin.expertise.index')->withFlashSuccess(__('alerts.backend.general.deleted'));
    }
}
