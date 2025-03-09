<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataSantriController extends Controller
{
    public function index()
    {
        return view('backend.pages.data-santri', 
        [
            'title' => 'Data Santri'
        ]);
        // $title = 'Data Santri';
        // return view('backend.pages.data-santri')
        //     ->with(compact('title'));


        // Kesimpulan :
        // ['title' => 'Data Santri'] or ->with(compact('title') sama saja
        // yg dikirim ke blade adalah $title
    }

    public function edit()
    {
        return view('backend.pages.data-santri.edit',
        [
            'title' => 'Edit Data Santri'
        ]);
    }
}
