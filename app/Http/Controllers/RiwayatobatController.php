<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\RiwayatObat;

class RiwayatobatController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], RiwayatObat::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_obat' => 'required|string|max:255',
            'dosis' => 'required|string|max:255',
            'waktu_penggunaan' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);


        $riwayatobat = RiwayatObat::create([
            'nama_obat' => $request->nama_obat,
            'dosis' => $request->dosis,
            'waktu_penggunaan' => $request->waktu_penggunaan,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $riwayatobat);
    }

    public function destroy(Request $request)
    {
        $riwayatobat = $this->getData($request);

        if ($riwayatobat == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $riwayatobat->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $riwayatobat->deleted_at]);
    }

    public function show(Request $request)
    {
        $riwayatobat = $this->getData($request);

        if ($riwayatobat == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $riwayatobat);
    }

    public function update(Request $request)
    {
        $riwayatobat = $this->getData($request);
        $this->validate($request, [
            'nama_petugas' => 'required|string|max:255',
            'dosis' => 'required|string|max:255',
            'waktu_penggunaan' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);

        if ($riwayatobat == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $riwayatobat->update([
            'nama_obat' => $request->nama_obat,
            'dosis' => $request->dosis,
            'waktu_penggunaan' => $request->waktu_penggunaan,
            'user_id' => $request->user_id,
        ]);
        $riwayatobat->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $riwayatobat);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $riwayatobat = RiwayatObat::find($request->id);

        if ($riwayatobat == null) return null;

        return $riwayatobat;
    }
}
