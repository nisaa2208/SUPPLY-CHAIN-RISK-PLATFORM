<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Global Supply Chain Risk Platform',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */
'logo' => '<i class="fas fa-shield-alt text-primary mr-2"></i><b>Supply</b><span class="text-primary">Risk</span>',

'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',

'logo_img_class' => 'brand-image elevation-3',

'logo_img_xl' => null,

'logo_img_xl_class' => 'brand-image-xl',

'logo_img_alt' => 'Global Supply Chain Risk Platform',
    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,

'usermenu_header' => true,

'usermenu_header_class' => 'bg-primary',

'usermenu_image' => true,

'usermenu_desc' => true,

'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */
'layout_topnav' => false,

'layout_boxed' => false,

'layout_fixed_sidebar' => true,

'layout_fixed_navbar' => true,

'layout_fixed_footer' => false,

'layout_dark_mode' => false,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */
'classes_body' => 'layout-fixed layout-navbar-fixed',

'classes_brand' => 'bg-gradient-primary',

'classes_brand_text' => 'font-weight-bold text-light',

'classes_content_wrapper' => 'bg-light',

'classes_content_header' => 'pb-2',

'classes_content' => 'px-3',
'classes_sidebar' => 'sidebar-dark-primary elevation-4 sidebar-no-expand',

'classes_sidebar_nav' => 'nav-flat nav-child-indent',

'classes_topnav' => 'navbar-white navbar-light shadow',

'classes_topnav_nav' => 'navbar-expand',

'classes_topnav_container' => 'container-fluid',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    /*
|--------------------------------------------------------------------------
| Sidebar
|--------------------------------------------------------------------------
*/

'sidebar_mini' => true,

'sidebar_collapse' => false,

'sidebar_collapse_auto_size' => true,

'sidebar_collapse_remember' => true,

'sidebar_collapse_remember_no_transition' => false,

'sidebar_scrollbar_theme' => 'os-theme-dark',

'sidebar_scrollbar_auto_hide' => 'leave',

'sidebar_nav_accordion' => false,

'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

   'right_sidebar' => true,

'right_sidebar_icon' => 'fas fa-sliders-h',

'right_sidebar_theme' => 'dark',

'right_sidebar_slide' => true,

'right_sidebar_push' => false,

'right_sidebar_scrollbar_theme' => 'os-theme-dark',

'right_sidebar_scrollbar_auto_hide' => 'leave',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */
'menu' => [
    [
        'text' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => 'fas fa-tachometer-alt text-primary',
    ],
    [
        'text' => 'Informasi Negara',
        'route' => 'countries.index',
        'icon' => 'fas fa-flag text-info',
    ],
    [
        'text' => 'Analisis Risiko',
        'route' => 'analytics',
        'icon' => 'fas fa-chart-pie text-danger',
    ],
    [
        'text' => 'Monitoring Cuaca',
        'route' => 'weather.index',
        'icon' => 'fas fa-cloud-sun text-warning',
    ],
    [
        'text' => 'Nilai Tukar Mata Uang',
        'route' => 'exchange.index',
        'icon' => 'fas fa-coins text-success',
    ],
    [
        'text' => 'Berita Global',
        'route' => 'news.index',
        'icon' => 'fas fa-newspaper text-indigo',
    ],
    [
        'text' => 'Lokasi Pelabuhan',
        'route' => 'ports.index',
        'icon' => 'fas fa-anchor text-cyan',
    ],
    [
        'text' => 'Visualisasi Data',
        'route' => 'world.map',
        'icon' => 'fas fa-map-marked-alt text-teal',
    ],
    [
        'text' => 'Perbandingan Negara',
        'route' => 'countries.compare',
        'icon' => 'fas fa-balance-scale text-purple',
    ],
    [
        'text' => 'Daftar Favorit',
        'route' => 'favorites.index',
        'icon' => 'fas fa-star text-warning',
    ],
    [
        'text' => 'Artikel Analisis',
        'route' => 'articles.index',
        'icon' => 'fas fa-book-open text-info',
    ],
    [
        'header' => 'ADMIN DASHBOARD & KELOLA (PDF HAL 6)',
        'can' => 'admin-only',
    ],
    [
        'text' => 'Admin Panel Dashboard',
        'route' => 'admin.dashboard',
        'icon' => 'fas fa-user-shield text-danger',
        'can' => 'admin-only',
    ],
    [
        'text' => 'Kelola User',
        'route' => 'users.index',
        'icon' => 'fas fa-users-cog text-warning',
        'can' => 'admin-only',
    ],
    [
        'text' => 'Tambah Pelabuhan Baru',
        'route' => 'ports.create',
        'icon' => 'fas fa-plus-circle text-success',
        'can' => 'admin-only',
    ],
    [
        'text' => 'Fitur AI / Sentiment Engine',
        'route' => 'admin.ai.sentiment',
        'icon' => 'fas fa-brain text-purple',
        'can' => 'admin-only',
    ],
],
    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

  'plugins' => [

    'Datatables' => [
        'active' => true,
        'files' => [
            [
                'type' => 'js',
                'asset' => false,
                'location' => 'https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js',
            ],
            [
                'type' => 'js',
                'asset' => false,
                'location' => 'https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js',
            ],
            [
                'type' => 'css',
                'asset' => false,
                'location' => 'https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css',
            ],
        ],
    ],

    'Chartjs' => [
        'active' => true,
        'files' => [
            [
                'type' => 'js',
                'asset' => false,
                'location' => 'https://cdn.jsdelivr.net/npm/chart.js',
            ],
        ],
    ],

    'Leaflet' => [
        'active' => true,
        'files' => [
            [
                'type' => 'css',
                'asset' => false,
                'location' => 'https://unpkg.com/leaflet/dist/leaflet.css',
            ],
            [
                'type' => 'js',
                'asset' => false,
                'location' => 'https://unpkg.com/leaflet/dist/leaflet.js',
            ],
        ],
    ],

],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
