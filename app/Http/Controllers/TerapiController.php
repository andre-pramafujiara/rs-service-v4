<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Terapi;
use App\Http\Helper;

class TerapiController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Terapi::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'Tindakan' => 'required|string|max:255',
            'Obat' => 'required|string|max:255',
        ]);


        $Terapi = Terapi::create([
            'Tindakan' => $request->Tindakan,
            'Obat' => $request->Obat,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $Terapi);
    }

    public function destroy(Request $request)
    {
        $Terapi = $this->getData($request);

        if ($Terapi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $Terapi->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $Terapi->deleted_at]);
    }

    public function show(Request $request)
    {
        $Terapi = $this->getData($request);

        if ($Terapi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $Terapi);
    }

    public function update(Request $request)
    {
        $Terapi = $this->getData($request);
        $this->validate($request, [
            'Tindakan' => 'required|string|max:255',
            'Obat' => 'required|string|max:255',
        ]);

        if ($Terapi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");
        $Terapi->update([
            'id' => $request->id,
            'Tindakan' => $request->Tindakan,
            'Obat' => $request->Obat,
        ]);
        $Terapi->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $Terapi);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $Terapi = Terapi::find($request->id);

        if ($Terapi == null) return null;

        return $Terapi;
    }
}