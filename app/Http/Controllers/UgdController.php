<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Pasien;
use App\Models\Ugd;
use App\Services\Temp;
use App\Models\Asuransi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UgdController extends Controller
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
        $this->validate($request, [
            'pas_umum_id' => 'required',
            'pas_td_id' => 'required',
            'medis_id' => 'required',
            'kamar_id' => 'required',
            'datetime_in' => 'required|max:255|date',
            'DPJP' => 'required',
            'dr_in' => 'required',
            'diagnosa' => 'required|max:255|string',
            'alasan_dirawat' => 'required|max:255|string',
            'asuransi_id' => 'required',
            'no_rm' => 'required',
        ]);
        $asuransi = Asuransi::where('id', $request->asuransi)->first();
        $pasien = Pasien::where('id', $request->pasien)->first();

        $ugd = Ugd::create ([
            'pasien_id' => $request->pasien_id,
            'medis_id' => $request->medis_id,
            'kamar_id' => $request->kamar_id,
            'datetime_in' => $request->datetime_in,
            'DPJP' => $request->DPJP,
            'dr_in' => $request->dr_in,
            'diagnosa' => $request->diagnosa,
            'alasan_dirawat' => $request->alasan_dirawat,
            'asuransi_id' => $asuransi->kode_rs,
            'no_rm' => $request->no_rm
        ]);

        $dataSend = [
            'pasien_id' => $pasien->id,
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

        $data = $this->temp->UgdStore($request->bearerToken(), $dataSend);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $data['data']);
    }
}