<?php

namespace App\Http\Controllers;

use App\Models\Anamnesis;
use Illuminate\Http\Request;
use App\Http\Helper;

class AnamnesisController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Anamnesis::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'keluhan_utama' => 'required|string',
            'riwayat_penyakit' => 'required|string',
            'riwayat_alergi' => 'required|string',
            'riwayat_pengobatan' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $anamnesis = Anamnesis::create([
            'keluhan_utama' => $request->keluhan_utama,
            'riwayat_penyakit' => $request->riwayat_penyakit,
            'riwayat_alergi' => $request->riwayat_alergi,
            'riwayat_pengobatan' => $request->riwayat_pengobatan,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $anamnesis);
    }

    public function destroy(Request $request)
    {
        $anamnesis = $this->getData($request);

        if ($anamnesis == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $anamnesis->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $anamnesis->deleted_at]);
    }

    public function show(Request $request)
    {
        $anamnesis = $this->getData($request);

        if ($anamnesis == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $anamnesis);
    }

    public function update(Request $request)
    {
        $anamnesis = $this->getData($request);
        $this->validate($request, [
            'keluhan_utama' => 'required|string',
            'riwayat_penyakit' => 'required|string',
            'riwayat_alergi' => 'required|string',
            'riwayat_pengobatan' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        if ($anamnesis == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $anamnesis->keluhan_utama = $request->keluhan_utama;
        $anamnesis->riwayat_penyakit = $request->riwayat_penyakit;
        $anamnesis->riwayat_alergi = $request->riwayat_alergi;
        $anamnesis->riwayat_pengobatan = $request->riwayat_pengobatan;
        $anamnesis->user_id = $request->user_id;
        $anamnesis->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $anamnesis);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $anamnesis = Anamnesis::find($request->id);

        if ($anamnesis == null) return null;

        return $anamnesis;
    }
}
