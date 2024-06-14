<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Murid;
use App\Models\Tentang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard_web()
    {
        $version = json_decode(file_get_contents(public_path('app/version.json')), true);
        return view('dashboard', $version);
    }

    public function index()
    {
        try {
            $hari_statistik = 7;
            $data = [
                'total_murid' => Murid::count(),
                'total_guru' => Guru::count(),
                'statistik_hadir' => Absensi::statistik_hadir($hari_statistik),
                'statistik_sakit' => Absensi::statistik_sakit($hari_statistik),
                'statistik_izin' => Absensi::statistik_izin($hari_statistik),
                'statistik_alfa' => Absensi::statistik_alfa($hari_statistik),
            ];
            return api_success('Berhasil mengambil data dashboard', $data);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function murid(Request $request)
    {
        $token_data = (object) $request->tokenData;
        $id_murid = $token_data->id;
        $jurnal = Jurnal::leftJoin('kelas', 'kelas.id', '=', 'jurnal.id_kelas')
            ->leftJoin('murid', 'murid.id_kelas', '=', 'kelas.id')
            ->leftJoin('mapel', 'mapel.id', '=', 'jurnal.id_mapel')
            ->where('murid.id', $id_murid)
            ->whereTime('jurnal.jam_masuk', '<=', getCurrentTime()->format('H:i:s'))
            ->whereTime('jurnal.jam_keluar', '>=', getCurrentTime()->format('H:i:s'))
            ->whereDate('jurnal.created_at', getCurrentTime()->format('Y-m-d'))
            ->first([
                'jurnal.id',
                'mapel.nama as mapel',
                'jurnal.materi',
            ]);
        $kelas = Kelas::where('id', $token_data->id_kelas)->first();
        $nama_kelas = $kelas ? $kelas->nama : 'Belum ada kelas';
        $absensi = Absensi::where('id_murid', $id_murid)->whereDate('created_at', now())
            ->where('id_jurnal', $jurnal ? $jurnal->id : null)
            ->first([
                'id',
                'keterangan',
                'foto',
                'alamat',
                DB::raw("DATE_FORMAT(waktu, '%H:%i:%s') as jam")
            ]);
        if ($absensi) {
            $absensi->foto =  $absensi->foto ? absensiPath($absensi->foto) : null;
        }
        $data = [
            'kelas' => [
                'id' => $kelas ? $kelas->id : 0,
                'nama' => $nama_kelas
            ],
            'jurnal' => $jurnal ? $jurnal : [
                'id' => 0,
                'mapel' => 'Belum ada jurnal hari ini',
                'materi' => '-'
            ],
            'absensi' => $absensi,
        ];
        return api_success('Berhasil mengambil data absen murid', $data);
    }

    public function about()
    {
        try {
            $about = Tentang::orderBy('no', 'ASC')->get();
            $about->each(function ($item) {
                $item->lampiran = $item->lampiran ? aboutPath($item->lampiran) : null;
            });
            return api_success('Berhasil mengambil data tentang sekolah', $about);
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}
