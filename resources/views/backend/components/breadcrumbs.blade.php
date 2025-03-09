<div class="card mt-3 mb-2">
    @php
        $segments = request()->segments();
        $url = '';
        $lastIndex = array_key_last($segments);
    @endphp

    <nav class="d-flex align-items-center ps-3" aria-label="breadcrumb">
        <i class="align-middle" data-feather="chevron-right"></i>
        <ol class="breadcrumb mb-0">
            <!-- Root: Dashboard -->
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>

            @foreach ($segments as $index => $segment)
                @php
                    $url .= '/' . $segment;
                    $isLast = $index === $lastIndex;
                    $segmentName = ucwords(str_replace('-', ' ', $segment));
                @endphp

                <li class="breadcrumb-item {{ $isLast ? 'active' : '' }}">
                    @if (!$isLast)
                        <a href="{{ url($url) }}">{{ $segmentName }}</a>
                    @else
                        {{ $title ?? $segmentName }}  {{-- 🔥 Perubahan di sini! --}}
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>