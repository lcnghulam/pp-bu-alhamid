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

        // Muat DataTables Buttons dan semua ekstensi

        console.log("✅ Semua ekstensi DataTables berhasil dimuat!");

        // Inisialisasi DataTables setelah semua ekstensi dimuat
        $(document).ready(function () {
            console.log("✅ DataTables siap digunakan!");

            var tablePosts = $("#tabelPosts").DataTable({
                processing: true,
                // serverSide: false,
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
                            columns: ':not(:last-child)'
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
                    url: "/posts/data", // Pastikan route sesuai dengan Laravel
                    type: "GET",
                    beforeSend: function () {
                        console.log("📡 AJAX Request dikirim ke:", "/posts/data");
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "Terjadi kesalahan pada server.";
                        Swal.fire("Gagal!", errorMessage, "error");
                        console.error("❌ AJAX Error:", error);
                        console.log("📌 Full response:", xhr.responseText);
                    }
                },
                columns: [
                    { data: "title", name: "post_judul" },
                    { data: "category", name: "post_category" },
                    { data: "sub_category", name: "posts_relations.posts_subcategory.sub_category" }, // Untuk sorting & search
                    { data: "tag", name: "posts_relations.posts_tag.tag" }, // Untuk sorting & search
                    { data: "author", name: "author.name" },
                    { data: "date", name: "post_date" },
                    { data: "status", name: "post_status" },
                    { data: "aksi", orderable: false, searchable: false }
                ],
                order: [],
                drawCallback: function () {
                    $("#tabelPosts tbody td:nth-child(8)").addClass("table-action");

                    // Pastikan Feather Icons diganti ulang
                    if (typeof feather !== "undefined") {
                        feather.replace();
                    }
                }
            });

            // Tambahkan tombol export ke dalam UI
            tablePosts.buttons().container().appendTo("#tabelPosts_wrapper .col-md-12:eq(0)");
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
        window.location.href = "posts/tambah";
    })

    $('#btnRefresh').on('click', function () {
        $('#tabelPosts').DataTable().ajax.reload(); // Reload DataTable
    });

    $('#tabelPosts').on('click', '#btnDestroy', function () {
        let id = $(this).data('id');
    
        Swal.fire({
            title: "Hapus Post?",
            text: "Post yg dipilih akan dihapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/posts/destroy",
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // CSRF Token
                        id: id
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Telah dihapus!",
                                html: response.message
                            }).then(() => {
                                $('#tabelPosts').DataTable().ajax.reload();
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire("Error!", "Gagal menghapus Post.", "error");
                    }
                });
            }
        });
    });  
})