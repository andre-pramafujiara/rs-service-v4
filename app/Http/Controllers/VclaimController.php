<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Services\Vclaim;

class VclaimController extends Controller
{
    use Helper;

    public $vclaim;

    public function __construct(Vclaim $vclaim)
    {
    	$this->vclaim = $vclaim;
    }

    public function PesertaByNIK(Request $request)
    {
        $this->validate($request, [
            'nik' => 'required',
        ]);

        $data = $this->vclaim->obtainPesertaByNIK($request->nik);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $data->peserta);
    }
}