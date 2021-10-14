<?php

namespace App\Models;

use App\Models\DirCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class Expertise extends Model
{
    use SoftDeletes;
	protected $table = 'dir_expertise';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(DirCategory::class, 'category_id');
    }

}
