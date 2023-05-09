<?php

namespace App\Http\Controllers;

use App\Models\KelasKamar;
use Illuminate\Http\Request;
use App\Http\Helper;

class KelasKamarController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], KelasKamar::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'user_id' => 'required|integer',
            'harga' => 'required|integer',
        ]);

        $kelaskamar = KelasKamar::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'description' => $request->input('description', ''),
            'harga' => $request->harga,
            'BPJS' => $request->input('BPJS', null),
            'SIRANAP' => $request->input('SIRANAP', null),
            'SPGDT' => $request->input('SPGDT', null),
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $kelaskamar);
    }

    public function destroy(Request $request)
    {
        $kelaskamar = $this->getData($request);

        if ($kelaskamar == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $kelaskamar->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $kelaskamar->deleted_at]);
    }

    public function show(Request $request)
    {
        $kelaskamar = $this->getData($request);

        if ($kelaskamar == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $kelaskamar);
    }

    public function update(Request $request)
    {
        $kelaskamar = $this->getData($request);
        $this->validate($request, [
            'name' => 'required',
            'user_id' => 'required|integer',
            'description' => $request->input('description', ''),
            'harga' => 'required|integer',
        ]);

        if ($kelaskamar == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $kelaskamar->name = $request->name;
        $kelaskamar->user_id = $request->user_id;
        $kelaskamar->description = $request->input('description', '');
        $kelaskamar->harga = $request->harga;
        $kelaskamar->BPJS = $request->input('BPJS', null);
        $kelaskamar->SIRANAP = $request->input('SIRANAP', null);
        $kelaskamar->SPGDT = $request->input('SPGDT', null);
        $kelaskamar->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $kelaskamar);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $kelaskamar = KelasKamar::find($request->id);

        if ($kelaskamar == null) return null;

        return $kelaskamar;
    }
}
