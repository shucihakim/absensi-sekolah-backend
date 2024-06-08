<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Absensi extends Model
{

    protected $table = 'absensi';
    protected $guarded = [];


    public static function statistik_hadir(int $hari_terakhir)
    {
        $last_time = getCurrentTime()->subDays($hari_terakhir-1);
        $data = self::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $last_time)
            ->where('keterangan', 'H') // Add this line to filter by keterangan = H
            ->groupBy('tanggal')
            ->orderBy('created_at')
            ->get();

        // Menyusun data ke dalam array asosiatif
        $dataByDate = [];
        foreach ($data as $item) {
            $dataByDate[$item->tanggal] = $item->total;
        }

        // Membuat array untuk hasil yang diinginkan
        $result = [];
        $currentDate = $last_time->copy();
        for ($i = 0; $i < $hari_terakhir; $i++) {
            $tanggal = $currentDate->format('Y-m-d');   
            $total = isset($dataByDate[$tanggal]) ? $dataByDate[$tanggal] : 0;
            $result[] = [explode('-', $tanggal)[2], $total];
            $currentDate->addDay();
        }

        // Mengembalikan hasil
        return $result;
    }

    public static function statistik_sakit(int $hari_terakhir)
    {
        $last_time = getCurrentTime()->subDays($hari_terakhir-1);
        $data = self::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $last_time)
            ->where('keterangan', 'S') // Add this line to filter by keterangan = H
            ->groupBy('tanggal')
            ->orderBy('created_at')
            ->get();

        // Menyusun data ke dalam array asosiatif
        $dataByDate = [];
        foreach ($data as $item) {
            $dataByDate[$item->tanggal] = $item->total;
        }

        // Membuat array untuk hasil yang diinginkan
        $result = [];
        $currentDate = $last_time->copy();
        for ($i = 0; $i < $hari_terakhir; $i++) {
            $tanggal = $currentDate->format('Y-m-d');   
            $total = isset($dataByDate[$tanggal]) ? $dataByDate[$tanggal] : 0;
            $result[] = [explode('-', $tanggal)[2], $total];
            $currentDate->addDay();
        }

        // Mengembalikan hasil
        return $result;
    }

    public static function statistik_izin(int $hari_terakhir)
    {
        $last_time = getCurrentTime()->subDays($hari_terakhir-1);
        $data = self::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $last_time)
            ->where('keterangan', 'I') // Add this line to filter by keterangan = H
            ->groupBy('tanggal')
            ->orderBy('created_at')
            ->get();

        // Menyusun data ke dalam array asosiatif
        $dataByDate = [];
        foreach ($data as $item) {
            $dataByDate[$item->tanggal] = $item->total;
        }

        // Membuat array untuk hasil yang diinginkan
        $result = [];
        $currentDate = $last_time->copy();
        for ($i = 0; $i < $hari_terakhir; $i++) {
            $tanggal = $currentDate->format('Y-m-d');   
            $total = isset($dataByDate[$tanggal]) ? $dataByDate[$tanggal] : 0;
            $result[] = [explode('-', $tanggal)[2], $total];
            $currentDate->addDay();
        }

        // Mengembalikan hasil
        return $result;
    }

    public static function statistik_alfa(int $hari_terakhir)
    {
        $last_time = getCurrentTime()->subDays($hari_terakhir-1);
        $data = self::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $last_time)
            ->where('keterangan', 'A') // Add this line to filter by keterangan = H
            ->groupBy('tanggal')
            ->orderBy('created_at')
            ->get();

        // Menyusun data ke dalam array asosiatif
        $dataByDate = [];
        foreach ($data as $item) {
            $dataByDate[$item->tanggal] = $item->total;
        }

        // Membuat array untuk hasil yang diinginkan
        $result = [];
        $currentDate = $last_time->copy();
        for ($i = 0; $i < $hari_terakhir; $i++) {
            $tanggal = $currentDate->format('Y-m-d');   
            $total = isset($dataByDate[$tanggal]) ? $dataByDate[$tanggal] : 0;
            $result[] = [explode('-', $tanggal)[2], $total];
            $currentDate->addDay();
        }

        // Mengembalikan hasil
        return $result;
    }

    
}
