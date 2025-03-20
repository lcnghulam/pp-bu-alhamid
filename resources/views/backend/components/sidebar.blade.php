<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <span class='sidebar-brand'>
            <span class="sidebar-brand-text align-middle">
                Pondok Bahrul Ulum <br>Al-Hamid
            </span>
            <img src="{{ Vite::asset('resources/backend/img/logo-bu-compact.png') }}" alt="Pondok Bahrul Ulum Al-Hamid" class="sidebar-brand-icon align-middle">
        </span>
        
        <ul class="sidebar-nav">
            <li class="sidebar-item @active('dashboard')">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="home"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">Master Data</li>

            <li class="sidebar-item @active('data-santri')">
                <a class='sidebar-link' href='{{ route('data-santri') }}'>
                    <i class="align-middle" data-feather="users"></i> 
                    <span class="align-middle">Data Santri</span>
                </a>
            </li>
            <li class="sidebar-item @active('posts')">
                <a class='sidebar-link' href='{{ route('posts') }}'>
                    <i class="align-middle" data-feather="edit-3"></i> 
                    <span class="align-middle">Posts</span>
                </a>
            </li>
            <li class="sidebar-item @active('jadwal')">
                <a class='sidebar-link' href='{{ route('jadwal') }}'>
                    <i class="align-middle" data-feather="calendar"></i> 
                    <span class="align-middle">Jadwal</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
