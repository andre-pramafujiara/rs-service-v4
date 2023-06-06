<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class AssesmenAwalDokterUgd extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "assesmenawal";

    protected $guarded = [];

    public function anamnesis()
    {
        return $this->belongsTo(Anamnesis::class, 'anamnesis');
    }

    public function periksafisik()
    {
        return $this->belongsTo(PeriksaFisik::class, 'periksafisik');
    }

    public function pemeriksaanpenunjang()
    {
        return $this->belongsTo(PemeriksaanPenunjang::class, 'pemerikasanpenunjang');
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class, 'anamnesis');
    }

    public function terapi()
    {
        return $this->belongsTo(Terapi::class, 'terapi');
    }


    

}
