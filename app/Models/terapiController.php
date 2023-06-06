<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class terapiController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Triase::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'Tindakan' => 'required|string|max:255',
            'Obat' => 'required|string|max:255',
        ]);

        //jam otomatis
        $time = Carbon::parse($request->jam_triase);
        // tanggal automatis
        $request->merge(['tanggal_triase' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);


        $terapi = terapi::create([
            'id' => $request->id,
            'Tindakan' => $request->Tindakan,
            'Obat' => $request->Obat,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $terapi);
    }

    public function destroy(Request $request)
    {
        $terapi = $this->getData($request);

        if ($terapi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $terapi->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $terapi->deleted_at]);
    }

    public function show(Request $request)
    {
        $terapi = $this->getData($request);

        if ($terapi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $terapi);
    }

    public function update(Request $request)
    {
        $terapi = $this->getData($request);
        $this->validate($request, [
            'id' => 'required|integer',
            'Tindakan' => 'required|string|max:255',
            'Obat' => 'required|string|max:255',
        ]);

        if ($terapi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        //jam otomatis
        $time = Carbon::parse($request->jam_triase);
        // tanggal Triase
        $request->merge(['tanggal_triase' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);

        $terapi->update([
            'id' => $request->id,
            'Tindakan' => $request->Tindakan,
            'Obat' => $request->Obat,
        ]);
        $terapi->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $terapi);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $terapi = terapi::find($request->id);

        if ($terapi == null) return null;

        return $terapi;
    }
}