<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Activity\NumberOfParticipants;
use App\Models\Activity\ActivityDetail;
use App\Models\ActivityDetailCBS;
use App\Models\Activity\RatingModel;
use App\Models\Activity\DivisionModel;
class Activity extends Model
{   protected $table = 'activity_accomplishment_entry';
    protected $guarded=[];
    protected $fillable = [      'id',
                                'email',
                                'reporting_to',
                                'reporting_period',
                                'div_id'
                            ];
    public $timestamps = true;


    /**
     * foreign yung id na manggagaling sa table g model na nasa parameter
     * local is yung id ng model na kinokonek natin sa kanya
     */
    public function participants(){
     return $this->hasMany(NumberOfParticipants::class, 'Activity_id','id');
    }
    public function detail_cbs(){
        return $this->hasOne(ActivityDetailCBS::class ,'activity_id','id');
    }
    public function rating(){
        return $this->hasMany(RatingModel::class, 'Activity_id', 'id');
    }
    public function division(){
        return $this->hasOne(DivisionModel::class,'id','div_id');
    }
}
