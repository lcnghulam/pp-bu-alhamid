<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data Santri
        $santriLaki = Santri::where('gender', 'L')->count();
        $santriPerempuan = Santri::where('gender', 'P')->count();

        return view('backend.dashboard', [
            'santriLaki' => $santriLaki,
            'santriPerempuan' => $santriPerempuan
        ]);
        // return view(
        //     'backend.dashboard',
        //     ['title' => 'Dashboard']
        // );
    }

    public function getDataSantri () 
    {
        $santriLaki = Santri::where('gender', 'L')->count();
        $santriPerempuan = Santri::where('gender', 'P')->count();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan!',
            'santri_count' => [
                'L' => $santriLaki,
                'P' => $santriPerempuan,
            ],
        ]);
    }
}
