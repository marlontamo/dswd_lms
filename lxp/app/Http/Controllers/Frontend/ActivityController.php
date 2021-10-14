<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Auth\User;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use DB;
use App\Models\Activity;
use App\Models\Activity\NumberOfParticipants;
use App\Models\Activity\ParticipantGroupModel;
use App\Models\Activity\DivisionModel;
use App\Models\Activity\RatingModel;
use Auth;
use App\Models\ActivityDetailCBS;
use App\Models\ActivityDetailLDS;
use App\http\Requests\Frontend\Activity\CreateActivityRequest;
use App\Models\Activity\ReportingTo;

class ActivityController extends Controller
{
  public function index()
  {
     
    
    if(Activity::all() == null){
      $activity_id = 1;
    }else{
      $activity_id = Activity::orderBy('id', 'desc')->first();
    }
    $activities = ActivityDetailCBS::all();

    $divisions = DivisionModel::all();
    
    $participants = ParticipantGroupModel::all();

    $reportingTo = ReportingTo::all();
    $provinces = DB::table('lib_geo_province')->where('region_code', 140000000)->get();
    
    $cities = DB::table('lib_geo_city')->where('province_code', 141100000)->get();
    return view('Frontend.activity', compact('provinces', 'reportingTo', 'divisions', 'activity_id', 'cities', 'participants', 'activities'));
  }
  public function createActivity(CreateActivityRequest $request)
  {
    $activity = new Activity();
    $activity->user_id = Auth::user()->id;
    $activity->email = $request->email;
    $activity->reporting_to = $request->reporting_to;
    $activity->reporting_period = $request->reporting_period;
    $activity->div_id = $request->division;
    if ($activity->save()) {
      $success = $activity->reporting_to;
      return back()->with('next', $success);
    } else {
      return back()->withErrors();
    }
  }
  public function record_actual_number(Request $request)
  {
    $data = $request->all();
    if ($data['city'] == null) {
      $city = "n/a";
    } else {
      $city = $data['city'];
    }
    if ($request->ajax()) {

      $actual_number = new NumberOfParticipants();
      $actual_number->user_id = Auth::user()->id;
      $actual_number->Activity_id = $data['activity_id'];
      $actual_number->staff_FO_male = $data['staff_male'];
      $actual_number->staff_FO_female = $data['staff_female'];
      $actual_number->municipality_represented = $data['province'];
      $actual_number->participant_group = $data['participant_grp'];
      $actual_number->city = $city;
      if ($actual_number->save()) {
        return response()->json([
          'msg' => 'saved'
        ]);
      } else {
        return response()->json([
          'msg' => 'failed'
        ]);
      }
    } else {
      $actual_number = new NumberOfParticipants();
      $actual_number->user_id = Auth::user()->id;
      $actual_number->Activity_id = $request->activity_id;
      $actual_number->staff_FO_male = $request->staff_male;
      $actual_number->staff_FO_female = $request->staff_female;
      $actual_number->municipality_represented = $request->province;
      $actual_number->participant_group = $request->participant_grp;
      $actual_number->city = $request->city;
      if ($actual_number->save()) {
        return back();
      }
    }
  }
  public function activity_detail_CBS(Request $request)
  {

    if ($request->reporting_to == "1") {
      $cbs = new ActivityDetailCBS();
      $cbs->Activity_id = $request->activity_id;
      $cbs->user_id = Auth::user()->id;
      $cbs->Activity_Title = $request->activity_title;
      $cbs->Proposed_date_of_conduct = $request->proposed_date_of_conduct;
      $cbs->proposed_venue = $request->proposed_venue;
      $cbs->field_office = $request->field_office;
      $cbs->central_office = $request->central_office;
      $cbs->CIS = "n/a";
      $cbs->obligated_amount = $request->obligated_amount;
      $cbs->LGU = "n/a";
      $cbs->NGO   = "n/a";
      $cbs->NGA = 0;
      $cbs->PO = 0;
      $cbs->volunteers = 0;
      $cbs->stakeholders = 0;
      $cbs->academe = 0;
      $cbs->religious_sector = 0;
      $cbs->business_sector = 0;
      $cbs->media = 0;
      $cbs->beneficiaries = 0;
      if ($cbs->save()) {
        $activity_id = $cbs->Activity_id;
        return back()->with('after_detail', $request->reporting_to);
      }
    } elseif ($request->reporting_to == "2" || $request->reporting_to == "3") {
      $cbs = new ActivityDetailCBS();
      $cbs->Activity_id = $request->activity_id;
      $cbs->user_id = Auth::user()->id;
      $cbs->Activity_Title = $request->activity_title;
      $cbs->Proposed_date_of_conduct = $request->proposed_date_of_conduct;
      $cbs->proposed_venue = $request->proposed_venue;
      $cbs->field_office = $request->field_office;
      $cbs->central_office = $request->central_office;
      $cbs->CIS = $request->CIS;
      $cbs->obligated_amount = $request->obligated_amount;
      $cbs->LGU = $request->LGU;
      $cbs->NGO   = $request->NGO;
      $cbs->NGA = $request->NGA;
      $cbs->PO = $request->PO;
      $cbs->volunteers = $request->volunteers;
      $cbs->stakeholders = $request->stakeholders;
      $cbs->academe = $request->academe;
      $cbs->religious_sector = $request->religious_sector;
      $cbs->business_sector = $request->business_sector;
      $cbs->media = $request->media;
      $cbs->beneficiaries = $request->beneficiaries;
      if ($cbs->save()) {
        $activity_id = $cbs->Activity_id;
        return back()->with('after_detail', $request->reporting_to);
      } //if
    } //elseif
  } //method



  public function get_rating()
  {
    $rating = RatingModel::all();
  }
  public function save_activity_rating(Request $request)
  {
    $rating = new RatingModel();
    $rating->user_id = Auth::user()->id;
    $rating->Activity_id = $request->activity_id;
    $rating->reporting_to = $request->reporting_to;
    $rating->poor = $request->poor;
    $rating->fair = $request->fair;
    $rating->satisfactory = $request->satisfactory;
    $rating->very_satisfactory = $request->very_satisfactory;
    $rating->excellent =  $request->excellent;
    if ($rating->save()) {
      return back();
    }
  }
  public function activityList()
  {
    $activity_details = new Activity();

    $activities = $activity_details->all();
    //dd($activity_details);

    return view('frontend.layouts.activity.activity_table', compact('activities'));
  }

  public function get_full_data($id = null)
  {
    if ($id == null) {

      $full = $this->fetchall();

      return view('frontend.layouts.activity.activity_table', compact('full'));
    } else {

      
    }
  }
  public function test($id)
  {  
    $activities = Activity::find($id)
                           ->with('detail_cbs')
                           ->get();
//$details = ActivityDetailCBS::where('activity_id',$id)->get();
    dd($activities->activity_title);

      return view('frontend.layouts.activity.activity_table', compact('activities'));
  }



  public function edit($id)
  {
    return $this->get_full_detail($id);
  }
  public function destroy($id)
  {
    return $this->get_full_detail($id);
  }

  private function get_full_detail($id = null)
  {
    if ($id == null) {
      return;
    } else {
      $activity = new Activity();
      $data = $activity->get_full_activity_lds_data_by_Id($id);
      return $data;
    }
  }

private function fetchall(){
  $activity = new Activity();
  $data =$activity->all();
   return $data;
                
}
function participants(){
  $data = new Activity();
  $data1 = $data->get_participants();
  return $data1;
}
function add_participants(Request $request){
  $actual_number = new NumberOfParticipants();
  $data = $request->all();
     

      $activity_id = $request->activity_id;
      $user_id = $request->user_id;
      $province_code = $request->province_code;
      $city_code = $request->city_code;
      $male = $request->xmale;
      $female = $request->xfemale;
      $participant_group = $request->participant_group;

      for($i =0; $i < count($activity_id); $i++){
        $data = array(
          'activity_id' =>$activity_id[$i],
          'user_id'     =>$user_id[$i],
          'province_code' => $province_code[$i],
          'city_code' =>$city_code[$i],
          'staff_FO_male' =>$male[$i],
          'staff_FO_female'=>$female[$i],
          'participant_group_id'=>$participant_group[$i]
                 );
             $data_to_insert[] = $data;    
      }
      NumberOfParticipants::insert($data_to_insert);
    return back()->with('for_final', true);
 
}
function singleActivity($id = null){
  if($id == null){
    return;
  }else{
    $activity = Activity::findOrFail($id);
    return $activity;
  }
}
private function activityDetail($id){
  $activity = Activity::findOrFail($id);
       return $activity->detail_cbs;
}
private function activityParticipant($id){
  $activity = Activity::findOrFail($id);
  return $activity->participants;
}

function report(){
   $test = "IDCBAR";
$report ="IDCBAR".Carbon::now()."_report.pdf";
  $pdf = PDF::loadView('certificate.Activity', compact('test'))->setPaper('', 'landscape');
  //$pdf->save(public_path('storage/reports/' . $certificate_name));
  return $pdf->download($report);
}
function get_city(Request $request){
// return $request->province_code;
 $province_code = $request->province_code;
 $cities = DB::table('lib_geo_city')->where('province_code',$province_code)->get();
 return response(['data'=>$cities]);
}

}
     
