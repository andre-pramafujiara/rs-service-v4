<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class SkalaNyeri extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "askalanyeri";

    protected $guarded = [];
}
