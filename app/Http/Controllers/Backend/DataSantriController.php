<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataSantriController extends Controller
{
    public function index()
    {
        return view('backend.pages.data-santri', [ 'title' => 'Data Santri' ]);
        // $title = 'Data Santri';
        // return view('backend.pages.data-santri')
        //     ->with(compact('title'));


        // Kesimpulan :
        // ['title' => 'Data Santri'] or ->with(compact('title') sama saja
        // yg dikirim ke blade adalah $title
    }

    public function getData(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => 'Invalid Request'], 400);
        }
    
        return Datatables::of(Santri::query())
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where('nama_lengkap', 'LIKE', "%{$search}%")
                        ->orWhere('nis', 'LIKE', "%{$search}%")
                        ->orWhere('nik', 'LIKE', "%{$search}%")
                        ->orWhere('tempat_lahir', 'LIKE', "%{$search}%")
                        ->orWhere('tgl_lahir', 'LIKE', "%{$search}%")
                        ->orWhere('alamat', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('no_hp', 'LIKE', "%{$search}%")
                        ->orWhere('tgl_masuk', 'LIKE', "%{$search}%")
                        ->orWhere('tgl_keluar', 'LIKE', "%{$search}%");
                }
            })
            ->addColumn('foto', function ($row) {
                if (!empty($row->foto)) {
                    $fotoUrl = asset('storage/data-santri/' . htmlspecialchars($row->foto));
                    return '<img src="' . $fotoUrl . '" width="50" class="rounded">';
                }
                return '<span class="badge bg-secondary">No Image</span>';
            })                      
            ->addColumn('nama_santri', function ($row) {
                return $row->nama_lengkap;
            })
            ->addColumn('data_santri', function ($row) {
                $gender = $row->gender == 'L' ? 'Laki-Laki' : 'Perempuan';

                return "<strong>NIS:</strong> {$row->nis} <br>
                        <strong>NIK:</strong> {$row->nik} <br>
                        <strong>Nama:</strong> {$row->nama_lengkap} <br>
                        <strong>TTL:</strong> {$row->tempat_lahir}, " . date('d-m-Y', strtotime($row->tgl_lahir)) . " <br>
                        <strong>Gender:</strong> " . $gender . " <br>
                        <strong>Alamat:</strong> {$row->alamat} <br>
                        <strong>Email:</strong> {$row->email} <br>
                        <strong>No HP:</strong> {$row->no_hp}";
            })
            ->addColumn('status', function ($row) {
                $tgl_masuk = $row->tgl_masuk ? date('d-m-Y', strtotime($row->tgl_masuk)) : '-';
                $tgl_keluar = $row->tgl_keluar ? date('d-m-Y', strtotime($row->tgl_keluar)) : '-';
            
                $status = "<span class='badge bg-success'>Aktif</span>"; // Default status aktif
            
                // Jika tgl_keluar ada dan lebih kecil dari hari ini, set status non-aktif
                if ($row->tgl_keluar && Carbon::parse($row->tgl_keluar)->lt(Carbon::today())) {
                    $status = "<span class='badge bg-danger'>Non-Aktif</span>";
                }
            
                return "<strong>Tgl Masuk:</strong> " . $tgl_masuk . " <br>
                        <strong>Tgl Keluar:</strong> " . $tgl_keluar . "<br>
                        <strong>Status: </strong>" . $status;
            })
            ->addColumn('aksi', function ($row) {
                return '<button data-id="' . $row->nis . '" id="btnEdit"><i class="align-middle" data-feather="edit-2"></i></button>
                        <button data-id="' . $row->nis . '" id="btnDestroy"><i class="align-middle" data-feather="trash"></i></button>';
            })
            ->rawColumns(['foto', 'nama_santri', 'data_santri', 'status', 'aksi']) // Agar HTML bisa dirender dengan benar
            ->make(true);
        // dd(request()->all());
    }

    public function tambah(Request $request)
    {
        return view('backend.pages.data-santri.tambah',['title' => 'Tambah Data Santri']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis'           => 'required|numeric|unique:santri,nis',
            'nik'           => 'required|numeric|unique:santri,nik',
            'nama_lengkap'  => 'required|string|max:255',
            'tempat_lahir'  => 'required|string|max:100',
            'tgl_lahir'     => 'required|date',
            'gender'        => 'required|in:L,P',
            'email'         => 'nullable|email|unique:santri,email',
            'no_hp'         => 'required|numeric',
            'alamat'        => 'required|string',
            'foto'          => 'nullable|image|mimes:jpg,png,jpeg|max:200',
            'tgl_masuk'     => 'required|date',
            'tgl_keluar'    => 'nullable|date|after_or_equal:tgl_masuk',
        ]);

        if ($request->hasFile('foto')) {
            $nis = $validated['nis']; // Ambil NIS yang sudah divalidasi
            $extension = $request->file('foto')->getClientOriginalExtension(); // Dapatkan ekstensi file
            $filename = "{$nis}.{$extension}"; // Format nama file
    
            // Simpan ke storage dengan nama file sesuai NIS
            $request->file('foto')->storeAs('data-santri', $filename, 'public');
            $validated['foto'] = $filename; // Simpan path ke database
        }

        // Simpan data ke database
        Santri::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan!'
        ]);
    }

    public function edit()
    {
        return view('backend.pages.data-santri.edit',
        [
            'title' => 'Edit Data Santri'
        ]);
    }

    public function destroy(Request $request)
    {
        $santri = Santri::find($request->nis);

        if (!$santri) {
            return response()->json(['message' => 'Data tidak ditemukan!'], 404);
        }

        // Hapus foto jika ada
        if (!empty($santri->foto)) {
            $fotoPath = "data-santri/{$santri->foto}"; // Path tanpa "public/"
            
            if (Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
        }

        $santri->delete();

        return response()->json(['message' => 'Data berhasil dihapus!']);
    }

}
