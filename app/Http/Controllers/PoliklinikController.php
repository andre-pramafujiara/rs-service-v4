<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use Illuminate\Http\Request;
use App\Http\Helper;
use Illuminate\Support\Facades\DB;

class PoliklinikController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Poliklinik::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function list()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Poliklinik::select('id', 'name', 'created_at')->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'user_id' => 'required|integer',
        ]);

        $poliklinik = Poliklinik::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $poliklinik);
    }

    public function destroy(Request $request)
    {
        $poliklinik = $this->getData($request);

        if ($poliklinik == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $poliklinik->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $poliklinik->deleted_at]);
    }

    public function show(Request $request)
    {
        $poliklinik = $this->getData($request);

        if ($poliklinik == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $poliklinik);
    }

    public function update(Request $request)
    {
        $poliklinik = $this->getData($request);
        $this->validate($request, [
            'name' => 'required',
            'user_id' => 'required|integer',
        ]);

        if ($poliklinik == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $poliklinik->name = $request->name;
        $poliklinik->user_id = $request->user_id;
        $poliklinik->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $poliklinik);
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'search' => 'required',
        ]);

        $poliklinik = Poliklinik::where('name', 'ILIKE', '%' . $request->search . '%')->orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15));

        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $poliklinik);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $poliklinik = Poliklinik::find($request->id);

        if ($poliklinik == null) return null;

        return $poliklinik;
    }
}
