<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Exception;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    public function list()
    {
        try {
            $absensi = Absensi::orderBy('id', 'DESC')->get();
            return api_success('Berhasil mengambil data absensi', $absensi);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function list_by_kelas(Request $request)
    {
        try {
            $id_kelas = $request->route('id');
            $absensi = Absensi::where('id_kelas', $id_kelas)->orderBy('id', 'DESC')->get();
            return api_success('Berhasil mengambil data absensi berdasarkan kelas', $absensi);
        } catch (Exception $e) {
            return api_error($e);
        }
    }
    
    public function list_by_murid(Request $request)
    {
        try {
            $id_murid = $request->route('id');
            $absensi = Absensi::where('id_murid', $id_murid)->orderBy('id', 'DESC')->get();
            return api_success('Berhasil mengambil data absensi berdasarkan murid', $absensi);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function list_by_jurnal(Request $request)
    {
        try {
            $id_jurnal = $request->route('id');
            $absensi = Absensi::where('id_jurnal', $id_jurnal)->orderBy('id', 'DESC')->get();
            return api_success('Berhasil mengambil data absensi berdasarkan jurnal', $absensi);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function get(Request $request)
    {
        try {
            $id = $request->route('id');
            $absensi = Absensi::find($id);
            if (!$absensi) return api_failed('Data absensi tidak ditemukan');
            return api_success('Berhasil mengambil data absensi', $absensi);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $rules = [
                'id_murid' => 'required|exists:murid,id',
                'id_jurnal' => 'required|exists:jurnal,id',
                'id_kelas' => 'required|exists:kelas,id',
                'keterangan' => 'required|in:H,S,I,A',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            ];

            $messages = [
                'id_murid.required' => 'Murid masih kosong',
                'id_murid.exists' => 'Murid tidak ditemukan',
                'id_jurnal.required' => 'Jurnal masih kosong',
                'id_jurnal.exists' => 'Jurnal tidak ditemukan',
                'id_kelas.required' => 'Kelas masih kosong',
                'id_kelas.exists' => 'Kelas tidak ditemukan',
                'keterangan.required' => 'Keterangan masih kosong',
                'keterangan.in' => 'Keterangan harus H, S, I, A',
                'foto.required' => 'Foto masih kosong',
                'foto.image' => 'Foto harus berupa gambar',
                'foto.mimes' => 'Foto harus berformat jpeg, png, jpg',
                'foto.max' => 'Foto maksimal 5MB',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            Absensi::create([
                'id_murid' => $request->id_murid,
                'id_jurnal' => $request->id_jurnal,
                'id_kelas' => $request->id_kelas,
                'keterangan' => $request->keterangan,
                'foto' => upload_file($request->file('foto'), 'absensi'),
            ]);
            return api_success('Berhasil tambah data absensi');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function update(Request $request)
    {
        try {
            $id = $request->route('id');
            $rules = [
                'keterangan' => 'required|in:H,S,I,A',
            ];
            $messages = [
                'keterangan.required' => 'Keterangan masih kosong',
                'keterangan.in' => 'Keterangan harus H, S, I, A',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            $absensi = Absensi::find($id);
            if (!$absensi) return api_failed('Data absensi tidak ditemukan');
            $update = [
                'keterangan' => $request->keterangan,
            ];
            $absensi->update($update);
            return api_success('Berhasil ubah data absensi');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function update_by_kelas(Request $request)
    {
        try {
            $id_kelas = $request->route('id');
            $rules = [
                'keterangan' => 'required|in:H,S,I,A',
            ];
            $messages = [
                'keterangan.required' => 'Keterangan masih kosong',
                'keterangan.in' => 'Keterangan harus H, S, I, A',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            $absensi = Absensi::where('id_kelas', $id_kelas);
            if ($absensi->count() == 0) return api_failed('Data absensi pada kelas ini tidak ditemukan');
            $update = [
                'keterangan' => $request->keterangan,
            ];
            $absensi->update($update);
            return api_success('Berhasil ubah data absensi.');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function inactive(Request $request)
    {
        try {
            $id = $request->route('id');
            $absensi = Absensi::find($request->id);
            if (!$absensi) return api_failed('Data absensi tidak ditemukan');
            $absensi->active = !$absensi->active;
            $absensi->save();
            return api_success('Berhasil mengubah status kelas');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->route('id');
            $absensi = Absensi::find($id);
            if (!$absensi) return api_failed('Data absensi tidak ditemukan');
            $absensi->delete();
            return api_success('Berhasil hapus data absensi');
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}
