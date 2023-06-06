<?php

namespace App\Http\Controllers;

use App\Models\CaraBayar;
use Illuminate\Http\Request;
use App\Http\Helper;

class CarabayarController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], CaraBayar::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function list()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], CaraBayar::select('id', 'name')->orderBy('created_at', 'desc')->get());
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $carabayar = CaraBayar::create([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $carabayar);
    }

    public function destroy(Request $request)
    {
        $carabayar = $this->getData($request);

        if ($carabayar == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $carabayar->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $carabayar->deleted_at]);
    }

    public function show(Request $request)
    {
        $carabayar = $this->getData($request);

        if ($carabayar == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $carabayar);
    }

    public function update(Request $request)
    {
        $carabayar = $this->getData($request);
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $carabayar->update([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $carabayar);
    }
    
    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $carabayar = CaraBayar::find($request->id);

        if ($carabayar == null) return null;

        return $carabayar;
    }
}
?>