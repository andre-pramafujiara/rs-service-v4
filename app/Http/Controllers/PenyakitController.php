<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use Illuminate\Http\Request;
use App\Http\Helper;

class PenyakitController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Penyakit::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'kode' => 'required',
            'parent_id' => 'nullable|exists:penyakits,id',
            'user_id' => 'required|integer',
        ]);

        $penyakit = Penyakit::create([
            'name' => $request->name,
            'kode' => $request->kode,
            'parent_id' => $request->input('parent_id', null),
            'user_id' => $request->user_id,
            'note' => $request->input('note', ''),
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $penyakit);
    }

    public function destroy(Request $request)
    {
        $penyakit = $this->getData($request);

        if ($penyakit == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $penyakit->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $penyakit->deleted_at]);
    }

    public function show(Request $request)
    {
        $penyakit = $this->getData($request, true);

        if ($penyakit == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $penyakit);
    }

    public function update(Request $request)
    {
        $penyakit = $this->getData($request);
        $this->validate($request, [
            'name' => 'required',
            'kode' => 'required',
            'parent_id' => 'nullable|exists:penyakits,id',
            'user_id' => 'required|integer',
        ]);

        if ($penyakit == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $penyakit->name = $request->name;
        $penyakit->kode = $request->kode;
        $penyakit->user_id = $request->user_id;
        $penyakit->note = $request->input('note', '');
        $penyakit->parent_id = $request->input('parent_id', '');
        $penyakit->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $penyakit);
    }

    protected function getData($request, $child = false, $parent = false)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $penyakit = Penyakit::find($request->id);

        if ($penyakit == null) return null;

        if ($penyakit->parent_id && $parent) $penyakit = Penyakit::with('parent')->find($request->id);

        if ($child) $penyakit = Penyakit::with('child')->find($request->id);

        return $penyakit;
    }
}
