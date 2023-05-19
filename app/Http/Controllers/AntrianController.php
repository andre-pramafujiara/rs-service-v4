<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\AntrianUgd;
use App\Models\Triase;
use Carbon\Carbon;

class TriaseController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], AntrianUgd::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tgl_masuk' => 'required|date',
            'urutan_antrian' => 'required|integer|',
            'status' => 'required|string|max:255',
            'id_ugd' => 'required|string|max:255',
        ]);

        // tanggal automatis
        $request->merge(['tgl_masuk' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);


        $antrianugd = AntrianUgd::create([
            'tgl_masuk' => $request->tgl_masuk,
            'urutan_antrian' => $request->urutan_antrian,
            'status' => $request->status,
            'id_ugd' => $request->id_ugd,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $antrianugd);
    }

    public function destroy(Request $request)
    {
        $antrianugd = $this->getData($request);

        if ($antrianugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $antrianugd->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $antrianugd->deleted_at]);
    }

    public function show(Request $request)
    {
        $antrianugd = $this->getData($request);

        if ($antrianugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $antrianugd);
    }

    public function update(Request $request)
    {
        $antrianugd = $this->getData($request);
        $this->validate($request, [
            'tgl_masuk' => 'required|date',
            'urutan_antrian' => 'required|integer|',
            'status' => 'required|string|max:255',
            'id_ugd' => 'required|string|max:255',
        ]);

        if ($antrianugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        // tanggal an$antrianugd
        $request->merge(['tgl_masuk' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);

        $antrianugd->update([
            'tgl_masuk' => $request->tgl_masuk,
            'urutan_antrian' => $request->urutan_antrian,
            'status' => $request->status,
            'id_ugd' => $request->id_ugd,
        ]);
        $antrianugd->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $antrianugd);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $antrianugd = AntrianUgd::find($request->id);

        if ($antrianugd == null) return null;

        return $antrianugd;
    }
}
