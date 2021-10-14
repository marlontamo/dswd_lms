<?php

namespace  App\Models\Activity;

use Illuminate\Database\Eloquent\Model;

class ReportingTo extends Model
{
    //

    protected $table = 'reporting_to';
    public $timestamps = true;

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'reporting_to');
    }
}
