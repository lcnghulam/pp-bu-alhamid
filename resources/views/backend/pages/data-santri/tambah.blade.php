<x-backend-layout title='{{ $title }}'>
    <div class="row mb-3">
        <h3 class="h3">Tambah Data Santri</h3>
    </div>
    <div class="row">
        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="card-body">
                    @include('backend/components/form-tambah-santri')
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="card-title">Preview Data <i class="align-middle" data-feather="corner-right-down"></i></h5>
                </div>
                <div class="card-body">
                    @include('backend/components/form-preview-data-santri')
                </div>
            </div>
        </div>
    </div>
    @vite('resources/views/backend/components/tambah-data-santri.js')
</x-backend-layout>