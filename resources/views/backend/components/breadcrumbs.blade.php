@php
    $navData = getBackendNavData();
@endphp

<div class="card mt-3 mb-2" style="border-radius: 0;">
    @php
        $segments = request()->segments();
        $url = '';
        $lastIndex = array_key_last($segments);
    @endphp

    <nav class="d-flex align-items-center ps-3" aria-label="breadcrumb">
        <i class="align-middle" data-feather="chevron-right"></i>
        <ol class="breadcrumb mb-0">
            @foreach ($navData['breadcrumbs'] as $breadcrumb)
                <li class="breadcrumb-item {{ $breadcrumb['url'] ? '' : 'active' }}">
                    @if ($breadcrumb['url'])
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                    @else
                        {{ $title ?? $breadcrumb['name'] }} {{-- 🔥 Bisa override --}}
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>