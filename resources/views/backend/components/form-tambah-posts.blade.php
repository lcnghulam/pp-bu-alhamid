<form id="formTambahPost">
    <div class="row">
        <div class="col-12 col-xl-6">
            <div class="mb-3">
                <label class="form-label fw-bold" for="post_img">Foto</label>
                <div class="text-center py-3 mb-3">
                    <img src="{{ Vite::asset('resources/backend/img/blank-img.jpg') }}" alt="blank-profile" id="PVfoto" style="width: auto; max-width: 100%; height: auto; max-height: 250px; object-fit: contain; display: block; margin: auto;">
                </div>
                <input class="form-control" type="file" id="postImg" name="post_img" accept="image/*" required>
                <span class="text-muted fst-italic ms-1" style="font-size: 0.6rem; color: #ff5555 !important;">Perhatian: Ukuran file maksimal 1 MB</span>
            </div>
        </div>
        <div class="col-12 col-xl-6">  
            <div class="mb-3">
                <label class="form-label fw-bold" for="post_judul">Judul</label>
                <input type="text" class="form-control" id="postJudul" name="post_judul" placeholder="Khutbah Jumat: Nuzulul Qur’an dan Perintah Membaca..." required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="post_category">Kategori</label>
                <select id="postCategory" name="post_category" class="form-control" required>
                    <option selected>Pilih...</option>
                    <option value="Artikel">Artikel</option>
                    <option value="Berita">Berita</option>
                </select>
            </div>
            <div class="mb-3">
                <label id="labelSubCategory" class="form-label fw-bold" for="sub_category">Sub Kategori</label>
                @if (!$subCategory)
                <div id="subCat1">
                    <input type="text" id="subCategory1" class="form-control bd-highlight me-2" name="sub_category" placeholder="Nasional / Syariah / Fragmen / Khutbah / ...." required>
                    <input type="hidden" name="subcat_type" value="new">
                </div>
                @else
                <div id="subCat2">
                    <select id="subCategory2" name="sub_category" class="form-control bd-highlight me-2" required>
                        <option selected>Pilih...</option>
                        @foreach ($subCategory as $sc)
                            <option value="{{ $sc->id }}">{{ $sc->sub_category }}</option>
                        @endforeach
                    </select>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="checkboxCat2">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Tambah Kategori Baru</label>
                    </div>
                    <input type="hidden" name="subcat_type" value="exist">
                </div>
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="tag">Tag</label>
                <input type="text" class="form-control" id="tag" name="tag">
            </div>  
        </div>
    </div>
    <div class="row">
        <div class="mb-3">
            <label class="form-label fw-bold" for="post_isi">Isi Post</label>
            <input type="hidden" id="postIsi" name="post_isi" required>
            <div class="clearfix">
                <div id="quill-toolbar">
                    <span class="ql-formats">
                        <select class="ql-font"></select>
                        <select class="ql-size"></select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-strike"></button>
                    </span>
                    <span class="ql-formats">
                        <select class="ql-color"></select>
                        <select class="ql-background"></select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-script" value="sub"></button>
                        <button class="ql-script" value="super"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-header" value="1"></button>
                        <button class="ql-header" value="2"></button>
                        <button class="ql-blockquote"></button>
                        <button class="ql-code-block"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                        <button class="ql-indent" value="-1"></button>
                        <button class="ql-indent" value="+1"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-direction" value="rtl"></button>
                        <select class="ql-align"></select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-link"></button>
                        <button class="ql-image"></button>
                        <button class="ql-video"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-clean"></button>
                    </span>
                </div>
                <div id="quill-editor"></div>
            </div>
        </div>
    </div>
    <div class="d-flex bd-highlight">
        <button type="submit" id="btnDraft" class="btn btn-warning me-auto bd-highlight">
            <i class="fa-regular fa-floppy-disk"></i> Save As Draft
        </button>
        <button type="submit" id="btnPublish" class="btn btn-primary mx-2">
            <i data-feather="upload-cloud"></i> Publish
        </button>
        <button type="button" id="btnBatal" class="btn btn-danger me-2">
            <i data-feather="x-circle"></i> Batal
        </button>
        <button type="button" id="btnReset" class="btn btn-secondary">
            <i class="link-icon" data-feather="rotate-ccw"></i> Reset
        </button>
    </div>
</form>
<script>
    var blankImg = "{{ Vite::asset('resources/backend/img/blank-img.jpg') }}";
</script>