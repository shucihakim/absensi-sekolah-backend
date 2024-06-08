<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Murid;
use App\Models\Ortu;
use Exception;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function list()
    {
        try {
            $admin = Admin::orderBy('id', 'DESC')->get();
            $admin->each(function ($item) {
                $item->role = 'admin';
                $item->identity = $item->nip;
                $item->imageUrl = $item->gambar ?  profilePath($item->gambar) : textAvatar($item->nama);
            });
            $guru = Guru::orderBy('id', 'DESC')->get();
            $guru->each(function ($item) {
                $item->role = 'guru';
                $item->identity = $item->nip;
                $item->imageUrl = $item->gambar ?  profilePath($item->gambar) : textAvatar($item->nama);
            });
            $murid = Murid::orderBy('id', 'DESC')->get();
            $murid->each(function ($item) {
                $item->role = 'murid';
                $item->identity = $item->nis;
                $item->imageUrl = $item->gambar ?  profilePath($item->gambar) : textAvatar($item->nama);
            });
            $ortu = Ortu::orderBy('id', 'DESC')->get();
            $ortu->each(function ($item) {
                $item->role = 'ortu';
                $item->identity = $item->no_hp;
                $item->imageUrl = $item->gambar ?  profilePath($item->gambar) : textAvatar($item->nama);
            });
            $data = array_merge($admin->toArray(), $guru->toArray(), $murid->toArray(), $ortu->toArray());
            usort($data, function ($a, $b) {
                return strtotime($a['created_at']) - strtotime($b['created_at']);
            });
            return api_success('Berhasil mengambil data pengguna', $data);
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}
