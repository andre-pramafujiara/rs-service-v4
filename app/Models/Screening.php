<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Screening extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "screening";

    protected $guarded = [];

    public function resikojatuh()
    {
        return $this->belongsTo(Jatuh::class, 'jatuh');
    }

    public function batuk()
    {
        return $this->belongsTo(Batuk::class, 'batuk');
    }

    public function gizi()
    {
        return $this->belongsTo(Gizi::class, 'gizi');
    }
}
