<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Services\Temp;
use Illuminate\Http\Request;
use App\Models\Poliklinik;

class TempDokterController extends Controller
{
    use Helper;

    public $temp;

    public function __construct(Temp $temp)
    {
    	$this->temp = $temp;
    }

    public function list(Request $request)
    {
        if ($request->has('poli_id')) {
            $poli = Poliklinik::where('id', $request->poli_id)->first();
            $data = $this->temp->tempDokterList($request->bearerToken(), ["poli_id" => $poli->poli_id_old]);
        } else {
            $data = $this->temp->tempDokterList($request->bearerToken(), []);
        }

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $data['data']);
    }
}
