@include('dashboards.partials.user-dashboard', [
    'title' => 'Panel conductor',
    'subtitle' => 'Consulta tus servicios y el estado de tu verificacion.',
    'menuItems' => [
        'Inicio',
        'Servicios disponibles',
        'Mi verificacion',
        'Vehiculo',
        'Perfil',
    ],
    'primaryAction' => 'Ver servicios',
])
