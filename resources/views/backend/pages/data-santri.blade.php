<x-backend-layout title='{{ $title }}'>
    <div id="panelDataSantri">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h1 class="h1 mb-0">{{ $title }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include('backend.components.tabel-data-santri')
                    </div>
                </div>
            </div>
        </div>
        <script>
            var dataTables = @json(Vite::asset('resources/backend/js/datatables.js'))
        </script>
    </div>
    
    @vite('resources/views/backend/components/data-santri.js')
</x-backend-layout>