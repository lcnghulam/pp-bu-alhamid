$(document).ready(function(){
    $("label.form-label").html(function(_, html) {
        return html.replace("*", "<span style='color:red;'>*</span>");
    });
    $("[placeholder]").css("font-style", "italic");

    const style = document.createElement('style');
    style.innerHTML = `
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
    `;
    document.head.appendChild(style);

    //Flatpickr
    flatpickr("#tglLahir", {
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
        onOpen: function (selectedDates, dateStr, instance) {
            instance.currentYear = 2000; // Set tampilan awal ke tahun 2000
            instance.redraw();
        },
        onChange: function (selectedDates, dateStr, instance) {
            let inputAlt = $(instance.altInput); // Input alternatif (yang terlihat)
    
            // Update preview dengan format yang sama
            $("#PVtgl_lahir").val(inputAlt.val());
        }
    });

    flatpickr("#tglMasuk", {
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
        onChange: function (selectedDates, dateStr, instance) {
            let inputAlt = $(instance.altInput); // Input alternatif (yang terlihat)
    
            // Update preview dengan format yang sama
            $("#PVtgl_masuk").val(inputAlt.val());
        }
    });

    flatpickr("#tglKeluar", {
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
        onChange: function (selectedDates, dateStr, instance) {
            let inputAlt = $(instance.altInput); // Input alternatif (yang terlihat)
    
            // Update preview dengan format yang sama
            $("#PVtgl_keluar").val(inputAlt.val());
        }
    });

    //Validation
    $("#formTambahSantri").on("submit", function (e) {
        let isValid = true;

        $(this).find("input[required], select[required], textarea[required]").each(function () {
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
    });

    // Perubahan langsung saat user mengetik / memilih input
    $("input[required], select[required], textarea[required]").on("input change", function () {
        if ($(this).val().trim() !== "" && $(this).val() !== "Pilih...") {
            $(this).removeClass("is-invalid").addClass("is-valid");
            this.setCustomValidity("");
        } else {
            $(this).addClass("is-invalid").removeClass("is-valid");
        }
    });

    $("#nis, #nik").on("keydown input", function (e) {
        // Cegah Arrow Up & Down
        if (e.key === "ArrowUp" || e.key === "ArrowDown") {
            e.preventDefault();
        }
        // Hapus karakter selain angka
        this.value = this.value.replace(/[^0-9]/g, "");
    });
    
    // Mencegah scroll mengubah nilai input number
    $("#nis, #nik").on("wheel", function (e) {
        e.preventDefault();
    });
    
    // Set ulang nilai NIS & NIK agar bersih saat halaman di-load
    $("#nis, #nik").each(function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });    

    // Saat user mengetik di form Tambah Santri, otomatis isi form Preview Santri
    $("#formTambahSantri input, #formTambahSantri textarea, #formTambahSantri select").on("input change", function () {
        let inputId = $(this).attr("id"); // Ambil ID input yang diketik
        let previewId = "#PV" + inputId; // Ubah ke ID form preview (tambah prefix 'PV')   

        // Jika field preview ada, sinkronkan isinya
        if ($(previewId).length) {
            $(previewId).val($(this).val());
        }

        $("#gender").on("change", function () {
            let selectedText = $("#gender option:selected").text(); // Ambil teks tampilan
            $("#PVgender").val(selectedText); // Update preview dengan teks
        });
    });

    // Upload & Preview Foto dengan Validasi Ukuran Maksimal 200KB
    let fotoInput = document.getElementById("foto");
    let previewFoto = document.getElementById("PVfoto");

    fotoInput.addEventListener("change", function (event) {
        let file = event.target.files[0];
        let maxSize = 200 * 1024; // 200KB dalam bytes

        if (file) {
            if (file.size > maxSize) {
                // alert("Ukuran file terlalu besar! Maksimal 200KB.");
                Swal.fire({
                    icon: "error",
                    title: "Gagal...",
                    text: "Ukuran gambar maksimal 200KB!",
                });
                fotoInput.value = ""; // Reset input file
                previewFoto.src = window.blankProfileUrl; // Kembali ke gambar default
                return;
            }

            let reader = new FileReader();
            reader.onload = function (e) {
                previewFoto.src = e.target.result; // Set preview ke gambar yang diunggah
            };
            reader.readAsDataURL(file);
        } else {
            previewFoto.src = window.blankProfileUrl; // Kembali ke default jika tidak ada file
        }
    });

    function resetForm(){
        $('#formTambahSantri')[0].reset();
        $('#formPreviewDataSantri')[0].reset();

        // Hapus semua kelas validasi
        $('#formTambahSantri').find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');

        // Reset gambar preview ke default
        $('#PVfoto').attr('src', blankProfileUrl);
    }

    $('#formTambahSantri').on('submit', function(event){
        event.preventDefault();

        let formData = new FormData($('#formTambahSantri')[0]);

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
                    url: "/data-santri/store",
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
                                resetForm();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: xhr.responseJSON.message || "Terjadi kesalahan."
                        });
                    }
                });                
            } else if (result.isDenied) {
              Swal.fire("Changes are not saved", "", "info");
            }
        });
    })


    $("#btnBatal").on("click", function () {
        window.location.href = "/data-santri";
    });

    

    $('#btnReset').click(function () {
        resetForm();
    });
})