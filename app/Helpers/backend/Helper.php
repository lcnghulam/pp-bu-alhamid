<?php

use Illuminate\Support\Facades\Route;

function getBackendNavData()
{
    // Ambil segment URL dari request saat ini
    $segments = request()->segments();
    $url = '';
    $lastIndex = array_key_last($segments);

    // Cek apakah halaman ini benar-benar dashboard
    $isDashboard = count($segments) === 0; // Jika tidak ada segment, berarti di dashboard

    // Array untuk menyimpan breadcrumbs
    $breadcrumbs = [
        [
            'name' => 'Dashboard',
            'url'  => route('dashboard'),
            'active' => $isDashboard, // Tandai dashboard aktif jika di halaman dashboard
        ]
    ];

    // Array untuk sidebar active check
    $activeRoutes = $isDashboard ? ['dashboard'] : []; // Hanya masukkan dashboard jika memang di halaman dashboard

    // Loop melalui setiap segment URL untuk membentuk breadcrumbs & menentukan sidebar yang aktif
    foreach ($segments as $index => $segment) {
        $url .= '/' . $segment;
        $isLast = $index === $lastIndex;
        $segmentName = ucwords(str_replace('-', ' ', $segment));

        // Tambahkan ke breadcrumbs
        $breadcrumbs[] = [
            'name' => $segmentName,
            'url'  => $isLast ? null : url($url),
            'active' => $isLast, // Tandai aktif hanya jika halaman terakhir
        ];

        // Tambahkan ke daftar active sidebar
        $activeRoutes[] = $segment;
    }

    return [
        'breadcrumbs'  => $breadcrumbs,
        'activeRoutes' => $activeRoutes,
    ];
}

function getParentRoute()
{
    // Coba ambil nama route jika ada
    $currentRoute = request()->route()?->getName();

    if ($currentRoute) {
        $parentRoute = explode('.', $currentRoute)[0] ?? null;

        // Jika parent route ditemukan dan terdaftar, arahkan ke parent
        if ($parentRoute && Route::has($parentRoute)) {
            return route($parentRoute);
        }
    }

    // Jika tidak ada route name, ambil berdasarkan path
    $segments = explode('/', request()->path());

    // Cek apakah ada segment pertama (misalnya: "posts" dari "/posts/datax")
    if (!empty($segments[0]) && Route::has($segments[0])) {
        return route($segments[0]); // Redirect ke parent jika terdaftar
    }

    // Fallback jika semua gagal
    return request()->is('dashboard/*') ? route('dashboard') : route('welcome');
}

