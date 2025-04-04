<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DataSantriController extends Controller
{
    public function index()
    {
        return view('backend.pages.data-santri', [ 'title' => 'Data Santri' ]);
    }

    public function getData(Request $request)
    {
        // $data = Santri::all();
        // dd($data);
        try {
            return Datatables::of(Santri::query())
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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    
        // dd(request()->all());
    }

    public function tambah(Request $request)
    {
        // - NIS Generator -
        $zone = 'Asia/Jakarta';
        $currentYear = Carbon::now($zone)->format('y'); // last 2 digits
        $prevYear = str_pad($currentYear - 1, 2, '0', STR_PAD_LEFT);
        $currentMonth = Carbon::now($zone)->format('m'); // last 2 digits

        // Thn Ajaran
        $tahunAjaran = ($currentMonth < 7) ? "{$prevYear}{$currentYear}" : "{$currentYear}" . str_pad($currentYear + 1, 2, '0', STR_PAD_LEFT);
        
        $lastReg = Santri::where('nis', 'LIKE', "{$tahunAjaran}{$currentMonth}%")
                ->latest('nis')
                ->first();

        if ($lastReg) {
        $lastNumb = intval(substr($lastReg->nis, -4)) + 1;
        } else {
        $lastNumb = 1; // RegNumb Restart
        }

        // Pastikan nomor urut tetap 4 digit (0001, 0002, dst.)
        $startReg = str_pad($lastNumb, 4, '0', STR_PAD_LEFT);
        
        $finalReg = $tahunAjaran.$currentMonth.$startReg;
        // dd($finalReg);
        

        return view('backend.pages.data-santri.tambah',[
            'title' => 'Tambah Data Santri',
            'newNis' => $finalReg
        ]);

        // return response()->json([
        //     'view' => view('backend.pages.data-santri.tambah', [
        //         'newNis' => $finalReg,
        //         'title' => 'Tambah Data Santri' // Tambahkan ini ke dalam view
        //     ])->render(),
        //     'title' => 'Tambah Data Santri'
        // ]);
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
            'no_hp'         => 'required|string|max:255',
            'alamat'        => 'required|string',
            'foto'          => 'nullable|image|mimes:jpg,png,jpeg,webp,svg|max:200',
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

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $santri = Santri::where('nis', $request->query('nis'))->value('nis');
            // dd($post);
            
            if (!$santri) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!'
                ], 404);
            }

            if (!Auth::user()->hasRole('superadmin')) {
                session(['edit_santri_allowed' => true]);
            }

            return response()->json([
                'success' => true
            ]);
        } 

        // dd(Auth::user()->hasRole('superadmin'));
        if (!Auth::user()->hasRole('superadmin')) {

            session()->forget('edit_santri_allowed');
            
            if (!session()->has('edit_santri_allowed')) {
                abort(403);
            }
        }

        $santri = Santri::where('nis', $request->query('nis'))->first();

        if (!$santri) {
            abort(404);
        }

        return view('backend.pages.data-santri.edit', [
            'title' => 'Edit Data Santri',
            'santri' => $santri
        ]);
    }

    public function update(Request $request)
    {
        try {
            // Ambil data santri berdasarkan ID
            $nis = $request->query('nis'); // Ambil nis dari URL parameter
            // dd($nis);
            $santri = Santri::findOrFail($nis);
            // dd($santri);

            // Validasi input dari formData
            $validated = $request->validate([
                'nis'           => 'required|numeric|unique:santri,nis,' . $nis . ',nis',
                'nik'           => 'required|numeric|unique:santri,nik,' . $nis . ',nis',
                'nama_lengkap'  => 'required|string|max:255',
                'tempat_lahir'  => 'required|string|max:100',
                'tgl_lahir'     => 'required|date',
                'gender'        => 'required|in:L,P',
                'email'         => 'nullable|email|unique:santri,email,' . $nis . ',nis',
                'no_hp'         => 'required|string|max:255',
                'alamat'        => 'required|string',
                'foto'          => 'nullable|image|mimes:jpg,png,jpeg|max:200',
                'tgl_masuk'     => 'required|date',
                'tgl_keluar'    => 'nullable|date|after_or_equal:tgl_masuk',
            ]);

            // Simpan hanya data yang berubah
            $changes = [];
            foreach ($validated as $key => $value) {
                if (!is_null($value) && $santri->$key != $value) {
                    $changes[$key] = $value;
                }
            }

            // Jika ada file foto baru diunggah
            if ($request->hasFile('foto')) {
                $filename = "{$santri->nis}." . $request->file('foto')->getClientOriginalExtension();
                $request->file('foto')->storeAs('data-santri', $filename, 'public');
                $changes['foto'] = $filename;
            }

            // Update hanya jika ada perubahan
            if (!empty($changes)) {
                $santri->update($changes);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui!',
                'updated_fields' => array_keys($changes), // Menampilkan field yang berubah
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
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
        $nis = $santri->nis;
        $nama = $santri->nama_lengkap;

        $santri->delete();

        return response()->json(['message' => 'Data santri dengan <br>Nama : <strong>' . $nama . '</strong><br>NIS : <strong>' . $nis . '</strong>']);
    }

}
