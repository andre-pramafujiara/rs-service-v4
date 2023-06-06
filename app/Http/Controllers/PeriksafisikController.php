<?php

namespace App\Http\Controllers;

use App\Models\PeriksaFisik;
use Illuminate\Http\Request;
use App\Http\Helper;

class PeriksafisikController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], PeriksaFisik::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'gambar_anatomi' => 'required|string',
            'keadaan_umum' => 'required|exists:keadaanumum,id',
            'keterangan' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $periksanfisik = PeriksaFisik::create([
            'gambar_anatomi' => $request->gambar_anatomi,
            'keadaan_umum' => $request->keadaan_umum,
            'keterangan' => $request->keterangan,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $periksanfisik);
    }

    public function destroy(Request $request)
    {
        $periksanfisik = $this->getData($request);

        if ($periksanfisik == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $periksanfisik->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $periksanfisik->deleted_at]);
    }

    public function show(Request $request)
    {
        $periksanfisik = $this->getData($request);

        if ($periksanfisik == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $periksanfisik);
    }

    public function update(Request $request)
    {
        $periksanfisik = $this->getData($request);
        $this->validate($request, [
            'gambar_anatomi' => 'required|string',
            'keadaan_umum' => 'required|exists:keadaanumum,id',
            'keterangan' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        if ($periksanfisik == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $periksanfisik->gambar_anatomi = $request->gambar_anatomi;
        $periksanfisik->keadaan_umum = $request->keadaan_umum;
        $periksanfisik->keterangan = $request->keterangan;
        $periksanfisik->user_id = $request->user_id;
        $periksanfisik->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $periksanfisik);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $periksanfisik = PeriksaFisik::find($request->id);

        if ($periksanfisik == null) return null;

        return $periksanfisik;
    }
}
