<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class KeadaanUmum extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "keadaanumum";

    protected $guarded = [];

    public function tingkatkesadaran()
    {
        return $this->belongsTo(TingkatKesadaran::class, 'tingkatkesadaran');
    }

    public function vitalsign()
    {
        return $this->belongsTo(VitalSign::class, 'vitalsign');
    }
}
