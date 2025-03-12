<form id="formTambahSantri">
    <div class="row">
        <div class="mb-3">
            <label class="form-label" for="nis">NIS (Nomor Induk Santri)*</label>
            <input type="number" class="form-control" id="nis" name="nis" placeholder="25000000000001" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="nik">NIK*</label>
            <input type="number" class="form-control" id="nik" name="nik" placeholder="3505070000000001" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="nama_lengkap">Nama Lengkap*</label>
            <input type="text" class="form-control" id="namaLengkap" name="nama_lengkap" placeholder="Ahmad Sofyan" required>
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="tempat_lahir">Tempat Lahir*</label>
            <input type="text" class="form-control" id="tempatLahir" name="tempat_lahir" placeholder="Malang" required>
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="tgl_lahir">Tgl Lahir*</label>
            <input type="text" class="form-control flatpickr-human" id="tglLahir" name="tgl_lahir" placeholder="Pilih tanggal.." required />
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="gender">Jenis Kelamin*</label>
            <select id="gender" name="gender" class="form-control" required>
                <option selected>Pilih...</option>
                <option value="L">Laki-Laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="ahmadsofyan12@gmail.com">
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="no_hp">No. HP*</label>
            <input type="text" class="form-control" id="noHP" name="no_hp" placeholder="0812345678" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="alamat">Alamat*</label>
            <textarea class="form-control" id="alamat" name="alamat"  rows="4" placeholder="Jl. Sumber Agung, Ganjaran Selatan, Ganjaran, Kec. Gondanglegi, Kabupaten Malang, Jawa Timur 65174" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="foto">Foto</label>
            <input class="form-control" type="file" id="foto" name="foto" accept="image/*">
            <span class="text-muted fst-italic" style="font-size: 0.6rem; color: #ff5555 !important;">Perhatian: Ukuran file maksimal 200 KB</span>
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="tgl_masuk">Tgl Masuk*</label>
            <input type="text" class="form-control flatpickr-human" id="tglMasuk" name="tgl_masuk" placeholder="Pilih tanggal.." required />
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="tgl_keluar">Tgl Keluar</label>
            <div class="d-flex">
                <input type="text" class="form-control flatpickr-human" id="tglKeluar" name="tgl_keluar" placeholder="Pilih tanggal.."/>
                <button type="button" id="btnResetTGK" class="btn btn-danger ms-1"><i class="align-middle" data-feather="rotate-ccw"></i></button>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <div class="btn-kiri">
            <button type="submit" id="btnSimpan" class="btn btn-success">Simpan</button>
            <button type="button" id="btnBatal" class="btn btn-danger">Batal</button>
        </div>
        <button type="button" id="btnReset" class="btn btn-secondary">
            <i class="link-icon" data-feather="rotate-ccw"></i> Reset
        </button>
    </div>
</form>
<script>
    var blankProfileUrl = "{{ Vite::asset('resources/backend/img/blank-profile.png') }}";
</script>