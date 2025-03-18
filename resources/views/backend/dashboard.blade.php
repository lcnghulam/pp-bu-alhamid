<x-backend-layout>
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h1 class="d-inline align-middle">Selamat Datang di Dashboard!</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Data Santri</h5>
                </div>
                <div class="card-body text-center">
                    <script>
                        var santriLaki = @json($santriLaki);
                        var santriPerempuan = @json($santriPerempuan);
                    </script>
                    <div class="chart w-100">
                        <div id="dataSantri" style="max-width: 440px;margin:auto;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/views/backend/components/dashboard.js')
</x-backend-layout>