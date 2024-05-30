<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use Exception;
use Illuminate\Support\Facades\Validator;

class JurnalController extends Controller
{
    public function list()
    {
        try {
            $jurnal = Jurnal::orderBy('id', 'DESC')->get();
            return api_success('Berhasil mengambil data jurnal', $jurnal);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function list_by_guru(Request $request)
    {
        try {
            $id_guru = $request->route('id');
            $jurnal = Jurnal::where('id_guru', $id_guru)->orderBy('id', 'DESC')->get();
            return api_success('Berhasil mengambil data jurnal berdasarkan guru', $jurnal);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function get(Request $request)
    {
        try {
            $id = $request->route('id');
            $jurnal = Jurnal::find($id);
            if (!$jurnal) return api_failed('Data jurnal tidak ditemukan');
            return api_success('Berhasil mengambil data jurnal', $jurnal);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $rules = [
                'id_semester' => 'required|exists:semester,id',
                'id_kelas' => 'required|exists:kelas,id',
                'id_mapel' => 'required|exists:mapel,id',
                'id_guru' => 'required|exists:guru,id',
                'jam_masuk' => 'required',
                'jam_keluar' => 'required',
                'materi' => 'required|max:255',
            ];
            $messages = [
                'id_semester.required' => 'Semester masih kosong',
                'id_semester.exists' => 'Semester tidak ditemukan',
                'id_kelas.required' => 'Kelas masih kosong',
                'id_kelas.exists' => 'Kelas tidak ditemukan',
                'id_mapel.required' => 'Mata pelajaran masih kosong',
                'id_mapel.exists' => 'Mata pelajaran tidak ditemukan',
                'id_guru.required' => 'Guru masih kosong',
                'id_guru.exists' => 'Guru tidak ditemukan',
                'jam_masuk.required' => 'Jam masuk masih kosong',
                'jam_keluar.required' => 'Jam keluar masih kosong',
                'materi.required' => 'Materi masih kosong',
                'materi.max' => 'Materi maksimal 255 karakter',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            Jurnal::create([
                'id_semester' => $request->id_semester,
                'id_kelas' => $request->id_kelas,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $request->id_guru,
                'jam_masuk' => $request->jam_masuk,
                'jam_keluar' => $request->jam_keluar,
                'materi' => $request->materi,
            ]);
            return api_success('Berhasil tambah data jurnal');
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
                'id_kelas' => 'required|exists:kelas,id',
                'id_mapel' => 'required|exists:mapel,id',
                'id_guru' => 'required|exists:guru,id',
                'jam_masuk' => 'required',
                'jam_keluar' => 'required',
                'materi' => 'required|max:255',
            ];
            $messages = [
                'id_semester.required' => 'Semester masih kosong',
                'id_semester.exists' => 'Semester tidak ditemukan',
                'id_kelas.required' => 'Kelas masih kosong',
                'id_kelas.exists' => 'Kelas tidak ditemukan',
                'id_mapel.required' => 'Mata pelajaran masih kosong',
                'id_mapel.exists' => 'Mata pelajaran tidak ditemukan',
                'id_guru.required' => 'Guru masih kosong',
                'id_guru.exists' => 'Guru tidak ditemukan',
                'jam_masuk.required' => 'Jam masuk masih kosong',
                'jam_keluar.required' => 'Jam keluar masih kosong',
                'materi.required' => 'Materi masih kosong',
                'materi.max' => 'Materi maksimal 255 karakter',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            $jurnal = Jurnal::find($id);
            if (!$jurnal) return api_failed('Data jurnal tidak ditemukan');
            $update = [
                'id_semester' => $request->id_semester,
                'id_kelas' => $request->id_kelas,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $request->id_guru,
                'jam_masuk' => $request->jam_masuk,
                'jam_keluar' => $request->jam_keluar,
                'materi' => $request->materi,
            ];
            $jurnal->update($update);
            return api_success('Berhasil ubah data jurnal');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function inactive(Request $request)
    {
        try {
            $id = $request->route('id');
            $jurnal = Jurnal::find($request->id);
            if (!$jurnal) return api_failed('Data jurnal tidak ditemukan');
            $jurnal->active = !$jurnal->active;
            $jurnal->save();
            return api_success('Berhasil mengubah status jurnal');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->route('id');
            $jurnal = Jurnal::find($id);
            if (!$jurnal) return api_failed('Data jurnal tidak ditemukan');
            $jurnal->delete();
            return api_success('Berhasil hapus data jurnal');
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}
