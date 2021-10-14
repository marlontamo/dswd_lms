<?php
namespace App\Http\Controllers\Backend\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class VideoController extends Controller
{
    public function index()
    {
     

    return view('backend.video.index');
    }
}
