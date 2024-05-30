<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use Exception;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function list()
    {
        try {
            $kelas = Kelas::orderBy('id', 'DESC')->get();
            return api_success('Berhasil mengambil data kelas', $kelas);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function get(Request $request)
    {
        try {
            $id = $request->route('id');
            $kelas = Kelas::find($id);
            if (!$kelas) return api_failed('Data kelas tidak ditemukan');
            return api_success('Berhasil mengambil data kelas', $kelas);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $rules = [
                'id_semester' => 'required|exists:semester,id',
                'nama' => 'required|max:255|unique:kelas',
                'deskripsi' => 'max:255',
            ];

            $messages = [
                'id_semester.required' => 'Semester masih kosong',
                'id_semester.exists' => 'Semester tidak ditemukan',
                'nama.required' => 'Kelas masih kosong',
                'nama.unique' => 'Kelas sudah ada',
                'deskripsi.max' => 'Deskripsi maksimal 255 karakter',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            Kelas::create([
                'id_semester' => $request->id_semester,
                'id_wali' => $request->id_wali,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ]);
            return api_success('Berhasil tambah data kelas');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function update(Request $request)
    {
        try {
            $id = $request->route('id');
            $rules = [
                'id_semester' => 'required|exists:semester,id',
                'nama' => 'required|max:255|unique:kelas,nama,' . $id,
                'deskripsi' => 'max:255',
            ];
            $messages = [
                'id_semester.required' => 'Semester masih kosong',
                'id_semester.exists' => 'Semester tidak ditemukan',
                'nama.required' => 'Kelas masih kosong',
                'nama.unique' => 'Kelas sudah ada',
                'deskripsi.max' => 'Deskripsi maksimal 255 karakter',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            $kelas = Kelas::find($id);
            if (!$kelas) return api_failed('Data kelas tidak ditemukan');
            $update = [
                'id_semester' => $request->id_semester,
                'id_wali' => $request->id_wali,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ];
            $kelas->update($update);
            return api_success('Berhasil ubah data kelas');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function inactive(Request $request)
    {
        try {
            $id = $request->route('id');
            $kelas = Kelas::find($request->id);
            if (!$kelas) return api_failed('Data kelas tidak ditemukan');
            $kelas->active = !$kelas->active;
            $kelas->save();
            return api_success('Berhasil mengubah status kelas');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->route('id');
            $kelas = Kelas::find($id);
            if (!$kelas) return api_failed('Data kelas tidak ditemukan');
            $kelas->delete();
            return api_success('Berhasil hapus data kelas');
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}
