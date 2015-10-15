<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Document</title>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Main Stylesheets -->
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet" type="text/css" />
    <style>
        div { font-size: 12px; }

        .top5 { margin-top:5px; }
        .top10 { margin-top:10px; }
        .top15 { margin-top:15px; }
        .top20 { margin-top:20px; }
        .top30 { margin-top:30px; }

        .bottom5 { margin-bottom:5px; }
        .bottom10 { margin-bottom:10px; }
        .bottom15 { margin-bottom:15px; }
        .bottom20 { margin-bottom:20px; }
        .bottom30 { margin-bottom:30px; }

        .border {border: 1px solid rgba(86,86,124,.2);}

        .padding15 {
            padding-top: 15px;
            padding-bottom: 15px;
            padding-right: 15px;
            padding-left: 15px;
        }


    </style>
</head>
<body>
@include('layouts.header')
@yield('content')
@include('layouts.footer')
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
</body>
</html>