<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class PersetujuanTindakan extends Model
{
    use Uuids, SoftDeletes;
    protected $table = "persetujuantindakan";

    protected $guarded = [];

    public function membuatpernyataan()
    {
        return $this->belongsTo(MembuatPernyataan::class, 'membuatpernyataan');
    }
}
