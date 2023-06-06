<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\VitalSign;

class VitalsignController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Vitalsign::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);


        $vitalsign = VitalSign::create([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $vitalsign);
    }

    public function destroy(Request $request)
    {
        $vitalsign = $this->getData($request);

        if ($vitalsign == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $vitalsign->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $vitalsign->deleted_at]);
    }

    public function show(Request $request)
    {
        $vitalsign = $this->getData($request);

        if ($vitalsign == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $vitalsign);
    }

    public function update(Request $request)
    {
        $vitalsign = $this->getData($request);
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);

        if ($vitalsign == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $vitalsign->update([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'user_id' => $request->user_id,
        ]);
        $vitalsign->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $vitalsign);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $vitalsign = VitalSign::find($request->id);

        if ($vitalsign == null) return null;

        return $vitalsign;
    }
}
