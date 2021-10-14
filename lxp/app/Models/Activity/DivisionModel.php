<?php

namespace App\Models\Activity;

use Illuminate\Database\Eloquent\Model;

class DivisionModel extends Model
{
    protected $table = 'division';
    //protected $guarded=[];
    protected $fillable = [
                              'office_id',
                              'div_shortname',
                              'div_title',
                            ];
    public $timestamps = TRUE;
}
