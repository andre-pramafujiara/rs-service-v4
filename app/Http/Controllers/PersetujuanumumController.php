<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\PersetujuanUmum;
use Carbon\Carbon;

class PersetujuanumumController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], PersetujuanUmum::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_pasien' => 'required|exists:pasien,id',
            'id_persetujuan' => 'required|exists:persetujuanpasien,id',
            'pernyataan' => 'required|exists:pernyataan,id',
            'user_id' => 'required|integer',
        ]);

        //jam otomatis
        $time = Carbon::parse($request->jam);
        // tanggal automatis
        $request->merge(['tanggal' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);


        $persetujuanumum = PersetujuanUmum::create([
            'tanggal' => $request->tanggal,
            'jam' => $time->toTimeString(),
            'id_pasien' => $request->id_pasien,
            'id_persetujuan' => $request->id_persetujuan,
            'peryataan' => $request->peryataan,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $persetujuanumum);
    }

    public function destroy(Request $request)
    {
        $persetujuanumum = $this->getData($request);

        if ($persetujuanumum == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $persetujuanumum->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $persetujuanumum->deleted_at]);
    }

    public function show(Request $request)
    {
        $persetujuanumum = $this->getData($request);

        if ($persetujuanumum == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $persetujuanumum);
    }

    public function update(Request $request)
    {
        $persetujuanumum = $this->getData($request);
        $this->validate($request, [
            'id_pasien' => 'required|exists:pasien,id',
            'id_persetujuan' => 'required|exists:persetujuanpasien,id',
            'pernyataan' => 'required|exists:pernyataan,id',
            'user_id' => 'required|integer',
        ]);

        if ($persetujuanumum == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        //jam otomatis
        $time = Carbon::parse($request->jam);
        // tanggal persetujuanumum
        $request->merge(['tanggal' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);

        $persetujuanumum->update([
            'tanggal' => $request->tanggal,
            'jam' => $time->toTimeString(),
            'id_pasien' => $request->id_pasien,
            'id_persetujuan' => $request->id_persetujuan,
            'peryataan' => $request->peryataan,
            'user_id' => $request->user_id,
        ]);
        $persetujuanumum->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $persetujuanumum);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $persetujuanumum = PersetujuanUmum::find($request->id);

        if ($persetujuanumum == null) return null;

        return $persetujuanumum;
    }
}
