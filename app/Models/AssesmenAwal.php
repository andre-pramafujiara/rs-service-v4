<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class AssesmenAwal extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "assesmenawal";

    protected $guarded = [];

    public function assesmennyeri()
    {
        return $this->belongsTo(AssesmenNyeri::class, 'assesmennyeri');
    }

    public function resikojatuh()
    {
        return $this->belongsTo(Jatuh::class, 'jatuh');
    }

    public function periksafisik()
    {
        return $this->belongsTo(PeriksaFisik::class, 'periksafisik');
    }

}
