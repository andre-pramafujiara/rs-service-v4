<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\Asuransi;
use App\Services\Temp;

class RawatInapController extends Controller
{
    use Helper;

    public $temp;

    public function __construct(Temp $temp)
    {
    	$this->temp = $temp;
    }

    public function index(Request $request)
    {
        $data = $this->temp->rawatInapIndex($request->bearerToken(), $request->all());

        return $this->responseFormatterWithMetaTemp($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $data['data'], $data['meta']);
    }

    public function store(Request $request)
    {
        $asuransi = Asuransi::where('id', $request->asuransi)->first();

        $dataSend = [
            'medis_id' => $request->medis_id,
            'kamar_id' => $request->kamar_id,
            'datetime_in' => $request->datetime_in,
            'DPJP' => $request->DPJP,
            'dr_in' => $request->dr_in,
            'diagnosa' => $request->diagnosa,
            'alasan_dirawat' => $request->alasan_dirawat,
            'asuransi_id' => $asuransi->kode_rs,
            'no_rm' => $request->no_rm
        ];

        $data = $this->temp->rawatInapStore($request->bearerToken(), $dataSend);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $data['data']);
    }
}