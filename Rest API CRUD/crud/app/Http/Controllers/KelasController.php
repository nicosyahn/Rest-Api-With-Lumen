<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    

class KelasController extends Controller
{
    private $matkulTb;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->matkulTb = app('db')->table('matkul');
    }

    //
    public function getAll() {

        $dataMatkul = $this->matkulTb->get();

        return response($dataMatkul);

    }

    public function getOne($idMatkul) {

        $matkul = $this->matkulTb->find($idMatkul);
        
            if(!$matkul) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Mata Kuliah Tidak Ditemukan'
                ],404);
            }

        return response()->json($matkul);
    }

    public function deleteOne($id) {

        $matkul = $this->matkulTb
                        ->where('id', $id)
                        ->delete();
        
        if($matkul == 0) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Mata Kuliah Tidak Ditemukan'
                ],404);
        }

        return response()->json(['status' => 'OK', 'message' => 'Berhasil Menghapus Data Mata Kuliah']);
    }

    public function addOne(Request $request) {

        $matkulBaru = [
            'matkul' => $request->input('matkul'),
            'sks' => $request->input('sks'),
            'dosen' => $request->input('dosen')
        ];

        $idMatkul = $this->matkulTb->insertGetId($matkulBaru);
        return response([
            'status' => 'sukses',
            'message' => 'Berhasil Menambahkan Mata Kuliah',
            'id' => $idMatkul
        ]);
    }

    public function updateOne(Request $request, $id) {
        $dataUpdate = [
            'matkul' => $request->input('matkul'),
            'sks' => $request->input('sks'),
            'dosen' => $request->input('dosen')
        ];

        $updateMatkul = $this->matkulTb
                                ->where('id', $id)
                                ->update($dataUpdate);

                                if($updateMatkul == 0) {
                                    return response()->json([
                                        'status' => 'Gagal',
                                        'message' => 'Mata Kuliah Tidak Ditemukan'
                                        ],404);
                                }
                        
                                return response()->json([
                                    'status' => 'OK', 
                                    'message' => 'Berhasil Memperbarui Data Mata Kuliah']);

    }
}
