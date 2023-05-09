<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penyakit extends Model
{
    use Uuids, SoftDeletes, HasFactory;

    protected $guarded = [];

    public function child()
    {
        return $this->hasMany(Penyakit::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Penyakit::class, 'parent_id');
    }
}
