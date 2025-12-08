<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Story;

class Chapter extends Model
{
    protected $guarded = ['id'];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}