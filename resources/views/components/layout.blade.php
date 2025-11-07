<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'My App' }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- CSS Template Asli -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- CUSTOM STYLE - Perbaiki efek klik & hover sidebar -->
    <style>
        /* Warna menu aktif (solid, bukan transparan) */
        .mm-active > a,
        #sidebar-menu ul li a.active {
            background: #e9e9f1 !important;
            color: #5a6c7d !important;
            box-shadow: none !important;
        }

        /* Hover sidebar (tanpa efek transparan ungu) */
        #sidebar-menu ul li a:hover,
        #sidebar-menu ul li a:focus,
        #sidebar-menu ul li a:active {
            background-color: #e9e9f1 !important; /* warna abu lembut solid */
            color: #5a6c7d !important;
            box-shadow: none !important;
            border-radius: 6px !important;
        }

        /* Hilangkan efek "wave" klik yang transparan */
        .waves-effect,
        .waves-effect:active,
        .waves-effect:focus {
            background: none !important;
            box-shadow: none !important;
        }

        /* Aktif submenu */
        .metismenu li.mm-active > a {
            background-color: #5a6c7d !important;
            color: #fff !important;
        }

        /* Sidebar border & background biar lembut */
        .vertical-menu {
            background-color: #f8f9fa !important; /* putih keabu */
            border-right: 1px solid #dee2e6;
        }

        /* Tekan spacing antar item */
        #sidebar-menu ul li a {
            padding: 10px 20px !important;
            transition: all 0.2s ease-in-out;
        }
    </style>
</head>

<body data-layout-mode="light" data-layout-width="fluid" data-layout-position="fixed" 
      data-topbar="light" data-sidebar-size="sm" data-sidebar="light">
      
    <div id="layout-wrapper">
        <x-navbar />
        <x-sidebar />
        
        <!-- MAIN CONTENT AREA -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- jQuery (dibutuhkan oleh metismenu) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- SCRIPT TEMPLATE -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Fix Hamburger Menu (tetap sama) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger-icon, .menu-toggle, [data-toggle="sidebar"], .vertical-menu-btn');
            
            if (hamburger) {
                hamburger.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const body = document.body;
                    if (body.classList.contains('sidebar-enable')) {
                        body.classList.remove('sidebar-enable');
                    } else {
                        body.classList.add('sidebar-enable');
                    }
                    
                    console.log('Hamburger clicked - Sidebar toggled');
                });
                
                console.log('Hamburger menu initialized');
            } else {
                console.warn('Hamburger button not found!');
            }
        });
    </script>

    @include('livewire.assurance.bot.partials.project-modal')
</body>
</html>
