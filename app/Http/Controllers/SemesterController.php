<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;
use Exception;
use Illuminate\Support\Facades\Validator;

class SemesterController extends Controller
{
    public function list()
    {
        try {
            $semester = Semester::orderBy('id', 'DESC')->get();
            return api_success('Berhasil mengambil data semester', $semester);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function get(Request $request)
    {
        try {
            $id = $request->route('id');
            $semester = Semester::find($id);
            if (!$semester) return api_failed('Data semester tidak ditemukan');
            return api_success('Berhasil mengambil data semester', $semester);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $rules = [
                'nama' => 'required|max:255|unique:semester',
                'deskripsi' => 'max:255',
            ];

            $messages = [
                'nama.required' => 'Semester masih kosong',
                'nama.unique' => 'Semester sudah ada',
                'deskripsi.max' => 'Deskripsi maksimal 255 karakter',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            Semester::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ]);
            return api_success('Berhasil tambah data semester');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function update(Request $request)
    {
        try {
            $id = $request->route('id');
            $rules = [
                'nama' => 'required|max:255|unique:semester,nama,' . $request->id,
                'deskripsi' => 'max:255',
            ];
            $messages = [
                'nama.required' => 'Semester masih kosong',
                'nama.unique' => 'Semester sudah ada',
                'deskripsi.max' => 'Deskripsi maksimal 255 karakter',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            $semester = Semester::find($id);
            if (!$semester) return api_failed('Data semester tidak ditemukan');
            $update = [
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ];
            $semester->update($update);
            return api_success('Berhasil ubah data semester');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function inactive(Request $request)
    {
        try {
            $id = $request->route('id');
            $semester = Semester::find($request->id);
            if (!$semester) return api_failed('Data semester tidak ditemukan');
            $semester->active = !$semester->active;
            $semester->save();
            return api_success('Berhasil mengubah status semester');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->route('id');
            $semester = Semester::find($id);
            if (!$semester) return api_failed('Data semester tidak ditemukan');
            $semester->delete();
            return api_success('Berhasil hapus data semester');
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}
