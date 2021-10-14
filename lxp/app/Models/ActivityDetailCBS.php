<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Activity;
use App\Models\Activity\NumberOfParticipants;
class ActivityDetailCBS extends Model
{
    protected $table = 'activity_details_cbs';
    protected $guarded = [];
    protected $fillable = [ 'activity_id',
                            'activity_title',
                            'proposed_venue',
                            'proposed_date_of_conduct',
                            'field_office',
                            'central_office',
                            'CIS',
                            'obligated_amount',
                            'LGU',
                            'NGO',
                            'NGA',
                            'PO',
                            'volunteers',
                            'stakeholders',
                            'academe',
                            'religious_sector',
                            'business_sector',
                            'media',
                            'beneficiaries',

                        ];
    public $timestamps = true;

    public function activity(){
        return $this->belongsTo(Activity::class,'id','activity_id');
    }
    public function participants(){
        return $this->hasMany(NumberOfParticipants::class,'Activity_id','activity_id');
    }
}
