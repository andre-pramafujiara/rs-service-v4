<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\TingkatKesadaran;

class TingkatkesadaranController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], TingkatKesadaran::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'bobot' => 'required|integer',
            'user_id' => 'required|integer',
        ]);


        $tingkatkesadaran = TingkatKesadaran::create([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $tingkatkesadaran);
    }

    public function destroy(Request $request)
    {
        $tingkatkesadaran = $this->getData($request);

        if ($tingkatkesadaran == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $tingkatkesadaran->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $tingkatkesadaran->deleted_at]);
    }

    public function show(Request $request)
    {
        $tingkatkesadaran = $this->getData($request);

        if ($tingkatkesadaran == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $tingkatkesadaran);
    }

    public function update(Request $request)
    {
        $tingkatkesadaran = $this->getData($request);
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'bobot' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        if ($tingkatkesadaran == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $tingkatkesadaran->update([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'user_id' => $request->user_id,
        ]);
        $tingkatkesadaran->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $tingkatkesadaran);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $tingkatkesadaran = TingkatKesadaran::find($request->id);

        if ($tingkatkesadaran == null) return null;

        return $tingkatkesadaran;
    }
}
