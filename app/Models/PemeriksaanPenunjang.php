<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemeriksaanPenunjang extends Model
{
    use Uuids, SoftDeletes, HasFactory;

    protected $table = "pemeriksaanpenunjang";

    protected $guarded = [];

    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class, 'laboratorium');
    }

    public function radiologi()
    {
        return $this->belongsTo(Radiologi::class, 'radiologi');
    }
}