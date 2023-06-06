<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class PeriksaFisik extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "periksafisik";

    protected $guarded = [];

    public function keadaanumum()
    {
        return $this->belongsTo(KeadaanUmum::class, 'keadaanumum');
    }

}
