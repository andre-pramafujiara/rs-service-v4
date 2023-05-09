<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use Illuminate\Http\Request;
use App\Http\Helper;

class AgamaController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Agama::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function list()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Agama::select('id', 'name')->orderBy('created_at', 'desc')->get());
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $agama = Agama::create([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $agama);
    }

    public function destroy(Request $request)
    {
        $agama = $this->getData($request);

        if ($agama == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $agama->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $agama->deleted_at]);
    }

    public function show(Request $request)
    {
        $agama = $this->getData($request);

        if ($agama == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $agama);
    }

    public function update(Request $request)
    {
        $agama = $this->getData($request);
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $agama->update([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $agama);
    }
    
    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $agama = Agama::find($request->id);

        if ($agama == null) return null;

        return $agama;
    }
}
?>