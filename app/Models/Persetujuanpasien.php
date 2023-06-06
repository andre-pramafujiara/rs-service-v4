<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class PersetujuanPasien extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "persetujuanpasien";

    protected $guarded = [];
}
