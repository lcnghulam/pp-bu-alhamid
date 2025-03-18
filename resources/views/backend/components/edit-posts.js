$(document).ready(function(){
    // Upload & Preview Foto dengan Validasi Ukuran Maksimal 200KB
    const blankImg = document.getElementById("PVfoto").src;
    let fotoInput = document.getElementById("postImg");
    let previewFoto = document.getElementById("PVfoto");

    fotoInput.addEventListener("change", function (event) {
        let file = event.target.files[0];
        let maxSize = 1000 * 1024; // 200KB dalam bytes

        if (file) {
            if (file.size > maxSize) {
                // alert("Ukuran file terlalu besar! Maksimal 200KB.");
                Swal.fire({
                    icon: "error",
                    title: "Gagal...",
                    text: "Ukuran gambar maksimal 200KB!",
                });
                fotoInput.value = ""; // Reset input file
                previewFoto.src = blankImg; // Kembali ke gambar default
                return;
            }

            let reader = new FileReader();
            reader.onload = function (e) {
                previewFoto.src = e.target.result; // Set preview ke gambar yang diunggah
            };
            reader.readAsDataURL(file);
        } else {
            previewFoto.src = blankImg; // Kembali ke default jika tidak ada file
        }
    });
    
    // Choices.js
    const tag = new Choices("#tag", {
        placeholder: true,
        removeItemButton: true, 
        duplicateItemsAllowed: false,
        placeholderValue: 'Sejarah NU / Metafora / Kultur / ....',
        uniqueItemText: '<b>Tag sudah ada!</b>',
        addItemText: (value) => {
            return 'Tekan <b>"Enter"</b> untuk menambahkan <b>"' + value + '"</b> atau lainnya...';
        },
    });
    
    $("[placeholder]").css("font-style", "italic");
    $("[type=search]").css("color", "#bdc0c5");

    let editor = new Quill("#quill-editor", {
        modules: {
            toolbar: "#quill-toolbar"
        },
        placeholder: "Tulis Artikel / Berita disini...",
        theme: "snow"
    });

    // Perubahan langsung saat user mengetik / memilih input
    $("input[required], select[required]").on("input change", function () {
        if ($(this).val().trim() !== "" && $(this).val() !== "Pilih...") {
            $(this).removeClass("is-invalid").addClass("is-valid");
            this.setCustomValidity("");
        } else {
            $(this).addClass("is-invalid").removeClass("is-valid");
        }
    });

    let labelSubCat = document.getElementById('labelSubCategory');
    let subcat1 = `<div id="subCat1">
                    <input type="text" id="subCategory1" class="form-control bd-highlight me-2" name="sub_category" placeholder="Nasional / Syariah / Fragmen / Khutbah / ...." required>
                    <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" id="checkboxCat1" checked>
                    <label class="form-check-label" for="flexSwitchCheckDefault">Tambah Kategori Baru</label>
                    </div>
                    <input type="hidden" name="subcat_type" value="new">
                    </div>`;
    let subcat2;

    // console.log(checkboxCat);
    $(document).on('change', '#checkboxCat2', function(){
        subcat2 = $('#subCat2').prop('outerHTML');
        $('#subCat2').remove();
        labelSubCat.insertAdjacentHTML('afterend', subcat1); 
    })

    $(document).on('change', '#checkboxCat1', function(){
        $('#subCat1').remove();
        labelSubCat.insertAdjacentHTML('afterend', subcat2); 
    })

    // Submit & Validation
    $('#formEditPost').on('submit', function(event){
        event.preventDefault();
        let urlParams = new URLSearchParams(window.location.search).get('post');
        let isiPostField = document.querySelector("input[name='post_isi']");
        isiPostField.value = editor.root.innerHTML;

        let isValid = true;
    
        $(this).find("input[required], select[required]").each(function () {
            if ($(this).val().trim() === "" || $(this).val() === "Pilih...") {
                $(this).addClass("is-invalid").removeClass("is-valid");
                isValid = false;
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
                this.setCustomValidity("");
            }
        });
    
        if (!isValid) {
            e.preventDefault(); // Hentikan submit kalau ada error
            $(this).find(".is-invalid").first().focus();
        } 
        
        // console.log(isiPostField.value);
        if(
            !isiPostField.value.trim() ||
            isiPostField.value === "<p><br></p>" ||
            isiPostField.value === "<p></p>" ||
            isiPostField.value === "<br>" ) {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text:"Isi Field Post!"
            });
        } else {
            let formData = new FormData($('#formEditPost')[0]);
            formData.append('_method', 'PATCH');
            formData.append("post_status", statusValue);
    
            Swal.fire({
                icon: "info",
                title: "Sudah dicek dengan betul datanya?",
                showDenyButton: true,
                confirmButtonText: "Ya, Sudah!",
                denyButtonText: `Batal`
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "/posts/update?post=" + urlParams,
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Sukses!",
                                    text: response.message
                                }).then(() => {
                                    window.location.href = "/posts";
                                });
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "Terjadi kesalahan pada server.";
                            Swal.fire("Gagal!", errorMessage, "error");
                        }
                    });                
                } else if (result.isDenied) {
                  Swal.fire("Perubahan tidak disimpan!", "", "info");
                }
            });
        }

    })

    let statusValue;
    document.getElementById("btnDraft").addEventListener("click", function (e) {
        statusValue = 0; // Set status ke Draft
    });

    document.getElementById("btnPublish").addEventListener("click", function (e) {
        statusValue = 1; // Set status ke Publish
    });

    function resetForm(){
        const queryString = window.location.search;
        const thisUrlParams = new URLSearchParams(queryString).get('post');
        // console.log(thisURL);

        $.ajax({
            url: '/posts/edit',
            type: 'get',
            data: {slug: thisUrlParams},
            success: function (response) {
                if (response.success) {
                    window.location.href = "/posts/edit?post=" + thisUrlParams;
                    let timerInterval;
                    Swal.fire({
                    title: "Sending Request...",
                    html: "Please Wait....",
                    timer: 5000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                    })
                }
            },
            error: function (response) {
                let errorMessage = response.responseJSON?.message || "Terjadi kesalahan!";
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: errorMessage,
                });
            }
        })
    }

    $("#btnBatal").on("click", function () {
        window.location.href = "/posts";
    });

    $('#btnReset').on('click', function(){
        resetForm();
    })
})