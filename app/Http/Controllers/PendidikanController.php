<?php

namespace App\Http\Controllers;

use App\Models\Pendidikan;
use Illuminate\Http\Request;
use App\Http\Helper;

class PendidikanController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Pendidikan::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function list()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Pendidikan::select('id', 'name')->orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $pendidikan = Pendidikan::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $pendidikan);
    }

    public function destroy(Request $request)
    {
        $pendidikan = $this->getData($request);

        if ($pendidikan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $pendidikan->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $pendidikan->deleted_at]);
    }

    public function show(Request $request)
    {
        $pendidikan = $this->getData($request);

        if ($pendidikan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pendidikan);
    }
    
    public function update(Request $request)
    {
        $pendidikan = $this->getData($request);
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $pendidikan->update([
            'name' => $request->name,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pendidikan);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $pendidikan = Pendidikan::find($request->id);

        if ($pendidikan == null) return null;

        return $pendidikan;
    }
}