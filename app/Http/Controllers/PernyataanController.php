<?php

namespace App\Http\Controllers;

use App\Models\Pernyataan;
use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\Penanggungjawab;

class PernyataanController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Pernyataan::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'penanggungjawab' => 'required|exists:penanggungjawab,id',
            'petugas' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $pernyataan = Pernyataan::create([
            'penanggungjawab' => $request->penanggungjawab,
            'petugas' => $request->petugas,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $pernyataan);
    }

    public function destroy(Request $request)
    {
        $pernyataan = $this->getData($request);

        if ($pernyataan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $pernyataan->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $pernyataan->deleted_at]);
    }

    public function show(Request $request)
    {
        $pernyataan = $this->getData($request);

        if ($pernyataan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pernyataan);
    }

    public function update(Request $request)
    {
        $pernyataan = $this->getData($request);
        $this->validate($request, [
            'penanggungjawab' => 'required|exists:penanggungjawab,id',
            'petugas' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        if ($pernyataan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $pernyataan->penanggungjawab = $request->penanggungjawab;
        $pernyataan->petugas = $request->petugas;
        $pernyataan->user_id = $request->user_id;
        $pernyataan->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pernyataan);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $pernyataan = Pernyataan::find($request->id);

        if ($pernyataan == null) return null;

        return $pernyataan;
    }
}
