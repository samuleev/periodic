@extends('layouts.default')

@section('main_header')
    <a href="http://www.hups.mil.gov.ua" alt="Ivan Kozhedub Kharkiv National Air Force University (KNAFU)"><div class="hups-logo">
        </div></a>
    <a class="vw-site-logo-link" href="http://www.hups.mil.gov.ua">
        <!-- Site Logo -->
        <h1 class="vw-site-title">Ivan Kozhedub Kharkiv National Air Force University (KNAFU)</h1>
        <h2 class="vw-site-tagline">Archive of scientific publications</h2>
    </a>
@stop

@section('main_menu')
    <li class="periodic-nav-li">
        <a href="{{{route('journal.index')}}}">
            <i class="fa fa-book"></i>
            <span>Publications</span>
        </a>
    </li>
@stop

@section('footer_address')
    Kharkiv (61023)<br> Sumska street 77/79
@stop
