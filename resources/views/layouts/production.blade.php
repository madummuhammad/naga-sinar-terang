<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}"> 
  <title>@yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('assets')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{url('assets')}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{url('assets')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('assets')}}/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{url('assets')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('assets')}}/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="{{url('assets')}}/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="{{url('assets')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{url('assets')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{url('assets')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    @include('includes.navbar-production')
    @include('includes.sidebar-production')
    @yield('container')
    @include('includes.footer-production')

    @stack('prepend-script')             
    <script src="{{url('assets')}}/plugins/jquery/jquery.min.js"></script>
    <script src="{{url('assets')}}/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{url('assets')}}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{url('assets')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{url('assets')}}/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="{{url('assets')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="{{url('assets')}}/dist/js/adminlte.js"></script>
    <script src="{{url('assets')}}/dist/js/demo.js"></script>
    <script src="{{url('assets')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    @stack('addon-script')
  </body>
  </html>
