<x-backend-layout title='{{ $title }}'>
    <div class="row mb-3">
        <h3 class="h3">{{ $title }}</h3>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('backend/components/form-tambah-posts')
                </div>
            </div>
        </div>
    </div>
    @vite('resources/views/backend/components/tambah-posts.js')
</x-backend-layout>