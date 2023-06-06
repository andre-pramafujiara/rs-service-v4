<?php

namespace App\Http\Controllers;

use App\Models\Anamnesis;
use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\RiwayatPenyakit;

class RiwayatpenyakitController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], RiwayatPenyakit::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'penyakit_sekarang' => 'required|string',
            'penyakit_dahulu' => 'required|string',
            'penyakit_keluarga' => 'required|string',
            'pengobatan' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $riwayatpenyakit = RiwayatPenyakit::create([
            'penyakit_sekarang' => $request->penyakit_sekarang,
            'penyakit_dahulu' => $request->penyakit_dahulu,
            'penyakit_keluarga' => $request->penyakit_keluarga,
            'pengobatan' => $request->pengobatan,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $riwayatpenyakit);
    }

    public function destroy(Request $request)
    {
        $riwayatpenyakit = $this->getData($request);

        if ($riwayatpenyakit == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $riwayatpenyakit->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $riwayatpenyakit->deleted_at]);
    }

    public function show(Request $request)
    {
        $riwayatpenyakit = $this->getData($request);

        if ($riwayatpenyakit == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $riwayatpenyakit);
    }

    public function update(Request $request)
    {
        $riwayatpenyakit = $this->getData($request);
        $this->validate($request, [
            'penyakit_sekarang' => 'required|string',
            'penyakit_dahulu' => 'required|string',
            'penyakit_keluarga' => 'required|string',
            'pengobatan' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        if ($riwayatpenyakit == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $riwayatpenyakit->penyakit_sekarang = $request->penyakit_sekarang;
        $riwayatpenyakit->penyakit_dahulu = $request->penyakit_dahulu;
        $riwayatpenyakit->penyakit_keluarga = $request->penyakit_keluarga;
        $riwayatpenyakit->pengobatan = $request->pengobatan;
        $riwayatpenyakit->user_id = $request->user_id;
        $riwayatpenyakit->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $riwayatpenyakit);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $riwayatpenyakit = RiwayatPenyakit::find($request->id);

        if ($riwayatpenyakit == null) return null;

        return $riwayatpenyakit;
    }
}
