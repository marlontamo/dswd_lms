<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Psgc\Barangay;
use App\Models\Psgc\Municipality;
use App\Models\Psgc\Region;
use App\Models\Psgc\Province;

class PsgcController extends Controller
{
	public function getProfLocation(Request $request){
		$region = Region::All();
		$reg_code = $request->reg_code;

		if(empty($reg_code)){
			$reg_code = "140000000";
		}

    	$province = new Province;
    	$provinces = $province->where('region_code',$request->reg_code)->get();
		$municipality = new Municipality;
    	$municipalities = $municipality->where('province_code',$request->prov_code)->get();

    	$response = [
			"success"=>true,
			"region"=>$region,
			"province"=>$provinces,
			"municipality"=>$municipalities,
		];

    	echo json_encode($response);
	}

    public function getCarData()
    {
    	$region = Region::All();
    	$province = new Province;
    	$provinces = $province->where('region_code',"140000000")->get();

    	$response = [
			"success"=>true,
			"region"=>$region,
			"province"=>$provinces,
		];

    	echo json_encode($response);
    }

    public function getRegions()
    {
    	$region = Region::All();

    	$response = ["success"=>true,"data"=>$region];

    	echo json_encode($response);
    }


    public function getProvinces(Request $request)
    {
    	$response = ["success"=>false,"data"=>[]];

    	$validate = $request->validate([
    		'region_code'=>"required"
    	]);

    	$province = new Province;
    	$provinces = $province->where('region_code',$request->region_code)->get();

    	if(!empty($provinces))
    	{
    		$response["success"] = true;
    		$response["data"] = $provinces;
    	}

    	echo json_encode($response);

    }

    public function getMunicipalities(Request $request)
    {
    	$response = ["success"=>false,"data"=>[]];

    	$validate = $request->validate([
    		'prov_code'=>"required"
    	]);

    	$municipality = new Municipality;
    	$municipalities = $municipality->where('province_code',$request->prov_code)->get();

    	if(!empty($municipalities))
    	{
    		$response["success"] = true;
    		$response["data"] = $municipalities;
    	}

    	echo json_encode($response);

    }

    public function getBarangays(Request $request)
    {
    	$response = ["success"=>false,"data"=>[]];

    	$validate = $request->validate([
    		'city_code'=>"required"
    	]);

    	$barangay = new Barangay;
    	$barangays = $barangay->where('city_code',$request->city_code)->get();

    	if(!empty($barangays))
    	{
    		$response["success"] = true;
    		$response["data"] = $barangays;
    	}

    	echo json_encode($response);

    }
}
