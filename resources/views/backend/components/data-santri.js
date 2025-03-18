// Tambahkan DataTables CSS
const linkDataTablesCSS = document.createElement("link");
linkDataTablesCSS.rel = "stylesheet";
linkDataTablesCSS.href = "https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css";
document.head.appendChild(linkDataTablesCSS);

// Tambahkan jQuery terlebih dahulu
const scriptJQuery = document.createElement("script");
scriptJQuery.src = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js";
scriptJQuery.onload = function () {
    console.log("✅ jQuery berhasil dimuat!");

    // Muat DataTables setelah jQuery selesai
    loadScript(dataTables, function () {
        console.log("✅ DataTables berhasil dimuat!");

        console.log("✅ Semua ekstensi DataTables berhasil dimuat!");

        // Inisialisasi DataTables setelah semua ekstensi dimuat
        $(document).ready(function () {
            console.log("✅ DataTables siap digunakan!");

            var tableSantri = $("#tabelDataSantri").DataTable({
                processing: true,
                responsive: true,
                dom:
                    '<"row my-2"<"col-md-6"l><"col-md-6 text-end"f>>' +
                    '<"row my-2"<"col-md-12"B>>' +
                    '<"row my-2"<"col-md-12"tr>>' +
                    '<"row my-2"<"col-md-5"i><"col-md-7 text-end"p>>',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: ':not(:last-child)' // Tidak menyertakan kolom terakhir (aksi)
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ],
                lengthMenu: [10, 25, 50, 100], // Menampilkan opsi jumlah data
                ajax: {
                    url: "/data-santri/data", // Pastikan route sesuai dengan Laravel
                    type: "GET",
                    beforeSend: function () {
                        console.log("📡 AJAX Request dikirim ke:", "/data-santri/data");
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "Terjadi kesalahan pada server.";
                        Swal.fire("Gagal!", errorMessage, "error");
                        console.error("❌ AJAX Error:", error);
                        console.log("📌 Full response:", xhr.responseText);
                    }
                },
                columns: [
                    { data: "foto", name: "foto", orderable: false, searchable: false },
                    { data: "nama_santri", name: "nama_santri" },
                    { data: "data_santri", name: "data_santri" },
                    { data: "status", name: "status" },
                    { data: "aksi", name: "aksi", orderable: false, searchable: false }
                ],
                order: [],
                drawCallback: function () {
                    $("#tabelDataSantri tbody td:nth-child(5)").addClass("table-action");

                    // Pastikan Feather Icons diganti ulang
                    if (typeof feather !== "undefined") {
                        feather.replace();
                    }
                }
            });

            // Tambahkan tombol export ke dalam UI
            tableSantri.buttons().container().appendTo("#tabelDataSantri_wrapper .col-md-12:eq(0)");
        });
    });
};

// Tambahkan script jQuery ke body
document.body.appendChild(scriptJQuery);

// Fungsi untuk memuat script secara berurutan
function loadScript(src, callback) {
    const script = document.createElement("script");
    script.src = src;
    script.onload = callback;
    document.body.appendChild(script);
}

$(document).ready(function(){
    $('#btnTambah').on('click',function(){
        window.location.href = "data-santri/tambah";
    })

    $('#btnRefresh').on('click', function () {
        $('#tabelDataSantri').DataTable().ajax.reload(); // Reload DataTable
    });

    $('#tabelDataSantri').on('click', '#btnEdit', function(){
        let nis = $(this).data('id');

        $.ajax({
            url: '/data-santri/edit',
            type: 'get',
            data: {nis: nis},
            success: function (response) {
                if (response.success) {
                    window.location.href = "/data-santri/edit?nis=" + nis
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
        
    });    

    $('#tabelDataSantri').on('click', '#btnDestroy', function () {
        let nis = $(this).data('id'); // Ambil NIS dari atribut data-id
    
        Swal.fire({
            title: "Hapus Data Santri?",
            text: "Data santri yg dipilih akan dihapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/data-santri/destroy",
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // CSRF Token
                        nis: nis
                    },
                    success: function (response) {
                        Swal.fire("Telah dihapus!", response.message, "success");
                        $('#tabelDataSantri').DataTable().ajax.reload(); // Reload DataTable
                    },
                    error: function (xhr) {
                        Swal.fire("Error!", "Gagal menghapus Data Santri.", "error");
                    }
                });
            }
        });
    });    
})