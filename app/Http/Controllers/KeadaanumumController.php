<?php

namespace App\Http\Controllers;

use App\Models\KeadaanUmum;
use Illuminate\Http\Request;
use App\Http\Helper;

class KeadaanumumController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], KeadaanUmum::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tingkat_kesadaran' => 'required|exists:penanggungjawab,id',
            'vital_sign' => 'required|exists:vitalsign,id',
            'user_id' => 'required|integer',
        ]);

        $keadaanumum = KeadaanUmum::create([
            'tingkat_kesadaran' => $request->tingkat_kesadaran,
            'vital_sign' => $request->vital_sign,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $keadaanumum);
    }

    public function destroy(Request $request)
    {
        $keadaanumum = $this->getData($request);

        if ($keadaanumum == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $keadaanumum->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $keadaanumum->deleted_at]);
    }

    public function show(Request $request)
    {
        $keadaanumum = $this->getData($request);

        if ($keadaanumum == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $keadaanumum);
    }

    public function update(Request $request)
    {
        $keadaanumum = $this->getData($request);
        $this->validate($request, [
            'tingkat_kesadaran' => 'required|exists:penanggungjawab,id',
            'vital_sign' => 'required|exists:vitalsign,id',
            'user_id' => 'required|integer',
        ]);

        if ($keadaanumum == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $keadaanumum->tingkat_kesadaran = $request->tingkat_kesadaran;
        $keadaanumum->vital_sign = $request->vital_sign;
        $keadaanumum->user_id = $request->user_id;
        $keadaanumum->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $keadaanumum);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $keadaanumum = KeadaanUmum::find($request->id);

        if ($keadaanumum == null) return null;

        return $keadaanumum;
    }
}
