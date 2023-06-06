<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Anamnesis extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "anamnesis";

    protected $guarded = [];

    public function riwayatpenyakit()
    {
        return $this->belongsTo(RiwayatPenyakit::class, 'riwayatpenyakit');
    }
    
}
