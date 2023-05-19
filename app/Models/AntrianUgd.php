<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class AntrianUgd extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "antrianugd";

    protected $guarded = [];

    public function ugd()
    {
        return $this->belongsTo(Ugd::class, 'ugd');
    }

    

}
