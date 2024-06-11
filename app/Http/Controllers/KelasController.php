<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Murid;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function list()
    {
        try {
            $kelas = Kelas::leftJoin('guru', 'kelas.id_wali', '=', 'guru.id')
                ->leftJoin('murid', 'kelas.id', '=', 'murid.id_kelas')
                ->groupBy('kelas.id')
                ->orderBy('kelas.id', 'DESC')
                ->get([
                    'kelas.id',
                    'kelas.nama as name',
                    'guru.nama as waliKelas',
                    'kelas.active as status',
                    'guru.gambar as image',
                    DB::raw('COUNT(murid.id) as totalMurid'),
                ]);
            $kelas->each(function ($item) {
                $item->image = $item->image ?  profilePath($item->image) : textAvatar($item->waliKelas ?? $item->name);
            });
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

    public function addMurid(Request $request)
    {
        try {
            $rules = [
                'id_kelas' => 'required|exists:kelas,id',
                'id_murid' => 'required|exists:murid,id',
            ];
            $messages = [
                'id_kelas.required' => 'Kelas masih kosong',
                'id_kelas.exists' => 'Kelas tidak ditemukan',
                'id_murid.required' => 'Murid masih kosong',
                'id_murid.exists' => 'Murid tidak ditemukan',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            $kelas = Kelas::find($request->id_kelas);
            if (!$kelas) return api_failed('Data kelas tidak ditemukan');
            Murid::find($request->id_murid)->update(['id_kelas' => $request->id_kelas]);
            return api_success('Berhasil tambah murid ke kelas');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function removeMurid(Request $request) {
        try {
            $rules = [
                'id_kelas' => 'required|exists:kelas,id',
                'id_murid' => 'required|exists:murid,id',
            ];
            $messages = [
                'id_kelas.required' => 'Kelas masih kosong',
                'id_kelas.exists' => 'Kelas tidak ditemukan',
                'id_murid.required' => 'Murid masih kosong',
                'id_murid.exists' => 'Murid tidak ditemukan',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            Murid::find($request->id_murid)->update(['id_kelas' => null]);
            return api_success('Berhasil hapus murid dari kelas');
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
