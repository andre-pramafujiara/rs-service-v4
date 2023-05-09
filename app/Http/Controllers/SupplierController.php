<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Helper;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Supplier::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'kode' => 'required|unique:suppliers',
            'telp' => 'nullable|regex:/^(\+)[0-9]{6,15}$/',
            'end_time_mou' => 'nullable|date',
            'user_id' => 'required|integer',
        ]);

        $supplier = Supplier::create([
            'name' => $request->name,
            'address' => $request->address,
            'kode' => $request->kode,
            'telp' => $request->input('telp', null),
            'end_time_mou' => $request->input('end_time_mou', null),
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $supplier);
    }

    public function destroy(Request $request)
    {
        $supplier = $this->getData($request);

        if ($supplier == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $supplier->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $supplier->deleted_at]);
    }

    public function show(Request $request)
    {
        $supplier = $this->getData($request);

        if ($supplier == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $supplier);
    }

    public function update(Request $request)
    {
        $supplier = $this->getData($request);
        if ($supplier == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");
        
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'kode' => [
                'required',
                Rule::unique('suppliers')->ignore($supplier->id),
            ],
            'telp' => 'nullable|regex:/^(\+)[0-9]{6,15}$/',
            'end_time_mou' => 'nullable|date',
            'user_id' => 'required|integer',
        ]);

        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->kode = $request->kode;
        $supplier->telp = $request->input('telp', null);
        $supplier->end_time_mou = $request->input('end_time_mou', null);
        $supplier->user_id = $request->user_id;
        $supplier->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $supplier);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);
        
        $supplier = Supplier::find($request->id);
        
        if ($supplier == null) return null;

        return $supplier;
    }
}
