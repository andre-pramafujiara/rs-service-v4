<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Pengantar extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "pengantar";

    protected $guarded = [];
}
