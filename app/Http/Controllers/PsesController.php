<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\Pses;

class PsesController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Pses::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'status_psikologi' => 'required|string|max:255',
            'sosial_ekonomi' => 'required|string|max:255',
            'spiritual' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);


        $pses = Pses::create([
            'status_psikologi' => $request->status_psikologi,
            'sosial_ekonomi' => $request->sosial_ekonomi,
            'spiritual' => $request->spiritual,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $pses);
    }

    public function destroy(Request $request)
    {
        $pses = $this->getData($request);

        if ($pses == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $pses->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $pses->deleted_at]);
    }

    public function show(Request $request)
    {
        $pses = $this->getData($request);

        if ($pses == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pses);
    }

    public function update(Request $request)
    {
        $pses = $this->getData($request);
        $this->validate($request, [
            'status_psikologi' => 'required|string|max:255',
            'sosial_ekonomi' => 'required|string|max:255',
            'spiritual' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);

        if ($pses == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $pses->update([
            'status_psikologi' => $request->status_psikologi,
            'sosial_ekonomi' => $request->sosial_ekonomi,
            'spiritual' => $request->spiritual,
            'user_id' => $request->user_id,
        ]);
        $pses->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pses);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $pses = Pses::find($request->id);

        if ($pses == null) return null;

        return $pses;
    }
}
