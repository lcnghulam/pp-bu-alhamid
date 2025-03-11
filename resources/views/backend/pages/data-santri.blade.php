<x-backend-layout title='{{ $title }}'>
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h1 class="h1 mb-0">Data Santri</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button id="btnTambah" class="btn btn-primary mb-3">
                        <i class="fa-solid fa-plus"></i> Tambah Data
                    </button>
                    <button id="btnRefresh" class="btn btn-secondary mb-3">
                        <i class="fa-solid fa-rotate-left"></i> Refresh
                    </button>
                    @include('backend.components.data-santri-table')
                </div>
            </div>
        </div>
    </div>
    @vite('resources/views/backend/components/data-santri.js')
</x-backend-layout>