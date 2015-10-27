<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    @yield('seo_headers')
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('/public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Main Stylesheets -->
    <link href="{{ asset('/public/css/main.css') }}" rel="stylesheet" type="text/css" />
    <!-- JQuery Core JavaScript -->
    <script src="{{ asset('/public/js/jquery-1.11.3.min.js') }}"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ asset('/public/js/bootstrap.min.js') }}"></script>
    <!-- Awesome Icons 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->   
</head>
<body>
@include('layouts.header')
@include('layouts.menu')
@yield('content')
@include('layouts.footer')
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
</body>
</html>