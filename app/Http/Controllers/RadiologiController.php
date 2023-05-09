<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Radiologi;
use Illuminate\Http\Request;

class RadiologiController extends Controller
{
    use Helper;
    
    public function search(Request $request)
    {
        $this->validate($request, [
            'search' => 'required|string',
        ]);

        $radiologi = Radiologi::where('name', 'ILIKE', '%' . $request->search . '%')->orWhere('description', 'ILIKE', '%' . $request->search . '%')->orWhere('price', 'ILIKE', '%' . $request->search .'%')->orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15));

        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $radiologi);
    }

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Radiologi::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
            'description' => 'string',
            'price' => 'required|numeric',
        ]);

        $radiologi = Radiologi::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $radiologi);
    }

    public function destroy(Request $request)
    {
        $radiologi = $this->getData($request);

        if ($radiologi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $radiologi->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $radiologi->deleted_at]);
    }

    public function show(Request $request)
    {
        $radiologi = $this->getData($request);

        if ($radiologi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $radiologi);
    }

    public function update(Request $request)
    {
        $radiologi = $this->getData($request);
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        if ($radiologi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $radiologi->name = $request->name;
        $radiologi->user_id = $request->user_id;
        $radiologi->description = $request->description;
        $radiologi->price = $request->price;
        $radiologi->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $radiologi);
    }

    private function getData(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|string'
        ]);

        return Radiologi::find($request->id);
    }
    
}
