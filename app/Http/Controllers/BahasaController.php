<?php

namespace App\Http\Controllers;

use App\Models\Bahasa;
use Illuminate\Http\Request;
use App\Http\Helper;

class BahasaController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Bahasa::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function list()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Bahasa::select('id', 'name')->orderBy('created_at', 'desc')->get());
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $bahasa = Bahasa::create([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $bahasa);
    }

    public function destroy(Request $request)
    {
        $bahasa = $this->getData($request);

        if ($bahasa == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $bahasa->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $bahasa->deleted_at]);
    }

    public function show(Request $request)
    {
        $bahasa = $this->getData($request);

        if ($bahasa == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $bahasa);
    }

    public function update(Request $request)
    {
        $bahasa = $this->getData($request);
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $bahasa->update([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $bahasa);
    }
    
    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $bahasa = Bahasa::find($request->id);

        if ($bahasa == null) return null;

        return $bahasa;
    }
}
?>