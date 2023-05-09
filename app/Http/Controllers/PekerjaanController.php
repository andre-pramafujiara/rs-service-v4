<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use App\Http\Helper;

class PekerjaanController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Pekerjaan::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function list()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Pekerjaan::select('id', 'name')->orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $pekerjaan = Pekerjaan::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $pekerjaan);
    }

    public function destroy(Request $request)
    {
        $pekerjaan = $this->getData($request);

        if ($pekerjaan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $pekerjaan->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $pekerjaan->deleted_at]);
    }

    public function show(Request $request)
    {
        $pekerjaan = $this->getData($request);

        if ($pekerjaan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pekerjaan);
    }

    public function update(Request $request)
    {
        $pekerjaan = $this->getData($request);
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $pekerjaan->update([
            'name' => $request->name,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pekerjaan);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $pendidikan = Pekerjaan::find($request->id);

        if($pendidikan == null) return null;

        return $pendidikan;
    }

}
