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