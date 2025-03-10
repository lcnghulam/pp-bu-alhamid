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
    loadScript("https://cdn.datatables.net/2.2.2/js/dataTables.min.js", function () {
        console.log("✅ DataTables berhasil dimuat!");

        // Muat DataTables Buttons dan semua ekstensi
        loadScript("https://cdn.datatables.net/buttons/3.2.2/js/dataTables.buttons.min.js", function () {
            loadScript("https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js", function () {
                loadScript("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js", function () {
                    loadScript("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js", function () {
                        loadScript("https://cdn.datatables.net/buttons/3.2.2/js/buttons.html5.min.js", function () {
                            loadScript("https://cdn.datatables.net/buttons/3.2.2/js/buttons.print.min.js", function () {
                                console.log("✅ Semua ekstensi DataTables berhasil dimuat!");

                                // Inisialisasi DataTables setelah semua ekstensi dimuat
                                $(document).ready(function () {
                                    console.log("✅ DataTables siap digunakan!");

                                    var tableSantri = $("#tabelSantri").DataTable({
                                        processing: true,
                                        serverSide: true,
                                        dom: 
                                            '<"row"<"col-md-6"l><"col-md-6 text-end"f>>' + // 🔥 Search ke kanan
                                            '<"row"<"col-md-12"B>>' +                      // Tombol Export (tengah)
                                            '<"row"<"col-md-12"tr>>' +                     // Tabel (penuh)
                                            '<"row"<"col-md-5"i><"col-md-7 text-end"p>>',  // 🔥 Pagination ke kanan
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
                                                console.error("❌ AJAX Error:", error);
                                                console.log("📌 Full response:", xhr.responseText);
                                            }
                                        },
                                        columns: [
                                            { data: "foto", name: "foto", orderable: false, searchable: false },
                                            { data: "nama_santri", name: "nama_santri" },
                                            { data: "data_santri", name: "data_santri" },
                                            { data: "aksi", name: "aksi", orderable: false, searchable: false }
                                        ],
                                        drawCallback: function () {
                                            $("#tabelSantri tbody td:nth-child(4)").addClass("table-action");

                                            // Pastikan Feather Icons diganti ulang
                                            if (typeof feather !== "undefined") {
                                                feather.replace();
                                            }
                                        }
                                    });

                                    // Tambahkan tombol export ke dalam UI
                                    tableSantri.buttons().container().appendTo("#tabelSantri_wrapper .col-md-12:eq(0)");
                                });
                            });
                        });
                    });
                });
            });
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
