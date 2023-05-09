<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;
use App\Http\Helper;
use App\Services\Temp;

class KamarController extends Controller
{
    use Helper;

    public $temp;

    public function __construct(Temp $temp)
    {
    	$this->temp = $temp;
    }

    public function tempKamarList(Request $request)
    {
        $data = $this->temp->kamarList($request->bearerToken(), $request->all());

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $data['data']);
    }

    public function tempKelasList(Request $request)
    {
        $data = $this->temp->kelasList($request->bearerToken());

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $data['data']);
    }

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Kamar::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'user_id' => 'required|integer',
            'kelas_kamar_id' => 'required|string|exists:kelas_kamar,id',
            'bangsal_id' => 'required|string|exists:bangsals,id',
            'status' => 'required|boolean',
            'active' => 'required|boolean',
        ]);

        $kamar = Kamar::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'kelas_kamar_id' => $request->kelas_kamar_id,
            'bangsal_id' => $request->bangsal_id,
            'status' => $request->status,
            'active' => $request->active,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $kamar);
    }

    public function destroy(Request $request)
    {
        $kamar = $this->getData($request);

        if ($kamar == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $kamar->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $kamar->deleted_at]);
    }

    public function show(Request $request)
    {
        $kamar = $this->getData($request);

        if ($kamar == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $kamar);
    }

    public function update(Request $request)
    {
        $kamar = $this->getData($request);
        $this->validate($request, [
            'name' => 'required',
            'user_id' => 'required|integer',
            'kelas_kamar_id' => 'required|string|exists:kelas_kamar,id',
            'bangsal_id' => 'required|string|exists:bangsals,id',
            'status' => 'required|boolean',
            'active' => 'required|boolean',
        ]);

        if ($kamar == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $kamar->name = $request->name;
        $kamar->user_id = $request->user_id;
        $kamar->kelas_kamar_id = $request->kelas_kamar_id;
        $kamar->bangsal_id = $request->bangsal_id;
        $kamar->status = $request->status;
        $kamar->active = $request->active;
        $kamar->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $kamar);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $kamar = Kamar::find($request->id);

        if ($kamar == null) return null;

        return $kamar;
    }
}
