<x-backend-layout title='{{ $title }}'>
    <div class="mb-3">
        <h1 class="h1 align-middle mb-3">Data Santri</h1>
        
        <div class="card">
            <div class="card-body">
                <button class="btn btn-success mb-3">
                    <i class="fa-solid fa-plus"></i> Tambah Data
                </button>
                @vite('resources/views/backend/components/data-santri.js')
                @include('backend.components.data-santri-table')
            </div>
        </div>
    </div>
</x-backend-layout>