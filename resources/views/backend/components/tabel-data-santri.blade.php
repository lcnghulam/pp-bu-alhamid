<button id="btnTambah" class="btn btn-primary mb-3">
    <i class="fa-solid fa-plus"></i> Tambah Data
</button>
<button id="btnRefresh" class="btn btn-secondary mb-3">
    <i class="fa-solid fa-rotate-left"></i> Refresh
</button>
<table id="tabelDataSantri" class="table table-striped hover compact" style="width:100%">
    <thead>
        <tr>
            <th>Foto</th>
            <th>Nama Santri</th>
            <th>Data Santri</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
</table>
<script>
    var dataTables = @json(Vite::asset('resources/backend/js/datatables.js'))
</script>
