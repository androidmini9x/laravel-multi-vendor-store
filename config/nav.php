<?php

return [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'title' => 'Dashboard',
        'route' => 'dashboard.dashboard',
        'active' => 'dashboard.dashboard'
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'title' => 'Categories',
        'route' => 'dashboard.categories.index',
        'active' => 'dashboard.categories.*'
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'title' => 'Products',
        'route' => 'dashboard.products.index',
        'active' => 'dashboard.products.*'
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'title' => 'Orders',
        'route' => 'dashboard.dashboard',
        'active' => 'dashboard.orders.*'
    ]
];