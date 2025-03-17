<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JadwalController extends Controller
{
    public function index()
    {
        return view('backend.pages.jadwal', [ 'title' => 'Jadwal' ]);
        // $title = 'Data Santri';
        // return view('backend.pages.data-santri')
        //     ->with(compact('title'));


        // Kesimpulan :
        // ['title' => 'Data Santri'] or ->with(compact('title') sama saja
        // yg dikirim ke blade adalah $title
    }

}
