<?php

namespace App\Http\Controllers;

use App\Models\Tentang;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function about()
    {
        try {
            $about = Tentang::first();
            return api_success('Berhasil mengambil data tentang sekolah', $about);
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}
