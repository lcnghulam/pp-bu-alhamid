<?php

// use Illuminate\Routing\Route;

// function isActiveRoute($routeName)
// {
//     // Bisa menangani wildcard '*' dalam route
//     return request()->is($routeName) || \Illuminate\Support\Facades\Route::is($routeName);
// }

// function set_active($uri, $output = 'active')
// {
//     if (is_array($uri)) {
//         foreach ($uri as $u) {
//             if (isActiveRoute($u)) {
//                 return $output;
//             }
//         }
//     } else {
//         if (isActiveRoute($uri)) {
//             return $output;
//         }
//     }

//     return ''; // Default jika tidak aktif
// }


function getNavigationData()
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

