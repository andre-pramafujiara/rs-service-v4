<?php

namespace App\Http\Controllers;

use App\Models\Laboratorium;
use Illuminate\Http\Request;
use App\Http\Helper;

class LaboratoriumController extends Controller
{
    use Helper;

    public function search(Request $request)
    {
        $this->validate($request, [
            'search' => 'required|string',
        ]);

        $laboratorium = Laboratorium::where('name', 'ILIKE', '%' . $request->search . '%')->orWhere('description', 'ILIKE', '%' . $request->search . '%')->orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15));

        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $laboratorium);
    }

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Laboratorium::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required',
            'description' => 'string|required',
            'user_id' => 'required|integer',
        ]);

        $laboratorium = Laboratorium::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $laboratorium);
    }

    public function destroy(Request $request)
    {
        $laboratorium = $this->getData($request);

        if ($laboratorium == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $laboratorium->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $laboratorium->deleted_at]);
    }

    public function show(Request $request)
    {
        $laboratorium = $this->getData($request);

        if ($laboratorium == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $laboratorium);
    }

    public function update(Request $request)
    {
        $laboratorium = $this->getData($request);
        $this->validate($request, [
            'name' => 'string|required',
            'description' => 'string|required',
            'user_id' => 'required|integer',
        ]);

        if ($laboratorium == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $laboratorium->name = $request->name;
        $laboratorium->description = $request->description;
        $laboratorium->user_id = $request->user_id;
        $laboratorium->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $laboratorium);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $laboratorium = Laboratorium::find($request->id);

        if ($laboratorium == null) return null;

        return $laboratorium;
    }
}
