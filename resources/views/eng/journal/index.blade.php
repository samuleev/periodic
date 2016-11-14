@extends('layouts.default')

@section('seo_headers')
    <title>Publications of Ivan Kozhedub Kharkiv National Air Force University</title>
    <meta name="keywords" content="scientific papers, technical science, military science" >
    <meta name="description" content="Publications of Ivan Kozhedub Kharkiv National Air Force University" >
@stop

@section('bread_crumbs')
        <li class="active">Publications</li>
@stop

@section('content')
    @if(count($journals))
        <div class="container main-content">
            <div class="row" style="margin-top:21px;">
                <div class="col-md-4">
                    <img src={{{ url('/public/img/archive-title-img.jpg') }}}>
                </div>
                <div class="col-md-8" style="margin-bottom:21px;">
                    <p style="text-align:justify;"><strong>University scientific publications have State Registration.</strong> Electronic versions of publications are placed in scientific publications base of Vernadsky National Library of Ukraine.</p>
                    <p style="text-align:justify;">Four scientific publications are a part of science-metric data base and  <a href="http://old.mon.gov.ua/ua/activity/563/perelik-naukovikh-fakhovikh-vidan/6797/" target="_blank">«List of scientific professional publications of Ukraine, where results of theses for the degree of doctor and candidate»</a>.</p>
                    <p style="text-align:justify;">KNAFU editors of scientific publications follow  the recommendations of the Ethics SCOPUS publications Committee, and base on the experience of authoritative international  and national journals and founders.</p>
                    <p><a href="{{{ url('/public/data/publication_ethics_hnups.pdf') }}}" target="_blank">KNAFU ethical rules of scientific publications</a></p>
                    <p><strong>Contact telephone number:</strong> (067) 998-02-70</p>
                </div>
            </div>
            @foreach($journals as $index => $journal)
                    <div class="row top10">
                        <div class="col-md-12">
                            @include('eng.journal.index_element')
                        </div>
                    </div>
            @endforeach
        </div> {{-- container --}}
    @else
        <p>No journals</p>
    @endif
@stop
