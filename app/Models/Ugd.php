<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Ugd extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "ugd";

    protected $guarded = [];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien');
    }

    // public function pasienb()
    // {
    //     return $this->belongsTo(Pasienb::class, 'pasienb');
    // }

    public function penanggungjawab()
    {
        return $this->belongsTo(Penanggungjawab::class, 'penanggungjawab');
    }

    public function pengantar()
    {
        return $this->belongsTo(Pengantar::class, 'pengantar');
    }

    public function bbl()
    {
        return $this->belongsTo(Bbl::class, 'bbl');
    }
}
