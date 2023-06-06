<?php

namespace App\Http\Controllers;

use App\Model\Jatuh;
use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\Jatuh as ModelsJatuh;

class JatuhController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ModelsJatuh::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function list()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ModelsJatuh::select('id', 'name')->orderBy('created_at', 'desc')->get());
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $jatuh = ModelsJatuh::create([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $jatuh);
    }

    public function destroy(Request $request)
    {
        $jatuh = $this->getData($request);

        if ($jatuh == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $jatuh->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $jatuh->deleted_at]);
    }

    public function show(Request $request)
    {
        $jatuh = $this->getData($request);

        if ($jatuh == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $jatuh);
    }

    public function update(Request $request)
    {
        $jatuh = $this->getData($request);
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $jatuh->update([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $jatuh);
    }
    
    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $jatuh = ModelsJatuh::find($request->id);

        if ($jatuh == null) return null;

        return $jatuh;
    }
}
?>