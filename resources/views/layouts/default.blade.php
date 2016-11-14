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
    <script async src="{{ asset('/public/js/jquery-1.11.3.min.js') }}"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script async src="{{ asset('/public/js/bootstrap.min.js') }}"></script>
    <!-- Awesome Icons -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href={{{ url('/public/img/favicon.png') }}}>
</head>
<body>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-62616686-1', 'auto');
    ga('send', 'pageview');

</script>
@include('layouts.header')
@include('layouts.crumbs')
@yield('content')
@include('layouts.footer')
</body>
</html>