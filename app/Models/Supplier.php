<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use Uuids, SoftDeletes, HasFactory;

    protected $guarded = [];
}
