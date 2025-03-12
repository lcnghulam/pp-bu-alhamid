{{-- {{ dd($dataEdit) }} --}}
<form id="formEditSantri">
    <div class="row">
        <div class="mb-3">
            <label class="form-label" for="nis">NIS (Nomor Induk Santri)*</label>
            <input type="number" class="form-control" id="nis" name="nis" placeholder="25000000000001" value="{{ old('nis', $dataEdit->nis) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="nik">NIK*</label>
            <input type="number" class="form-control" id="nik" name="nik" placeholder="3505070000000001" value="{{ old('nik', $dataEdit->nik) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="nama_lengkap">Nama Lengkap*</label>
            <input type="text" class="form-control" id="namaLengkap" name="nama_lengkap" placeholder="Ahmad Sofyan" value="{{ old('nama_lengkap', $dataEdit->nama_lengkap) }}" required>
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="tempat_lahir">Tempat Lahir*</label>
            <input type="text" class="form-control" id="tempatLahir" name="tempat_lahir" placeholder="Malang" value="{{ old('tempat_lahir', $dataEdit->tempat_lahir) }}" required>
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="tgl_lahir">Tgl Lahir*</label>
            <input type="text" class="form-control flatpickr-human" id="tglLahir" name="tgl_lahir" placeholder="Pilih tanggal.." value="{{ old('tgl_lahir', $dataEdit->tgl_lahir) }}" required />
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="gender">Jenis Kelamin*</label>
            <select id="gender" name="gender" class="form-control" required>
                <option>Pilih...</option>
                <option value="L" {{ old('gender', $dataEdit->gender) == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                <option value="P" {{ old('gender', $dataEdit->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="ahmadsofyan12@gmail.com" value="{{ old('email', $dataEdit->email) }}">
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="no_hp">No. HP*</label>
            <input type="text" class="form-control" id="noHP" name="no_hp" placeholder="0812345678" value="{{ old('no_hp', $dataEdit->no_hp) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="alamat">Alamat*</label>
            <textarea class="form-control" id="alamat" name="alamat"  rows="4" placeholder="Jl. Sumber Agung, Ganjaran Selatan, Ganjaran, Kec. Gondanglegi, Kabupaten Malang, Jawa Timur 65174" required>{{ old('alamat', $dataEdit->alamat) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="foto">Foto</label>
            <input class="form-control" type="file" id="foto" name="foto" accept="image/*" value="{{ old('foto', $dataEdit->foto) }}">
            <span class="text-muted fst-italic" style="font-size: 0.6rem; color: #ff5555 !important;">Perhatian: Ukuran file maksimal 200 KB</span>
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="tgl_masuk">Tgl Masuk*</label>
            <input type="text" class="form-control flatpickr-human" id="tglMasuk" name="tgl_masuk" placeholder="Pilih tanggal.." value="{{ old('tgl_masuk', $dataEdit->tgl_masuk) }}" required />
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="tgl_keluar">Tgl Keluar</label>
            <div class="d-flex">
                <input type="text" class="form-control flatpickr-human" id="tglKeluar" name="tgl_keluar" placeholder="Pilih tanggal.." value="{{ old('tgl_keluar', $dataEdit->tgl_keluar) }}" />
                <button type="button" id="btnResetTGK" class="btn btn-danger ms-1"><i class="align-middle" data-feather="rotate-ccw"></i></button>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <div class="btn-kiri">
            <button type="submit" id="btnSimpan" class="btn btn-success">Simpan</button>
            <button type="button" id="btnBatal" class="btn btn-danger">Batal</button>
        </div>
        <button type="button" id="btnReset" class="btn btn-secondary" onclick="location.reload()">
            <i class="link-icon" data-feather="rotate-ccw"></i> Reload Data
        </button>
    </div>
</form>
<script>
    var blankProfileUrl = "{{ Vite::asset('resources/backend/img/blank-profile.png') }}";
</script>