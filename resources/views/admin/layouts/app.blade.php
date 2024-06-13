<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ !empty($header_title) ? $header_title : '' }} - Ecommerce</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ url('public/assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('public/assets/dist/css/adminlte.min.css') }}">
  <!-- Tinymce editor -->
  <script src="https://cdn.tiny.cloud/1/4vzx5exrxbzqo2k354zo41l38k660yxolxvmb50izdhtaikn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

  @yield('style')

</head>



<body class="hold-transition sidebare-mini">

    <div class="wrapper">
        @include('admin.layouts.header')
        @yield('content')
        @include('admin.layouts.footer')
    </div>
    


    <!-- jQuery -->
    <script src="{{ url('public/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ url('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ url('public/assets/dist/js/adminlte.js') }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ url('public/assets/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('public/assets/dist/js/demo.js') }}"></script>
    

    @yield('script')

</body>
</html>