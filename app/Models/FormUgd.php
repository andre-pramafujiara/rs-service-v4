<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class FormUgd extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "formugd";

    protected $guarded = [];

    public function triase()
    {
        return $this->belongsTo(Triase::class, 'triase');
    }

    public function pengantar()
    {
        return $this->belongsTo(Pengantar::class, 'pengantar');
    }

    public function anamnesis()
    {
        return $this->belongsTo(Anamnesis::class, 'anamnesis');
    }

    public function assesmenawal()
    {
        return $this->belongsTo(AssesmenAwal::class, 'assesmenawal');
    }

    public function screening()
    {
        return $this->belongsTo(Screening::class, 'assesmennyeri');
    }

    public function riwayatobat()
    {
        return $this->belongsTo(RiwayatObat::class, 'riwayatobat');
    }

    public function pemulangan()
    {
        return $this->belongsTo(Pemulangan::class, 'pemulangan');
    }


    public function pemeriksaanpenunjang()
    {
        return $this->belongsTo(pemeriksaanPenunjang::class, 'pemeriksaanpenunjang');
    }
    public function diangnisis()
    {
        return $this->belongsTo(Diagnosis::class, 'assesmennyeri');
    }
    public function persetujuantindakan()
    {
        return $this->belongsTo(PersetujuanTindakan::class, 'persetujuantindakan');
    }
    public function terapi()
    {
        return $this->belongsTo(Terapi::class, 'terapi');
    }
}
