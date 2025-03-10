<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Yajra\DataTables\DataTables;
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

    public function getData(Request $request)
    {
        // dd(Santri::query());
        // dd(Santri::query()->get());
        // dd(Datatables::of(Santri::query()->make(true));

        if (!$request->ajax()) {
            return response()->json(['error' => 'Invalid Request'], 400);
        }
    
        return Datatables::of(Santri::query())
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where('nama_lengkap', 'LIKE', "%{$search}%")
                        ->orWhere('nis', 'LIKE', "%{$search}%")
                        ->orWhere('tempat_lahir', 'LIKE', "%{$search}%")
                        ->orWhere('tgl_lahir', 'LIKE', "%{$search}%")
                        ->orWhere('alamat', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('no_hp', 'LIKE', "%{$search}%");
                }
            })
            ->addColumn('foto', function ($row) {
                if (!empty($row->foto)) {
                    // return '<img src="' . asset('storage/foto/' . htmlspecialchars($row->foto)) . '" width="50" class="rounded">';
                    return '<span class="badge bg-secondary">No Image</span>';
                }
                return '<span class="badge bg-secondary">No Image</span>';
            })
            ->addColumn('nama_santri', function ($row) {
                return $row->nama_lengkap;
            })
            ->addColumn('data_santri', function ($row) {
                return "<strong>NIS:</strong> {$row->nis} <br>
                        <strong>Nama:</strong> {$row->nama_lengkap} <br>
                        <strong>TTL:</strong> {$row->tempat_lahir}, " . date('d-m-Y', strtotime($row->tanggal_lahir)) . " <br>
                        <strong>Gender:</strong> {$row->gender} <br>
                        <strong>Alamat:</strong> {$row->alamat} <br>
                        <strong>Email:</strong> {$row->email} <br>
                        <strong>No HP:</strong> {$row->no_hp}";
            })
            ->addColumn('aksi', function ($row) {
                return '<button data-id="' . $row->nis . '"><i class="align-middle" data-feather="edit-2"></i></button>
                        <button data-id="' . $row->nis . '"><i class="align-middle" data-feather="trash"></i></button>';
            })
            ->rawColumns(['foto', 'nama_santri', 'data_santri', 'aksi']) // Agar HTML bisa dirender dengan benar
            ->make(true);
        // dd(request()->all());
    }

    public function edit()
    {
        return view('backend.pages.data-santri.edit',
        [
            'title' => 'Edit Data Santri'
        ]);
    }
}
