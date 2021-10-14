<?php

namespace App\Models\Activity;

use Illuminate\Database\Eloquent\Model;
use App\Models\Activity;
class NumberOfParticipants extends Model
{
    protected $table = 'actual_number_of_participants';
    //protected $guarded=[];
    protected $fillable = [
                              'user_id',
                              'activity_id',
                                'number_staff_FO_male',
                                'number_staff_FO_female',
                                'province_code',
                                'city_code'
                            ];
    public $timestamps = TRUE;
    public function Activity(){
    return $this->belongsTo(Activity::class, 'activity_id','id');
    }
    public function ActivityDetail(){
        return $this->belongsTo(ActivityDetailCBS::class);
        }
}

