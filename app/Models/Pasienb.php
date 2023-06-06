<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Pasienb extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "pasienb";

    protected $guarded = [];

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
