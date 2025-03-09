<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <span class='sidebar-brand'>
            <span class="sidebar-brand-text align-middle">
                Pondok Bahrul Ulum <br>Al-Hamid
            </span>
            <img src="{{ Vite::asset('resources/backend/img/logo-bu-compact.png') }}" alt="Pondok Bahrul Ulum Al-Hamid" class="sidebar-brand-icon align-middle">
        </span>
        
        <ul class="sidebar-nav">
            
            <li class="sidebar-item {{ set_active('dashboard') }}" id="dashboard-menu">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="home"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>
            
            <li class="sidebar-header">
                Master Data
            </li>

            <li class="sidebar-item">
                <a class='sidebar-link' href='#'>
                    <i class="align-middle" data-feather="layout"></i>
                    <span class="align-middle">Profil Web</span>
                </a>
            </li>
            <li class="sidebar-item {{ set_active('data-santri') }}">
                <a class='sidebar-link' href='{{ route('data-santri') }}'>
                    <i class="align-middle" data-feather="users"></i> 
                    <span class="align-middle">Data Santri</span>
                </a>
            </li>
        </ul>
    </div>
</nav>