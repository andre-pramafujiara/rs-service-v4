<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class StatusAntrianUgd extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "statusantrianugd";

    protected $guarded = [];


}
