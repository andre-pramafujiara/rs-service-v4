<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\Dicubitus;

class DicubitusController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Dicubitus::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'bobot' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $dicubitus = Dicubitus::create([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $dicubitus);
    }

    public function destroy(Request $request)
    {
        $dicubitus = $this->getData($request);

        if ($dicubitus == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $dicubitus->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $dicubitus->deleted_at]);
    }

    public function show(Request $request)
    {
        $dicubitus = $this->getData($request);

        if ($dicubitus == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $dicubitus);
    }

    public function update(Request $request)
    {
        $dicubitus = $this->getData($request);
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'bobot' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        if ($dicubitus == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $dicubitus->update([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'user_id' => $request->user_id,
        ]);
        $dicubitus->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $dicubitus);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $dicubitus = Dicubitus::find($request->id);

        if ($dicubitus == null) return null;

        return $dicubitus;
    }
}
