
$(document).ready(function(){
    $("label.form-label").html(function(_, html) {
        return html.replace("*", "<span style='color:red;'>*</span>");
    });
    $("[placeholder]").css("font-style", "italic");

    // Remove tombol Spinner field type number
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
    
    // Set ulang nilai NIS & NIK agar bersih saat halaman di-load
    $("#nis, #nik").each(function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });    

    // Mencegah scroll mengubah nilai input number
    $("#nis, #nik").on("wheel", function (e) {
        e.preventDefault();
    });

    // Mencegah Arrow Key mengubah nilai input number
    $("#nis, #nik").on("keydown input", function (e) {
        // Cegah Arrow Up & Down
        if (e.key === "ArrowUp" || e.key === "ArrowDown") {
            e.preventDefault();
        }
        // Hapus karakter selain angka
        this.value = this.value.replace(/[^0-9]/g, "");
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

    // Perubahan langsung saat user mengetik / memilih input
    $("input[required], select[required], textarea[required]").on("input change", function () {
        if ($(this).val().trim() !== "" && $(this).val() !== "Pilih...") {
            $(this).removeClass("is-invalid").addClass("is-valid");
            this.setCustomValidity("");
        } else {
            $(this).addClass("is-invalid").removeClass("is-valid");
        }
    });
    
    // Saat user mengetik di form Tambah Santri, otomatis isi form Preview Santri
    $("#formEditSantri input, #formEditSantri textarea, #formEditSantri select").on("input change", function () {
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

    //Flatpickr
    flatpickr("#tglLahir", {
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
        onReady: function (selectedDates, dateStr, instance) {
            let inputAlt = $(instance.altInput); // Input alternatif (yang terlihat)
    
            // Update preview dengan format yang sama
            $("#PVtgl_lahir").val(inputAlt.val());
        },
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
        onReady: function (selectedDates, dateStr, instance) {
            let inputAlt = $(instance.altInput); // Input alternatif (yang terlihat)
    
            // Update preview dengan format yang sama
            $("#PVtgl_masuk").val(inputAlt.val());
        },
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
        onReady: function (selectedDates, dateStr, instance) {
            let inputAlt = $(instance.altInput); // Input alternatif (yang terlihat)
    
            // Update preview dengan format yang sama
            $("#PVtgl_keluar").val(inputAlt.val());
        },
        onChange: function (selectedDates, dateStr, instance) {
            let inputAlt = $(instance.altInput); // Input alternatif (yang terlihat)
    
            // Update preview dengan format yang sama
            $("#PVtgl_keluar").val(inputAlt.val());
        }
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

    // Submit & Validasi Submit
    $('#formEditSantri').on('submit', function(event){
        event.preventDefault();
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
            event.preventDefault();
            $(this).find(".is-invalid").first().focus();
            return;
        }
    
        let formData = new FormData($('#formEditSantri')[0]);
        let urlParams = new URLSearchParams(window.location.search);
        let oldNis = urlParams.get('nis'); // Ambil dari ?nis= di URL

        // Ambil NIS baru dari input form
        let newNis = $('#nis').val(); 
        formData.append('_method', 'PATCH');
    
        Swal.fire({
            icon: "info",
            title: "Yakin ingin mengubah data?",
            showDenyButton: true,
            confirmButtonText: "Ya, Simpan!",
            denyButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "/data-santri/update?nis=" + oldNis, // Pakai query string NIS
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: response.message
                        });

                        // Jika NIS berubah, update URL tanpa reload
                        if (newNis !== oldNis) {
                            let newUrl = new URL(window.location.href);
                            newUrl.searchParams.set('nis', newNis);
                            window.history.replaceState(null, '', newUrl); // Ubah URL tanpa reload
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
                Swal.fire("Perubahan dibatalkan", "", "info");
            }
        });
    });

    $('#btnResetTGK').on('click', function(){
        const $tglKeluar = flatpickr("#tglKeluar", {
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "Y-m-d",
            onReady: function (selectedDates, dateStr, instance) {
                let inputAlt = $(instance.altInput); // Input alternatif (yang terlihat)
        
                // Update preview dengan format yang sama
                $("#PVtgl_keluar").val(inputAlt.val());
            },
            onChange: function (selectedDates, dateStr, instance) {
                let inputAlt = $(instance.altInput); // Input alternatif (yang terlihat)
        
                // Update preview dengan format yang sama
                $("#PVtgl_keluar").val(inputAlt.val());
            }
        });
        
        $tglKeluar.clear();
    })
    

    $("#btnBatal").on("click", function () {
        window.location.href = "/data-santri";
    });
})