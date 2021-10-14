<?php

namespace App\Models;

use App\Models\Expertise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DirCategory extends Model
{
    use SoftDeletes;
	protected $table = 'dir_category';
    protected $guarded = [];

    public function expertise(){
        return $this->hasMany(DirExpertise::class);
    }

}
