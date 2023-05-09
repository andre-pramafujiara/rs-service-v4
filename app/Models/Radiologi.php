<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Radiologi extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "radiologi";

    protected $guarded = [];
}
