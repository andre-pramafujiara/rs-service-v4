<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\Triase;
use Carbon\Carbon;

class TriaseController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Triase::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_petugas' => 'required|string|max:255',
            'triase_esi' => 'required|string|max:255',
            'respon_time' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);

        //jam otomatis
        $time = Carbon::parse($request->jam_triase);
        // tanggal automatis
        $request->merge(['tanggal_triase' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);


        $triase = Triase::create([
            'nama_petugas' => $request->nama_petugas,
            'tanggal_triase' => $request->tanggal_triase,
            'jam_triase' => $time->toTimeString(),
            'triase_esi' => $request->triase_esi,
            'respon_time' => $request->respon_time,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $triase);
    }

    public function destroy(Request $request)
    {
        $triase = $this->getData($request);

        if ($triase == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $triase->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $triase->deleted_at]);
    }

    public function show(Request $request)
    {
        $triase = $this->getData($request);

        if ($triase == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $triase);
    }

    public function update(Request $request)
    {
        $triase = $this->getData($request);
        $this->validate($request, [
            'nama_petugas' => 'required|string|max:255',
            'triase_esi' => 'required|string|max:255',
            'respon_time' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);

        if ($triase == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        //jam otomatis
        $time = Carbon::parse($request->jam_triase);
        // tanggal Triase
        $request->merge(['tanggal_triase' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);

        $triase->update([
            'nama_petugas' => $request->nama_petugas,
            'tanggal_triase' => $request->tanggal_triase,
            'jam_triase' => $time->toTimeString(),
            'triase_esi' => $request->triase_esi,
            'respon_time' => $request->respon_time,
            'user_id' => $request->user_id,
        ]);
        $triase->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $triase);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $triase = Triase::find($request->id);

        if ($triase == null) return null;

        return $triase;
    }
}
