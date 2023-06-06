<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Terapi extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "terapi";

    protected $guarded = [];

    public function Tindakan()
    {
        return $this->belongsTo(Tindakan::class, 'tindakan');
    }
    public function Obat()
    {
        return $this->belongsTo(Obat::class, 'obat');
    }
}
