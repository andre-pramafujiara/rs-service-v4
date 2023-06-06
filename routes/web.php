<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\Controller;
use App\Http\Controllers\PoliklinikController;
use Illuminate\Support\Facades\Route;
use Laravel\Lumen\Routing\Router;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'after'], function () use ($router) {
    $router->group(['prefix' => 'poliklinik'], function () use ($router) {
        $router->get('/',  [
            'as' => 'poliklinik.index', 'uses' => 'PoliklinikController@index'
        ]);

        $router->get('/list',  [
            'as' => 'poliklinik.list', 'uses' => 'PoliklinikController@list'
        ]);

        $router->get('/show',  [
            'as' => 'poliklinik.show', 'uses' => 'PoliklinikController@show', 'middleware' => 'api:poliklinik:show'
        ]);

        $router->post('/',  [
            'as' => 'poliklinik.store', 'uses' => 'PoliklinikController@store', 'middleware' => 'api:poliklinik:store,poliklinik:all'
        ]);

        $router->delete('/',  [
            'as' => 'poliklinik.destroy', 'uses' => 'PoliklinikController@destroy', 'middleware' => 'api:poliklinik:destroy'
        ]);

        $router->patch('/',  [
            'as' => 'poliklinik.update', 'uses' => 'PoliklinikController@update', 'middleware' => 'api:poliklinik:update'
        ]);

        $router->get('/search',  [
            'as' => 'poliklinik.search', 'uses' => 'PoliklinikController@search', 'middleware' => 'api:poliklinik:all'
        ]);
    });
    
    $router->group(['prefix' => 'pasien'], function () use ($router) {
        $router->get('/', [
            'as' => 'pasien.index', 'uses' => 'PasienController@index', 'middleware' => 'api:pasien:all'
        ]);

        $router->get('/show', [
            'as' => 'pasien.show', 'uses' => 'PasienController@show', 'middleware' => 'api:pasien:show'
        ]);

        $router->post('/', [
            'as' => 'pasien.store', 'uses' => 'PasienController@store', 'middleware' => 'api:pasien:store'
        ]);

        $router->delete('/', [
            'as' => 'pasien.destroy', 'uses' => 'PasienController@destroy', 'middleware' => 'api:pasien:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pasien.update', 'uses' => 'PasienController@update', 'middleware' => 'api:pasien:update'
        ]);

        $router->get('/search', [
            'as' => 'pasien.search', 'uses' => 'PasienController@search'
        ]);
    });

    $router->group(['prefix' => 'vclaim'], function () use ($router) {
        $router->post('/peserta/nik', [
            'as' => 'vclaim.peserta.nik', 'uses' => 'VclaimController@PesertaByNIK', 'middleware' => 'api:pasien:store'
        ]);
    });

    $router->group(['prefix' => 'triase'], function () use ($router) {
        $router->get('/', [
            'as' => 'triase.index', 'uses' => 'TriaseController@index', 'middleware' => 'api:triase:all'
        ]);

        $router->get('/show', [
            'as' => 'triase.show', 'uses' => 'TriaseController@show', 'middleware' => 'api:triase:show'
        ]);

        $router->post('/', [
            'as' => 'triase.store', 'uses' => 'TriaseController@store', 'middleware' => 'api:triase:store'
        ]);

        $router->delete('/', [
            'as' => 'triase.destroy', 'uses' => 'TriaseController@destroy', 'middleware' => 'api:triase:destroy'
        ]);

        $router->patch('/', [
            'as' => 'triase.update', 'uses' => 'TriaseController@update', 'middleware' => 'api:triase:update'
        ]);
    });

    $router->group(['prefix' => 'spesialis'], function() use($router){
        $router->get('/', [
            'as' => 'specialist.index', 'uses' => 'SpecialistController@index', 'middleware' => 'api:spesialis:all'
        ]);

        $router->get('/show', [
            'as' => 'specialist.show', 'uses' => 'SpecialistController@show', 'middleware' => 'api:spesialis:show'
        ]);

        $router->post('/', [
            'as' => 'specialist.store', 'uses' => 'SpecialistController@store', 'middleware' => 'api:spesialis:store'
        ]);

        $router->delete('/', [
            'as' => 'specialist.destroy', 'uses' => 'SpecialistController@destroy', 'middleware' => 'api:spesialis:destroy'
        ]);

        $router->patch('/', [
            'as' => 'specialist.update', 'uses' => 'SpecialistController@update', 'middleware' => 'api:spesialis:update'
        ]);
    });

    $router->group(['prefix' => 'laboratorium'], function() use($router){
        $router->get('/', [
            'as' => 'laboratorium.index', 'uses' => 'LaboratoriumController@index', 'middleware' => 'api:laboratorium:all'
        ]);

        $router->get('/show', [
            'as' => 'laboratorium.show', 'uses' => 'LaboratoriumController@show', 'middleware' => 'api:laboratorium:show'
        ]);

        $router->post('/', [
            'as' => 'laboratorium.store', 'uses' => 'LaboratoriumController@store', 'middleware' => 'api:laboratorium:store'
        ]);

        $router->delete('/', [
            'as' => 'laboratorium.destroy', 'uses' => 'LaboratoriumController@destroy', 'middleware' => 'api:laboratorium:destroy'
        ]);

        $router->patch('/', [
            'as' => 'laboratorium.update', 'uses' => 'LaboratoriumController@update', 'middleware' => 'api:laboratorium:update'
        ]);
        $router->get('/search', [
            'as' => 'laboratorium.search', 'uses' => 'LaboratoriumController@search', 'middleware' => 'api:laboratorium:all'
        ]);
    });
    
    $router->group(['prefix' => 'bangsal'], function() use($router){
        $router->get('/', [
            'as' => 'bangsal.index', 'uses' => 'BangsalController@index', 'middleware' => 'api:bangsal:all'
        ]);

        $router->get('/show', [
            'as' => 'bangsal.show', 'uses' => 'BangsalController@show', 'middleware' => 'api:bangsal:show'
        ]);

        $router->post('/', [
            'as' => 'bangsal.store', 'uses' => 'BangsalController@store', 'middleware' => 'api:bangsal:store'
        ]);

        $router->delete('/', [
            'as' => 'bangsal.destroy', 'uses' => 'BangsalController@destroy', 'middleware' => 'api:bangsal:destroy'
        ]);

        $router->patch('/', [
            'as' => 'bangsal.update', 'uses' => 'BangsalController@update', 'middleware' => 'api:bangsal:update'
        ]);
    });

    $router->group(['prefix' => 'kelaskamar'], function() use($router){
        $router->get('/', [
            'as' => 'kelaskamar.index', 'uses' => 'KelasKamarController@index', 'middleware' => 'api:kelaskamar:all'
        ]);

        $router->get('/show', [
            'as' => 'kelaskamar.show', 'uses' => 'KelasKamarController@show', 'middleware' => 'api:kelaskamar:show'
        ]);

        $router->post('/', [
            'as' => 'kelaskamar.store', 'uses' => 'KelasKamarController@store', 'middleware' => 'api:kelaskamar:store'
        ]);

        $router->delete('/', [
            'as' => 'kelaskamar.destroy', 'uses' => 'KelasKamarController@destroy', 'middleware' => 'api:kelaskamar:destroy'
        ]);

        $router->patch('/', [
            'as' => 'kelaskamar.update', 'uses' => 'KelasKamarController@update', 'middleware' => 'api:kelaskamar:update'
        ]);
    });

    $router->group(['prefix' => 'radiologi'], function() use($router){
        $router->get('/', [
            'as' => 'radiologi.index', 'uses' => 'RadiologiController@index', 'middleware' => 'api:radiologi:all'
        ]);

        $router->get('/show', [
            'as' => 'radiologi.show', 'uses' => 'RadiologiController@show', 'middleware' => 'api:radiologi:show'
        ]);

        $router->post('/', [
            'as' => 'radiologi.store', 'uses' => 'RadiologiController@store', 'middleware' => 'api:radiologi:store'
        ]);

        $router->delete('/', [
            'as' => 'radiologi.destroy', 'uses' => 'RadiologiController@destroy', 'middleware' => 'api:radiologi:destroy'
        ]);

        $router->patch('/', [
            'as' => 'radiologi.update', 'uses' => 'RadiologiController@update', 'middleware' => 'api:radiologi:update'
        ]);

        $router->get('/search', [
            'as' => 'radiologi.search', 'uses' => 'RadiologiController@search', 'middleware' => 'api:radiologi:all'
        ]);
    });
    
    $router->group(['prefix' => 'kamar'], function() use($router){
        $router->get('/', [
            'as' => 'kamar.index', 'uses' => 'KamarController@index', 'middleware' => 'api:kamar:all'
        ]);

        $router->get('/show', [
            'as' => 'kamar.show', 'uses' => 'KamarController@show', 'middleware' => 'api:kamar:show'
        ]);

        $router->post('/', [
            'as' => 'kamar.store', 'uses' => 'KamarController@store', 'middleware' => 'api:kamar:store'
        ]);

        $router->delete('/', [
            'as' => 'kamar.destroy', 'uses' => 'KamarController@destroy', 'middleware' => 'api:kamar:destroy'
        ]);

        $router->patch('/', [
            'as' => 'kamar.update', 'uses' => 'KamarController@update', 'middleware' => 'api:kamar:update'
        ]);
    });

    $router->group(['prefix' => 'agama'], function() use($router){
        $router->get('/', [
            'as' => 'agama.index', 'uses' => 'AgamaController@index', 'middleware' => 'api:agama:all'
        ]);

        $router->get('/list', [
            'as' => 'agama.list', 'uses' => 'AgamaController@list', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/show', [
            'as' => 'agama.show', 'uses' => 'AgamaController@show', 'middleware' => 'api:agama:show'
        ]);

        $router->post('/', [
            'as' => 'agama.store', 'uses' => 'AgamaController@store', 'middleware' => 'api:agama:store'
        ]);

        $router->delete('/', [
            'as' => 'agama.destroy', 'uses' => 'AgamaController@destroy', 'middleware' => 'api:agama:destroy'
        ]);

        $router->patch('/', [
            'as' => 'agama.update', 'uses' => 'AgamaController@update', 'middleware' => 'api:agama:update'
        ]);
    });

    $router->group(['prefix' => 'pendidikan'], function() use($router){
        $router->get('/', [
            'as' => 'pendidikan.index', 'uses' => 'PendidikanController@index', 'middleware' => 'api:pendidikan:all'
        ]);

        $router->get('/list', [
            'as' => 'pendidikan.list', 'uses' => 'PendidikanController@list', 'middleware' => 'api:pendidikan:all'
        ]);

        $router->get('/show', [
            'as' => 'pendidikan.show', 'uses' => 'PendidikanController@show', 'middleware' => 'api:pendidikan:show'
        ]);

        $router->post('/', [
            'as' => 'pendidikan.store', 'uses' => 'PendidikanController@store', 'middleware' => 'api:pendidikan:store'
        ]);

        $router->delete('/', [
            'as' => 'pendidikan.destroy', 'uses' => 'PendidikanController@destroy', 'middleware' => 'api:pendidikan:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pendidikan.update', 'uses' => 'PendidikanController@update', 'middleware' => 'api:pendidikan:update'
        ]);
    });

    $router->group(['prefix' => 'penyakit'], function() use($router){
        $router->get('/', [
            'as' => 'penyakit.index', 'uses' => 'PenyakitController@index', 'middleware' => 'api:penyakit:all'
        ]);

        $router->get('/show', [
            'as' => 'penyakit.show', 'uses' => 'PenyakitController@show', 'middleware' => 'api:penyakit:show'
        ]);

        $router->post('/', [
            'as' => 'penyakit.store', 'uses' => 'PenyakitController@store', 'middleware' => 'api:penyakit:store'
        ]);

        $router->delete('/', [
            'as' => 'penyakit.destroy', 'uses' => 'PenyakitController@destroy', 'middleware' => 'api:penyakit:destroy'
        ]);

        $router->patch('/', [
            'as' => 'penyakit.update', 'uses' => 'PenyakitController@update', 'middleware' => 'api:penyakit:update'
        ]);
    });

    $router->group(['prefix' => 'unit'], function() use($router){
        $router->get('/', [
            'as' => 'unit.index', 'uses' => 'UnitController@index', 'middleware' => 'api:unit:all'
        ]);

        $router->get('/show', [
            'as' => 'unit.show', 'uses' => 'UnitController@show', 'middleware' => 'api:unit:show'
        ]);

        $router->post('/', [
            'as' => 'unit.store', 'uses' => 'UnitController@store', 'middleware' => 'api:unit:store'
        ]);

        $router->delete('/', [
            'as' => 'unit.destroy', 'uses' => 'UnitController@destroy', 'middleware' => 'api:unit:destroy'
        ]);

        $router->patch('/', [
            'as' => 'unit.update', 'uses' => 'UnitController@update', 'middleware' => 'api:unit:update'
        ]);
    });

    $router->group(['prefix' => 'supplier'], function() use($router){
        $router->get('/', [
            'as' => 'supplier.index', 'uses' => 'SupplierController@index', 'middleware' => 'api:supplier:all'
        ]);

        $router->get('/show', [
            'as' => 'supplier.show', 'uses' => 'SupplierController@show', 'middleware' => 'api:supplier:show'
        ]);

        $router->post('/', [
            'as' => 'supplier.store', 'uses' => 'SupplierController@store', 'middleware' => 'api:supplier:store'
        ]);

        $router->delete('/', [
            'as' => 'supplier.destroy', 'uses' => 'SupplierController@destroy', 'middleware' => 'api:supplier:destroy'
        ]);

        $router->patch('/', [
            'as' => 'supplier.update', 'uses' => 'SupplierController@update', 'middleware' => 'api:supplier:update'
        ]);
    });
    
    $router->group(['prefix' => 'pekerjaan'], function() use($router){
        $router->get('/', [
            'as' => 'pekerjaan.index', 'uses' => 'PekerjaanController@index', 'middleware' => 'api:pekerjaan:all'
        ]);

        $router->get('/list', [
            'as' => 'pekerjaan.list', 'uses' => 'PekerjaanController@list'
        ]);

        $router->get('/show', [
            'as' => 'pekerjaan.show', 'uses' => 'PekerjaanController@show', 'middleware' => 'api:pekerjaan:show'
        ]);

        $router->post('/', [
            'as' => 'pekerjaan.store', 'uses' => 'PekerjaanController@store', 'middleware' => 'api:pekerjaan:store'
        ]);

        $router->delete('/', [
            'as' => 'pekerjaan.destroy', 'uses' => 'PekerjaanController@destroy', 'middleware' => 'api:pekerjaan:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pekerjaan.update', 'uses' => 'PekerjaanController@update', 'middleware' => 'api:pekerjaan:update'
        ]);
    });

    $router->group(['prefix' => 'asuransi'], function() use($router){
        $router->get('/', [
            'as' => 'provinsi.index', 'uses' => 'AsuransiController@index', 'middleware' => 'api:asuransi:all'
        ]);

        $router->get('/show', [
            'as' => 'asuransi.show', 'uses' => 'AsuransiController@show', 'middleware' => 'api:asuransi:show'
        ]);

        $router->post('/', [
            'as' => 'asuransi.store', 'uses' => 'AsuransiController@store', 'middleware' => 'api:asuransi:store'
        ]);

        $router->delete('/', [
            'as' => 'asuransi.destroy', 'uses' => 'AsuransiController@destroy', 'middleware' => 'api:asuransi:destroy'
        ]);

        $router->patch('/', [
            'as' => 'asuransi.update', 'uses' => 'AsuransiController@update', 'middleware' => 'api:asuransi:update'
        ]);

        $router->get('/list', [
            'as' => 'asuransi.list', 'uses' => 'AsuransiController@list', 'middleware' => 'api:pasien:store'
        ]);
    });
    $router->group(['prefix' => 'suku'], function() use($router){
        $router->get('/', [
            'as' => 'suku.index', 'uses' => 'SukuController@index', 'middleware' => 'api:suku:all'
        ]);

        $router->get('/list', [
            'as' => 'suku.list', 'uses' => 'SukuController@list', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/show', [
            'as' => 'suku.show', 'uses' => 'SukuController@show', 'middleware' => 'api:suku:show'
        ]);

        $router->post('/', [
            'as' => 'suku.store', 'uses' => 'SukuController@store', 'middleware' => 'api:suku:store'
        ]);

        $router->delete('/', [
            'as' => 'suku.destroy', 'uses' => 'SukuController@destroy', 'middleware' => 'api:suku:destroy'
        ]);

        $router->patch('/', [
            'as' => 'suku.update', 'uses' => 'SukuController@update', 'middleware' => 'api:suku:update'
        ]);
    });
    $router->group(['prefix' => 'bahasa'], function() use($router){
        $router->get('/', [
            'as' => 'bahasa.index', 'uses' => 'BahasaController@index', 'middleware' => 'api:bahasa:all'
        ]);

        $router->get('/list', [
            'as' => 'bahasa.list', 'uses' => 'BahasaController@list', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/show', [
            'as' => 'bahasa.show', 'uses' => 'BahasaController@show', 'middleware' => 'api:bahasa:show'
        ]);

        $router->post('/', [
            'as' => 'bahasa.store', 'uses' => 'BahasaController@store', 'middleware' => 'api:bahasa:store'
        ]);

        $router->delete('/', [
            'as' => 'bahasa.destroy', 'uses' => 'BahasaController@destroy', 'middleware' => 'api:bahasa:destroy'
        ]);

        $router->patch('/', [
            'as' => 'bahasa.update', 'uses' => 'BahasaController@update', 'middleware' => 'api:bahasa:update'
        ]);
    });


    $router->group(['prefix' => 'temp'], function() use ($router) {
        $router->get('/dokter/list', [
            'as' => 'temp.dokter.list', 'uses' => 'TempDokterController@list', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/search/pasien/no-rm', [
            'as' => 'temp.pasien.search', 'uses' => 'PasienController@tempSearchByNoRM', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/kamar/list', [
            'as' => 'temp.kamar.list', 'uses' => 'KamarController@tempKamarList', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/kelas/list', [
            'as' => 'temp.kelas.list', 'uses' => 'KamarController@tempKelasList', 'middleware' => 'api:pasien:store'
        ]);
    });

    $router->group(['prefix' => 'rawat'], function() use ($router) {
        $router->get('/jalan', [
            'as' => 'temp.rawat.jalan.index', 'uses' => 'RawatJalanController@index', 'middleware' => 'api:pasien:store'
        ]);
        $router->get('/jalan/list', [
            'as' => 'temp.rawat.jalan.list', 'uses' => 'RawatJalanController@list', 'middleware' => 'api:pasien:store'
        ]);
        $router->post('/jalan', [
            'as' => 'temp.rawat.jalan.store', 'uses' => 'RawatJalanController@store', 'middleware' => 'api:pasien:store'
        ]);
        $router->get('/inap', [
            'as' => 'temp.rawat.inap.index', 'uses' => 'RawatInapController@index', 'middleware' => 'api:pasien:store'
        ]);
        $router->post('/inap', [
            'as' => 'temp.rawat.inap.store', 'uses' => 'RawatInapController@store', 'middleware' => 'api:pasien:store'
        ]);
    });


    $router->group(['prefix' => 'ugd'], function() use($router){
        $router->get('/', [
            'as' => 'ugd.index', 'uses' => 'UgdController@index', 'middleware' => 'api:ugd:all'
        ]);

        $router->get('/list', [
            'as' => 'ugd.list', 'uses' => 'UgdController@list', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/show', [
            'as' => 'ugd.show', 'uses' => 'UgdController@show', 'middleware' => 'api:ugd:show'
        ]);

        $router->post('/', [
            'as' => 'ugd.store', 'uses' => 'UgdController@store', 'middleware' => 'api:ugd:store'
        ]);

        $router->delete('/', [
            'as' => 'ugd.destroy', 'uses' => 'UgdController@destroy', 'middleware' => 'api:ugd:destroy'
        ]);

        $router->patch('/', [
            'as' => 'ugd.update', 'uses' => 'UgdController@update', 'middleware' => 'api:ugd:update'
        ]);
    });

    $router->group(['prefix' => 'penanggungjawab'], function() use($router){
        $router->get('/', [
            'as' => 'penanggungjawab.index', 'uses' => 'PenanggungjawabController@index', 'middleware' => 'api:penanggungjawab:all'
        ]);

        $router->get('/list', [
            'as' => 'penanggungjawab.list', 'uses' => 'PenanggungjawabController@list', 'middleware' => 'api:penanggungjawab:store'
        ]);

        $router->get('/show', [
            'as' => 'penanggungjawab.show', 'uses' => 'PenanggungjawabController@show', 'middleware' => 'api:penanggungjawab:show'
        ]);

        $router->post('/', [
            'as' => 'penanggungjawab.store', 'uses' => 'PenanggungjawabController@store', 'middleware' => 'api:penanggungjawab:store'
        ]);

        $router->delete('/', [
            'as' => 'penanggungjawab.destroy', 'uses' => 'PenanggungjawabController@destroy', 'middleware' => 'api:penanggungjawab:destroy'
        ]);

        $router->patch('/', [
            'as' => 'penanggungjawab.update', 'uses' => 'PenanggungjawabController@update', 'middleware' => 'api:penanggungjawab:update'
        ]);
    });

    $router->group(['prefix' => 'pengantar'], function() use($router){
        $router->get('/', [
            'as' => 'pengantar.index', 'uses' => 'PengantarController@index', 'middleware' => 'api:pengantar:all'
        ]);

        $router->get('/list', [
            'as' => 'pengantar.list', 'uses' => 'PengantarController@list', 'middleware' => 'api:pengantar:store'
        ]);

        $router->get('/show', [
            'as' => 'pengantar.show', 'uses' => 'PengantarController@show', 'middleware' => 'api:pengantar:show'
        ]);

        $router->post('/', [
            'as' => 'pengantar.store', 'uses' => 'PengantarController@store', 'middleware' => 'api:pengantar:store'
        ]);

        $router->delete('/', [
            'as' => 'pengantar.destroy', 'uses' => 'PengantarController@destroy', 'middleware' => 'api:pengantar:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pengantar.update', 'uses' => 'PengantarController@update', 'middleware' => 'api:pengantar:update'
        ]);
    });

    $router->group(['prefix' => 'bbl'], function() use($router){
        $router->get('/', [
            'as' => 'bbl.index', 'uses' => 'BblController@index', 'middleware' => 'api:bbl:all'
        ]);

        $router->get('/list', [
            'as' => 'bbl.list', 'uses' => 'BblController@list', 'middleware' => 'api:bbl:store'
        ]);

        $router->get('/show', [
            'as' => 'bbl.show', 'uses' => 'BblController@show', 'middleware' => 'api:bbl:show'
        ]);

        $router->post('/', [
            'as' => 'bbl.store', 'uses' => 'BblController@store', 'middleware' => 'api:bbl:store'
        ]);

        $router->delete('/', [
            'as' => 'bbl.destroy', 'uses' => 'BblController@destroy', 'middleware' => 'api:bbl:destroy'
        ]);

        $router->patch('/', [
            'as' => 'bbl.update', 'uses' => 'BblController@update', 'middleware' => 'api:bbl:update'
        ]);
    });

    $router->group(['prefix' => 'pasienb'], function() use($router){
        $router->get('/', [
            'as' => 'pasienb.index', 'uses' => 'PasienbController@index', 'middleware' => 'api:pasienb:all'
        ]);

        $router->get('/list', [
            'as' => 'pasienb.list', 'uses' => 'PasienbController@list', 'middleware' => 'api:pasienb:store'
        ]);

        $router->get('/show', [
            'as' => 'pasienb.show', 'uses' => 'PasienbController@show', 'middleware' => 'api:pasienb:show'
        ]);

        $router->post('/', [
            'as' => 'pasienb.store', 'uses' => 'PasienbController@store', 'middleware' => 'api:pasienb:store'
        ]);

        $router->delete('/', [
            'as' => 'pasienb.destroy', 'uses' => 'PasienbController@destroy', 'middleware' => 'api:pasienb:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pasienb.update', 'uses' => 'PasienbController@update', 'middleware' => 'api:pasienb:update'
        ]);
    });

    $router->group(['prefix' => 'antrian'], function() use($router){
        $router->get('/', [
            'as' => 'antrian.index', 'uses' => 'AntrianUgdController@index', 'middleware' => 'api:antrianugd:all'
        ]);

        $router->get('/list', [
            'as' => 'antrian.ambilantrian', 'uses' => 'AntrianUgdController@list', 'middleware' => 'api:antrianugd:store'
        ]);

        $router->get('/list', [
            'as' => 'antrian.bukaantrian', 'uses' => 'AntrianUgdController@list', 'middleware' => 'api:antrianugd:store'
        ]);

    });

    $router->group(['prefix' => 'anamnesis'], function() use($router){
        $router->get('/', [
            'as' => 'anamnesis.index', 'uses' => 'AnamnesisController@index', 'middleware' => 'api:anamnesis:all'
        ]);

        $router->get('/list', [
            'as' => 'anamnesis.list', 'uses' => 'AnamnesisController@list', 'middleware' => 'api:anamnesis:store'
        ]);

        $router->get('/show', [
            'as' => 'anamnesis.show', 'uses' => 'AnamnesisController@show', 'middleware' => 'api:anamnesis:show'
        ]);

        $router->post('/', [
            'as' => 'anamnesis.store', 'uses' => 'AnamnesisController@store', 'middleware' => 'api:anamnesis:store'
        ]);

        $router->delete('/', [
            'as' => 'anamnesis.destroy', 'uses' => 'AnamnesisController@destroy', 'middleware' => 'api:anamnesis:destroy'
        ]);

        $router->patch('/', [
            'as' => 'anamnesis.update', 'uses' => 'AnamnesisController@update', 'middleware' => 'api:anamnesis:update'
        ]);
    });

    $router->group(['prefix' => 'assesmennyeri'], function() use($router){
        $router->get('/', [
            'as' => 'assesmennyeri.index', 'uses' => 'AssesmennyeriController@index', 'middleware' => 'api:assesmennyeri:all'
        ]);

        $router->get('/list', [
            'as' => 'assesmennyeri.list', 'uses' => 'AssesmennyeriController@list', 'middleware' => 'api:assesmennyeri:store'
        ]);

        $router->get('/show', [
            'as' => 'assesmennyeri.show', 'uses' => 'AssesmennyeriController@show', 'middleware' => 'api:assesmennyeri:show'
        ]);

        $router->post('/', [
            'as' => 'assesmennyeri.store', 'uses' => 'AssesmennyeriController@store', 'middleware' => 'api:assesmennyeri:store'
        ]);

        $router->delete('/', [
            'as' => 'assesmennyeri.destroy', 'uses' => 'AssesmennyeriController@destroy', 'middleware' => 'api:assesmennyeri:destroy'
        ]);

        $router->patch('/', [
            'as' => 'assesmennyeri.update', 'uses' => 'AssesmennyeriController@update', 'middleware' => 'api:assesmennyeri:update'
        ]);
    });

    $router->group(['prefix' => 'assesmenawal'], function() use($router){
        $router->get('/', [
            'as' => 'assesmenawal.index', 'uses' => 'AssesmenawalController@index', 'middleware' => 'api:assesmenawal:all'
        ]);

        $router->get('/list', [
            'as' => 'assesmenawal.list', 'uses' => 'AssesmenawalController@list', 'middleware' => 'api:assesmenawal:store'
        ]);

        $router->get('/show', [
            'as' => 'assesmenawal.show', 'uses' => 'AssesmenawalController@show', 'middleware' => 'api:assesmenawal:show'
        ]);

        $router->post('/', [
            'as' => 'assesmenawal.store', 'uses' => 'AssesmenawalController@store', 'middleware' => 'api:assesmenawal:store'
        ]);

        $router->delete('/', [
            'as' => 'assesmenawal.destroy', 'uses' => 'AssesmenawalController@destroy', 'middleware' => 'api:assesmenawal:destroy'
        ]);

        $router->patch('/', [
            'as' => 'assesmenawal.update', 'uses' => 'AssesmenawalController@update', 'middleware' => 'api:assesmenawal:update'
        ]);
    });

    $router->group(['prefix' => 'pemulangan'], function() use($router){
        $router->get('/', [
            'as' => 'pemulangan.index', 'uses' => 'PemulanganController@index', 'middleware' => 'api:pemulangan:all'
        ]);

        $router->get('/list', [
            'as' => 'pemulangan.list', 'uses' => 'PemulanganController@list', 'middleware' => 'api:pemulangan:store'
        ]);

        $router->get('/show', [
            'as' => 'pemulangan.show', 'uses' => 'PemulanganController@show', 'middleware' => 'api:pemulangan:show'
        ]);

        $router->post('/', [
            'as' => 'pemulangan.store', 'uses' => 'PemulanganController@store', 'middleware' => 'api:pemulangan:store'
        ]);

        $router->delete('/', [
            'as' => 'pemulangan.destroy', 'uses' => 'PemulanganController@destroy', 'middleware' => 'api:pemulangan:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pemulangan.update', 'uses' => 'PemulanganController@update', 'middleware' => 'api:pemulangan:update'
        ]);
    });

    $router->group(['prefix' => 'persetujuanpasien'], function() use($router){
        $router->get('/', [
            'as' => 'persetujuanpasien.index', 'uses' => 'PersetujuanpasienController@index', 'middleware' => 'api:persetujuanpasien:all'
        ]);

        $router->get('/list', [
            'as' => 'persetujuanpasien.list', 'uses' => 'PersetujuanpasienController@list', 'middleware' => 'api:persetujuanpasien:store'
        ]);

        $router->get('/show', [
            'as' => 'persetujuanpasien.show', 'uses' => 'PersetujuanpasienController@show', 'middleware' => 'api:persetujuanpasien:show'
        ]);

        $router->post('/', [
            'as' => 'persetujuanpasien.store', 'uses' => 'PersetujuanpasienController@store', 'middleware' => 'api:persetujuanpasien:store'
        ]);

        $router->delete('/', [
            'as' => 'persetujuanpasien.destroy', 'uses' => 'PersetujuanpasienController@destroy', 'middleware' => 'api:persetujuanpasien:destroy'
        ]);

        $router->patch('/', [
            'as' => 'persetujuanpasien.update', 'uses' => 'PersetujuanpasienController@update', 'middleware' => 'api:persetujuanpasien:update'
        ]);
    });

    $router->group(['prefix' => 'persetujuanumum'], function() use($router){
        $router->get('/', [
            'as' => 'persetujuanumum.index', 'uses' => 'PersetujuanumumController@index', 'middleware' => 'api:persetujuanumum:all'
        ]);

        $router->get('/list', [
            'as' => 'persetujuanumum.list', 'uses' => 'PersetujuanumumController@list', 'middleware' => 'api:persetujuanumum:store'
        ]);

        $router->get('/show', [
            'as' => 'persetujuanumum.show', 'uses' => 'PersetujuanumumController@show', 'middleware' => 'api:persetujuanumum:show'
        ]);

        $router->post('/', [
            'as' => 'persetujuanumum.store', 'uses' => 'PersetujuanumumController@store', 'middleware' => 'api:persetujuanumum:store'
        ]);

        $router->delete('/', [
            'as' => 'persetujuanumum.destroy', 'uses' => 'PersetujuanumumController@destroy', 'middleware' => 'api:persetujuanumum:destroy'
        ]);

        $router->patch('/', [
            'as' => 'persetujuanumum.update', 'uses' => 'PersetujuanumumController@update', 'middleware' => 'api:persetujuanumum:update'
        ]);
    });

    $router->group(['prefix' => 'pses'], function() use($router){
        $router->get('/', [
            'as' => 'pses.index', 'uses' => 'PsesController@index', 'middleware' => 'api:pses:all'
        ]);

        $router->get('/list', [
            'as' => 'pses.list', 'uses' => 'PsesController@list', 'middleware' => 'api:pses:store'
        ]);

        $router->get('/show', [
            'as' => 'pses.show', 'uses' => 'PsesController@show', 'middleware' => 'api:pses:show'
        ]);

        $router->post('/', [
            'as' => 'pses.store', 'uses' => 'PsesController@store', 'middleware' => 'api:pses:store'
        ]);

        $router->delete('/', [
            'as' => 'pses.destroy', 'uses' => 'PsesController@destroy', 'middleware' => 'api:pses:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pses.update', 'uses' => 'PsesController@update', 'middleware' => 'api:pses:update'
        ]);
    });

    $router->group(['prefix' => 'riwayatobat'], function() use($router){
        $router->get('/', [
            'as' => 'riwayatobat.index', 'uses' => 'RiwayatobatController@index', 'middleware' => 'api:riwayatobat:all'
        ]);

        $router->get('/list', [
            'as' => 'riwayatobat.list', 'uses' => 'RiwayatobatController@list', 'middleware' => 'api:riwayatobat:store'
        ]);

        $router->get('/show', [
            'as' => 'riwayatobat.show', 'uses' => 'RiwayatobatController@show', 'middleware' => 'api:riwayatobat:show'
        ]);

        $router->post('/', [
            'as' => 'riwayatobat.store', 'uses' => 'RiwayatobatController@store', 'middleware' => 'api:riwayatobat:store'
        ]);

        $router->delete('/', [
            'as' => 'riwayatobat.destroy', 'uses' => 'RiwayatobatController@destroy', 'middleware' => 'api:riwayatobat:destroy'
        ]);

        $router->patch('/', [
            'as' => 'riwayatobat.update', 'uses' => 'RiwayatobatController@update', 'middleware' => 'api:riwayatobat:update'
        ]);
    });

    $router->group(['prefix' => 'screening'], function() use($router){
        $router->get('/', [
            'as' => 'screening.index', 'uses' => 'ScreeningController@index', 'middleware' => 'api:screening:all'
        ]);

        $router->get('/list', [
            'as' => 'screening.list', 'uses' => 'ScreeningController@list', 'middleware' => 'api:screening:store'
        ]);

        $router->get('/show', [
            'as' => 'screening.show', 'uses' => 'ScreeningController@show', 'middleware' => 'api:screening:show'
        ]);

        $router->post('/', [
            'as' => 'screening.store', 'uses' => 'ScreeningController@store', 'middleware' => 'api:screening:store'
        ]);

        $router->delete('/', [
            'as' => 'screening.destroy', 'uses' => 'ScreeningController@destroy', 'middleware' => 'api:screening:destroy'
        ]);

        $router->patch('/', [
            'as' => 'screening.update', 'uses' => 'ScreeningController@update', 'middleware' => 'api:screening:update'
        ]);
    });
    
    $router->group(['prefix' => 'pernyataan'], function() use($router){
        $router->get('/', [
            'as' => 'pernyataan.index', 'uses' => 'PernyataanController@index', 'middleware' => 'api:pernyataan:all'
        ]);

        $router->get('/list', [
            'as' => 'pernyataan.list', 'uses' => 'PernyataanController@list', 'middleware' => 'api:pernyataan:store'
        ]);

        $router->get('/show', [
            'as' => 'pernyataan.show', 'uses' => 'PernyataanController@show', 'middleware' => 'api:pernyataan:show'
        ]);

        $router->post('/', [
            'as' => 'pernyataan.store', 'uses' => 'PernyataanController@store', 'middleware' => 'api:pernyataan:store'
        ]);

        $router->delete('/', [
            'as' => 'pernyataan.destroy', 'uses' => 'PernyataanController@destroy', 'middleware' => 'api:pernyataan:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pernyataan.update', 'uses' => 'PernyataanController@update', 'middleware' => 'api:pernyataan:update'
        ]);
    });

    $router->group(['prefix' => 'gizi'], function() use($router){
        $router->get('/', [
            'as' => 'gizi.index', 'uses' => 'GiziController@index', 'middleware' => 'api:gizi:all'
        ]);

        $router->get('/list', [
            'as' => 'gizi.list', 'uses' => 'GiziController@list', 'middleware' => 'api:gizi:store'
        ]);

        $router->get('/show', [
            'as' => 'gizi.show', 'uses' => 'GiziController@show', 'middleware' => 'api:gizi:show'
        ]);

        $router->post('/', [
            'as' => 'gizi.store', 'uses' => 'GiziController@store', 'middleware' => 'api:gizi:store'
        ]);

        $router->delete('/', [
            'as' => 'gizi.destroy', 'uses' => 'GiziController@destroy', 'middleware' => 'api:gizi:destroy'
        ]);

        $router->patch('/', [
            'as' => 'gizi.update', 'uses' => 'GiziController@update', 'middleware' => 'api:gizi:update'
        ]);
    });

    $router->group(['prefix' => 'batuk'], function() use($router){
        $router->get('/', [
            'as' => 'batuk.index', 'uses' => 'BatukController@index', 'middleware' => 'api:batuk:all'
        ]);

        $router->get('/list', [
            'as' => 'batuk.list', 'uses' => 'BatukController@list', 'middleware' => 'api:batuk:store'
        ]);

        $router->get('/show', [
            'as' => 'batuk.show', 'uses' => 'BatukController@show', 'middleware' => 'api:batuk:show'
        ]);

        $router->post('/', [
            'as' => 'batuk.store', 'uses' => 'BatukController@store', 'middleware' => 'api:batuk:store'
        ]);

        $router->delete('/', [
            'as' => 'batuk.destroy', 'uses' => 'BatukController@destroy', 'middleware' => 'api:batuk:destroy'
        ]);

        $router->patch('/', [
            'as' => 'batuk.update', 'uses' => 'BatukController@update', 'middleware' => 'api:batuk:update'
        ]);
    });

    $router->group(['prefix' => 'dicubitus'], function() use($router){
        $router->get('/', [
            'as' => 'dicubitus.index', 'uses' => 'DicubitusController@index', 'middleware' => 'api:dicubitus:all'
        ]);

        $router->get('/list', [
            'as' => 'dicubitus.list', 'uses' => 'DicubitusController@list', 'middleware' => 'api:dicubitus:store'
        ]);

        $router->get('/show', [
            'as' => 'dicubitus.show', 'uses' => 'DicubitusController@show', 'middleware' => 'api:dicubitus:show'
        ]);

        $router->post('/', [
            'as' => 'dicubitus.store', 'uses' => 'DicubitusController@store', 'middleware' => 'api:dicubitus:store'
        ]);

        $router->delete('/', [
            'as' => 'dicubitus.destroy', 'uses' => 'DicubitusController@destroy', 'middleware' => 'api:dicubitus:destroy'
        ]);

        $router->patch('/', [
            'as' => 'dicubitus.update', 'uses' => 'DicubitusController@update', 'middleware' => 'api:dicubitus:update'
        ]);
    });

    $router->group(['prefix' => 'carabayar'], function() use($router){
        $router->get('/', [
            'as' => 'carabayar.index', 'uses' => 'CarabayarController@index', 'middleware' => 'api:carabayar:all'
        ]);

        $router->get('/list', [
            'as' => 'carabayar.list', 'uses' => 'CarabayarController@list', 'middleware' => 'api:carabayar:store'
        ]);

        $router->get('/show', [
            'as' => 'carabayar.show', 'uses' => 'CarabayarController@show', 'middleware' => 'api:carabayar:show'
        ]);

        $router->post('/', [
            'as' => 'carabayar.store', 'uses' => 'CarabayarController@store', 'middleware' => 'api:carabayar:store'
        ]);

        $router->delete('/', [
            'as' => 'carabayar.destroy', 'uses' => 'CarabayarController@destroy', 'middleware' => 'api:carabayar:destroy'
        ]);

        $router->patch('/', [
            'as' => 'carabayar.update', 'uses' => 'CarabayarController@update', 'middleware' => 'api:carabayar:update'
        ]);
    });

    $router->group(['prefix' => 'jatuh'], function() use($router){
        $router->get('/', [
            'as' => 'jatuh.index', 'uses' => 'JatuhController@index', 'middleware' => 'api:jatuh:all'
        ]);

        $router->get('/list', [
            'as' => 'jatuh.list', 'uses' => 'JatuhController@list', 'middleware' => 'api:jatuh:store'
        ]);

        $router->get('/show', [
            'as' => 'jatuh.show', 'uses' => 'JatuhController@show', 'middleware' => 'api:jatuh:show'
        ]);

        $router->post('/', [
            'as' => 'jatuh.store', 'uses' => 'JatuhController@store', 'middleware' => 'api:jatuh:store'
        ]);

        $router->delete('/', [
            'as' => 'jatuh.destroy', 'uses' => 'JatuhController@destroy', 'middleware' => 'api:jatuh:destroy'
        ]);

        $router->patch('/', [
            'as' => 'jatuh.update', 'uses' => 'jatuhController@update', 'middleware' => 'api:jatuh:update'
        ]);
    });

    $router->group(['prefix' => 'keadaanumum'], function() use($router){
        $router->get('/', [
            'as' => 'keadaanumum.index', 'uses' => 'KeadaanumumController@index', 'middleware' => 'api:keadaanumum:all'
        ]);

        $router->get('/list', [
            'as' => 'keadaanumum.list', 'uses' => 'KeadaanumumController@list', 'middleware' => 'api:keadaanumum:store'
        ]);

        $router->get('/show', [
            'as' => 'keadaanumum.show', 'uses' => 'KeadaanumumController@show', 'middleware' => 'api:keadaanumum:show'
        ]);

        $router->post('/', [
            'as' => 'keadaanumum.store', 'uses' => 'KeadaanumumController@store', 'middleware' => 'api:keadaanumum:store'
        ]);

        $router->delete('/', [
            'as' => 'keadaanumum.destroy', 'uses' => 'KeadaanumumController@destroy', 'middleware' => 'api:keadaanumum:destroy'
        ]);

        $router->patch('/', [
            'as' => 'keadaanumum.update', 'uses' => 'KeadaanumumController@update', 'middleware' => 'api:keadaanumum:update'
        ]);
    });

    $router->group(['prefix' => 'periksafisik'], function() use($router){
        $router->get('/', [
            'as' => 'periksafisik.index', 'uses' => 'PeriksafisikController@index', 'middleware' => 'api:periksafisik:all'
        ]);

        $router->get('/list', [
            'as' => 'periksafisik.list', 'uses' => 'PeriksafisikController@list', 'middleware' => 'api:periksafisik:store'
        ]);

        $router->get('/show', [
            'as' => 'periksafisik.show', 'uses' => 'PeriksafisikController@show', 'middleware' => 'api:periksafisik:show'
        ]);

        $router->post('/', [
            'as' => 'periksafisik.store', 'uses' => 'PeriksafisikController@store', 'middleware' => 'api:periksafisik:store'
        ]);

        $router->delete('/', [
            'as' => 'periksafisik.destroy', 'uses' => 'PeriksafisikController@destroy', 'middleware' => 'api:periksafisik:destroy'
        ]);

        $router->patch('/', [
            'as' => 'periksafisik.update', 'uses' => 'PeriksafisikController@update', 'middleware' => 'api:periksafisik:update'
        ]);
    });

    $router->group(['prefix' => 'tingkatkesadaran'], function() use($router){
        $router->get('/', [
            'as' => 'tingkatkesadaran.index', 'uses' => 'TingkatkesadaranController@index', 'middleware' => 'api:tingkatkesadaran:all'
        ]);

        $router->get('/list', [
            'as' => 'tingkatkesadaran.list', 'uses' => 'TingkatkesadaranController@list', 'middleware' => 'api:tingkatkesadaran:store'
        ]);

        $router->get('/show', [
            'as' => 'tingkatkesadaran.show', 'uses' => 'TingkatkesadaranController@show', 'middleware' => 'api:tingkatkesadaran:show'
        ]);

        $router->post('/', [
            'as' => 'tingkatkesadaran.store', 'uses' => 'TingkatkesadaranController@store', 'middleware' => 'api:tingkatkesadaran:store'
        ]);

        $router->delete('/', [
            'as' => 'tingkatkesadaran.destroy', 'uses' => 'TingkatkesadaranController@destroy', 'middleware' => 'api:tingkatkesadaran:destroy'
        ]);

        $router->patch('/', [
            'as' => 'tingkatkesadaran.update', 'uses' => 'TingkatkesadaranController@update', 'middleware' => 'api:tingkatkesadaran:update'
        ]);
    });

    $router->group(['prefix' => 'vitalsign'], function() use($router){
        $router->get('/', [
            'as' => 'vitalsign.index', 'uses' => 'VitalsignController@index', 'middleware' => 'api:vitalsign:all'
        ]);

        $router->get('/list', [
            'as' => 'vitalsign.list', 'uses' => 'VitalsignController@list', 'middleware' => 'api:vitalsign:store'
        ]);

        $router->get('/show', [
            'as' => 'vitalsign.show', 'uses' => 'VitalsignController@show', 'middleware' => 'api:vitalsign:show'
        ]);

        $router->post('/', [
            'as' => 'vitalsign.store', 'uses' => 'VitalsignController@store', 'middleware' => 'api:vitalsign:store'
        ]);

        $router->delete('/', [
            'as' => 'vitalsign.destroy', 'uses' => 'VitalsignController@destroy', 'middleware' => 'api:vitalsign:destroy'
        ]);

        $router->patch('/', [
            'as' => 'vitalsign.update', 'uses' => 'VitalsignController@update', 'middleware' => 'api:vitalsign:update'
        ]);
    });

    $router->group(['prefix' => 'pemeriksaanpenunjang'], function() use($router){
        $router->get('/', [
            'as' => 'pemeriksaanpenunjang.index', 'uses' => 'PemeriksaanPenunjangController@index', 'middleware' => 'api:pemeriksaanpenunjang:all'
        ]);

        $router->get('/list', [
            'as' => 'pemeriksaanpenunjang.list', 'uses' => 'PemeriksaanPenunjangController@list', 'middleware' => 'api:pemeriksaanpenunjang:store'
        ]);

        $router->get('/show', [
            'as' => 'pemeriksaanpenunjang.show', 'uses' => 'PemeriksaanPenunjangController@show', 'middleware' => 'api:pemeriksaanpenunjang:show'
        ]);

        $router->post('/', [
            'as' => 'pemeriksaanpenunjang.store', 'uses' => 'PemeriksaanPenunjangController@store', 'middleware' => 'api:pemeriksaanpenunjang:store'
        ]);

        $router->delete('/', [
            'as' => 'pemeriksaanpenunjang.destroy', 'uses' => 'PemeriksaanPenunjangController@destroy', 'middleware' => 'api:pemeriksaanpenunjang:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pemeriksaanpenunjang.update', 'uses' => 'PemeriksaanPenunjangController@update', 'middleware' => 'api:pemeriksaanpenunjang:update'
        ]);
    });

    $router->group(['prefix' => 'diagnosis'], function() use($router){
        $router->get('/', [
            'as' => 'diagnosis.index', 'uses' => 'DiagnosisController@index', 'middleware' => 'api:diagnosis:all'
        ]);

        $router->get('/list', [
            'as' => 'diagnosis.list', 'uses' => 'DiagnosisController@list', 'middleware' => 'api:diagnosis:store'
        ]);

        $router->get('/show', [
            'as' => 'diagnosis.show', 'uses' => 'DiagnosisController@show', 'middleware' => 'api:diagnosis:show'
        ]);

        $router->post('/', [
            'as' => 'diagnosis.store', 'uses' => 'DiagnosisController@store', 'middleware' => 'api:diagnosis:store'
        ]);

        $router->delete('/', [
            'as' => 'diagnosis.destroy', 'uses' => 'DiagnosisController@destroy', 'middleware' => 'api:diagnosis:destroy'
        ]);

        $router->patch('/', [
            'as' => 'diagnosis.update', 'uses' => 'DiagnosisController@update', 'middleware' => 'api:diagnosis:update'
        ]);
    });

    $router->group(['prefix' => 'persetujuantindakan'], function() use($router){
        $router->get('/', [
            'as' => 'persetujuantindakan.index', 'uses' => 'PersetujuanTindakanController@index', 'middleware' => 'api:persetujuantindakan:all'
        ]);

        $router->get('/list', [
            'as' => 'persetujuantindakan.list', 'uses' => 'PersetujuanTindakanController@list', 'middleware' => 'api:persetujuantindakan:store'
        ]);

        $router->get('/show', [
            'as' => 'persetujuantindakan.show', 'uses' => 'PersetujuanTindakanController@show', 'middleware' => 'api:persetujuantindakan:show'
        ]);

        $router->post('/', [
            'as' => 'persetujuantindakan.store', 'uses' => 'PersetujuanTindakanController@store', 'middleware' => 'api:persetujuantindakan:store'
        ]);

        $router->delete('/', [
            'as' => 'persetujuantindakan.destroy', 'uses' => 'PersetujuanTindakanController@destroy', 'middleware' => 'api:persetujuantindakan:destroy'
        ]);

        $router->patch('/', [
            'as' => 'persetujuantindakan.update', 'uses' => 'PersetujuanTindakanController@update', 'middleware' => 'api:persetujuantindakan:update'
        ]);
    });

    $router->group(['prefix' => 'terapi'], function() use($router){
        $router->get('/', [
            'as' => 'terapi.index', 'uses' => 'TerapiController@index', 'middleware' => 'api:terapi:all'
        ]);

        $router->get('/list', [
            'as' => 'terapi.list', 'uses' => 'TerapiController@list', 'middleware' => 'api:terapi:store'
        ]);

        $router->get('/show', [
            'as' => 'terapi.show', 'uses' => 'TerapiController@show', 'middleware' => 'api:terapi:show'
        ]);

        $router->post('/', [
            'as' => 'terapi.store', 'uses' => 'TerapiController@store', 'middleware' => 'api:terapi:store'
        ]);

        $router->delete('/', [
            'as' => 'terapi.destroy', 'uses' => 'TerapiController@destroy', 'middleware' => 'api:terapi:destroy'
        ]);

        $router->patch('/', [
            'as' => 'terapi.update', 'uses' => 'TerapiController@update', 'middleware' => 'api:terapi:update'
        ]);
    });
    
    $router->group(['prefix' => 'membuatpernyataan'], function() use($router){
        $router->get('/', [
            'as' => 'membuatpernyataan.index', 'uses' => 'MembuatpernyataanController@index', 'middleware' => 'api:membuatpernyataan:all'
        ]);

        $router->get('/list', [
            'as' => 'membuatpernyataan.list', 'uses' => 'MembuatpernyataanController@list', 'middleware' => 'api:membuatpernyataan:store'
        ]);

        $router->get('/show', [
            'as' => 'membuatpernyataan.show', 'uses' => 'MembuatpernyataanController@show', 'middleware' => 'api:membuatpernyataan:show'
        ]);

        $router->post('/', [
            'as' => 'membuatpernyataan.store', 'uses' => 'MembuatpernyataanController@store', 'middleware' => 'api:membuatpernyataan:store'
        ]);

        $router->delete('/', [
            'as' => 'membuatpernyataan.destroy', 'uses' => 'MembuatpernyataanController@destroy', 'middleware' => 'api:membuatpernyataan:destroy'
        ]);

        $router->patch('/', [
            'as' => 'membuatpernyataan.update', 'uses' => 'MembuatpernyataanController@update', 'middleware' => 'api:membuatpernyataan:update'
        ]);
    });

    $router->group(['prefix' => 'obat'], function() use($router){
        $router->get('/', [
            'as' => 'obat.index', 'uses' => 'ObatController@index', 'middleware' => 'api:obat:all'
        ]);

        $router->get('/list', [
            'as' => 'obat.list', 'uses' => 'ObatController@list', 'middleware' => 'api:obat:store'
        ]);

        $router->get('/show', [
            'as' => 'obat.show', 'uses' => 'ObatController@show', 'middleware' => 'api:obat:show'
        ]);

        $router->post('/', [
            'as' => 'obat.store', 'uses' => 'ObatController@store', 'middleware' => 'api:obat:store'
        ]);

        $router->delete('/', [
            'as' => 'obat.destroy', 'uses' => 'ObatController@destroy', 'middleware' => 'api:obat:destroy'
        ]);

        $router->patch('/', [
            'as' => 'obat.update', 'uses' => 'ObatController@update', 'middleware' => 'api:obat:update'
        ]);
    });

    $router->group(['prefix' => 'tindakan'], function() use($router){
        $router->get('/', [
            'as' => 'tindakan.index', 'uses' => 'TindakanController@index', 'middleware' => 'api:tindakan:all'
        ]);

        $router->get('/list', [
            'as' => 'tindakan.list', 'uses' => 'TindakanController@list', 'middleware' => 'api:tindakan:store'
        ]);

        $router->get('/show', [
            'as' => 'tindakan.show', 'uses' => 'TindakanController@show', 'middleware' => 'api:tindakan:show'
        ]);

        $router->post('/', [
            'as' => 'tindakan.store', 'uses' => 'TindakanController@store', 'middleware' => 'api:tindakan:store'
        ]);

        $router->delete('/', [
            'as' => 'tindakan.destroy', 'uses' => 'TindakanController@destroy', 'middleware' => 'api:tindakan:destroy'
        ]);

        $router->patch('/', [
            'as' => 'tindakan.update', 'uses' => 'TindakanController@update', 'middleware' => 'api:tindakan:update'
        ]);
    });

    $router->group(['prefix' => 'riwayatpenyakit'], function() use($router){
        $router->get('/', [
            'as' => 'riwayatpenyakit.index', 'uses' => 'RiwayatpenyakitController@index', 'middleware' => 'api:riwayatpenyakit:all'
        ]);

        $router->get('/list', [
            'as' => 'riwayatpenyakit.list', 'uses' => 'RiwayatpenyakitController@list', 'middleware' => 'api:riwayatpenyakit:store'
        ]);

        $router->get('/show', [
            'as' => 'riwayatpenyakit.show', 'uses' => 'RiwayatpenyakitController@show', 'middleware' => 'api:riwayatpenyakit:show'
        ]);

        $router->post('/', [
            'as' => 'riwayatpenyakit.store', 'uses' => 'RiwayatpenyakitController@store', 'middleware' => 'api:riwayatpenyakit:store'
        ]);

        $router->delete('/', [
            'as' => 'riwayatpenyakit.destroy', 'uses' => 'RiwayatpenyakitController@destroy', 'middleware' => 'api:riwayatpenyakit:destroy'
        ]);

        $router->patch('/', [
            'as' => 'riwayatpenyakit.update', 'uses' => 'RiwayatpenyakitController@update', 'middleware' => 'api:riwayatpenyakit:update'
        ]);
    });

    $router->group(['prefix' => 'ugddokter'], function() use($router){
        $router->get('/', [
            'as' => 'ugddokter.index', 'uses' => 'UgddokterController@index', 'middleware' => 'api:ugddokter:all'
        ]);

        $router->get('/list', [
            'as' => 'ugddokter.list', 'uses' => 'UgddokterController@list', 'middleware' => 'api:ugddokter:store'
        ]);

        $router->get('/show', [
            'as' => 'ugddokter.show', 'uses' => 'UgddokterController@show', 'middleware' => 'api:ugddokter:show'
        ]);

        $router->post('/', [
            'as' => 'ugddokter.store', 'uses' => 'UgddokterController@store', 'middleware' => 'api:ugddokter:store'
        ]);

        $router->delete('/', [
            'as' => 'ugddokter.destroy', 'uses' => 'UgddokterController@destroy', 'middleware' => 'api:ugddokter:destroy'
        ]);

        $router->patch('/', [
            'as' => 'ugddokter.update', 'uses' => 'UgddokterController@update', 'middleware' => 'api:ugddokter:update'
        ]);
    });

    $router->group(['prefix' => 'ugdperawat'], function() use($router){
        $router->get('/', [
            'as' => 'ugdperawat.index', 'uses' => 'UgdperawatController@index', 'middleware' => 'api:ugdperawat:all'
        ]);

        $router->get('/list', [
            'as' => 'ugdperawat.list', 'uses' => 'UgdperawatController@list', 'middleware' => 'api:ugdperawat:store'
        ]);

        $router->get('/show', [
            'as' => 'ugdperawat.show', 'uses' => 'UgdperawatController@show', 'middleware' => 'api:ugdperawat:show'
        ]);

        $router->post('/', [
            'as' => 'ugdperawat.store', 'uses' => 'UgdperawatController@store', 'middleware' => 'api:ugdperawat:store'
        ]);

        $router->delete('/', [
            'as' => 'ugdperawat.destroy', 'uses' => 'UgdperawatController@destroy', 'middleware' => 'api:ugdperawat:destroy'
        ]);

        $router->patch('/', [
            'as' => 'ugdperawat.update', 'uses' => 'UgdperawatController@update', 'middleware' => 'api:ugdperawat:update'
        ]);
    });

    $router->group(['prefix' => 'rencanarawat'], function() use($router){
        $router->get('/', [
            'as' => 'rencanarawat.index', 'uses' => 'RencanarawatController@index', 'middleware' => 'api:rencanarawat:all'
        ]);

        $router->get('/list', [
            'as' => 'rencanarawat.list', 'uses' => 'RencanarawatController@list', 'middleware' => 'api:rencanarawat:store'
        ]);

        $router->get('/show', [
            'as' => 'rencanarawat.show', 'uses' => 'RencanarawatController@show', 'middleware' => 'api:rencanarawat:show'
        ]);

        $router->post('/', [
            'as' => 'rencanarawat.store', 'uses' => 'RencanarawatController@store', 'middleware' => 'api:rencanarawat:store'
        ]);

        $router->delete('/', [
            'as' => 'rencanarawat.destroy', 'uses' => 'RencanarawatController@destroy', 'middleware' => 'api:rencanarawat:destroy'
        ]);

        $router->patch('/', [
            'as' => 'rencanarawat.update', 'uses' => 'RencanarawatController@update', 'middleware' => 'api:rencanarawat:update'
        ]);
    });

    $router->group(['prefix' => 'assesmenawaldokterugd'], function() use($router){
        $router->get('/', [
            'as' => 'assesmenawaldokterugd.index', 'uses' => 'AssesmenawaldokterugdController@index', 'middleware' => 'api:assesmenawaldokterugd:all'
        ]);

        $router->get('/list', [
            'as' => 'assesmenawaldokterugd.list', 'uses' => 'AssesmenawaldokterugdController@list', 'middleware' => 'api:assesmenawaldokterugd:store'
        ]);

        $router->get('/show', [
            'as' => 'assesmenawaldokterugd.show', 'uses' => 'AssesmenawaldokterugdController@show', 'middleware' => 'api:assesmenawaldokterugd:show'
        ]);

        $router->post('/', [
            'as' => 'assesmenawaldokterugd.store', 'uses' => 'AssesmenawaldokterugdController@store', 'middleware' => 'api:assesmenawaldokterugd:store'
        ]);

        $router->delete('/', [
            'as' => 'assesmenawaldokterugd.destroy', 'uses' => 'AssesmenawaldokterugdController@destroy', 'middleware' => 'api:assesmenawaldokterugd:destroy'
        ]);

        $router->patch('/', [
            'as' => 'assesmenawaldokterugd.update', 'uses' => 'AssesmenawaldokterugdController@update', 'middleware' => 'api:assesmenawaldokterugd:update'
        ]);
    });
});
