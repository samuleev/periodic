<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Document</title>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Main Stylesheets -->
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet" type="text/css" />
    <!-- Awesome Icons 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->   
</head>
<body>
@include('layouts.header')
@yield('content')
@include('layouts.footer')
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
</body>
</html>