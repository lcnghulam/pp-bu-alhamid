<form id="formPreviewDataSantri">
    <div class="row">
        <div class="mb-3">
            <label class="form-label" for="PVnis">NIS (Nomor Induk Santri)*</label>
            <input type="text" class="form-control" id="PVnis" value="" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label" for="PVnik">NIK*</label>
            <input type="text" class="form-control" id="PVnik" value="" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label" for="PVnama_lengkap">Nama Lengkap*</label>
            <input type="text" class="form-control" id="PVnamaLengkap" value="" disabled>
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="PVtempat_lahir">Tempat Lahir*</label>
            <input type="text" class="form-control" id="PVtempatLahir" value="" disabled>
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="PVtgl_lahir">Tgl Lahir*</label>
            <input type="text" class="form-control" id="PVtgl_lahir" value="" disabled>
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="PVgender">Jenis Kelamin*</label>
            <input type="text" class="form-control" id="PVgender" value="" disabled>
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="PVemail">Email</label>
            <input type="text" class="form-control" id="PVemail" value="" disabled>
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="PVno_hp">No. HP*</label>
            <input type="text" class="form-control" id="PVnoHP" value="" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label" for="PValamat">Alamat*</label>
            <textarea class="form-control" id="PValamat" rows="4" disabled></textarea>
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="PVtgl_masuk">Tgl Masuk*</label>
            <input type="text" class="form-control" id="PVtgl_masuk" value="" disabled>
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="PVtgl_keluar">Tgl Keluar</label>
            <input type="text" class="form-control" id="PVtgl_keluar" value="" disabled>
        </div>
        <div class="text-center py-3 mb-3">
            <img src="{{ Vite::asset('resources/backend/img/blank-profile.png') }}" alt="blank-profile" id="PVfoto" style="width: auto; max-width: 100%; height: auto; max-height: 250px; object-fit: contain; display: block; margin: auto;">
        </div>
    </div>
</form>