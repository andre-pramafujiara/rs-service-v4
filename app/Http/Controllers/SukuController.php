<?php

namespace App\Http\Controllers;

use App\Models\Suku;
use Illuminate\Http\Request;
use App\Http\Helper;

class SukuController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Suku::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function list()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Suku::select('id', 'name')->orderBy('created_at', 'desc')->get());
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $suku = Suku::create([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $suku);
    }

    public function destroy(Request $request)
    {
        $suku = $this->getData($request);

        if ($suku == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $suku->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $suku->deleted_at]);
    }

    public function show(Request $request)
    {
        $suku = $this->getData($request);

        if ($suku == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $suku);
    }

    public function update(Request $request)
    {
        $suku = $this->getData($request);
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $suku->update([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $suku);
    }
    
    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $suku = Suku::find($request->id);

        if ($suku == null) return null;

        return $suku;
    }
}
?>