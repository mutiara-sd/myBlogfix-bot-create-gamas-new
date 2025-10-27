<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'My App' }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- PAKE CSS TEMPLATE ASLI TAPI YANG PENTING AJA -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                    <!-- INI YANG PENTING! -->
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- SCRIPT MINIMAL -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/js/app.js"></script>

    @include('livewire.assurance.bot.partials.project-modal')
</body>
</html>