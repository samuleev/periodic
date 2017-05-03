@extends('eng.layouts.default')

@section('seo_headers')
    <title>Publications of Ivan Kozhedub Kharkiv National Air Force University</title>
    <meta name="keywords" content="scientific papers, technical science, military science" >
    <meta name="description" content="Publications of Ivan Kozhedub Kharkiv National Air Force University" >
@stop

@section('bread_crumbs')
        <li class="active">Publications</li>
@stop

@section('lang_switch')
    <a style="color:#FFFFFF;text-decoration: none;" href="{{{route('journal.index')}}}" alt="Українська версія">
        <img src={{{ url('/public/img/ukr.png') }}}>
        УКР
    </a>
@stop

@section('content')
    @if(count($journals))
        <div class="container main-content">
            <div class="row" style="margin-top:21px;">
                <div class="col-md-4">
                    {{--<div style="border:1px solid darkgrey;">--}}
                        {{--<br>--}}
                        {{--<br>--}}
                        {{--<div>--}}
                            {{--<p style="text-align:center; font-weight: bold">Number of publications</p>--}}
                            {{--<p style="letter-spacing: 1px; font-family: digital_counter_7regular; font-size: 60px; color: #000000; background-color: #ddddff; text-align:center">{{{$articleCount}}}</p>--}}
                            {{--<p style="text-align:center; font-weight: bold">since 1996</p>--}}
                        {{--</div>--}}
                        {{--<br>--}}
                        {{--<br>--}}
                    {{--</div>--}}
                    {{--<img src={{{ url('/public/img/archive-title-img.jpg') }}}>--}}
                    <a href="{{{ url('/public/img/certificate_001.jpg') }}}" target="_blank">
                        <img src={{{ url('/public/img/certificate_001_s.jpg') }}}>
                    </a>
                </div>
                <div class="col-md-8" style="margin-bottom:21px;">
                    <p style="text-align:justify;">All the University scientific publications have State registration and are included into the <a href="http://old.mon.gov.ua/ua/activity/563/perelik-naukovikh-fakhovikh-vidan/6797/" target="_blank">«List of Scientific Professional Publications of Ukraine, where results of final papers for the degree of Doctor of Science and Doctor of Philisophy can be published»</a>.</p>
                    <p style="text-align:justify;">Abstract information is kept in the National Abstract Database of Vernadskii National Library “Ukrainika naukova” and is publised in the relative subject periodicals of the journal “Dzherelo”.</p>
                    <p style="text-align:justify;">Publications have the index of international bibliometric and sciencemetric data bases: Academic Resource Index, Google Scholar, Index Copernicus, Open Academic Journals Index, Scientific Indexed Service, Universal Impact Factor.</p>
                    <p style="text-align:justify;">KhNAFU editorial boards of scientific publications follow the recommendations of the <a href="{{{ url('/public/data/publication_ethics_hnups_eng.pdf') }}}" target="_blank">«The Ethical Rules of KhNAFU Scientific Publications»</a> that meet the requirements of SCOPUS Publishing Ethics Committee, on the experience of authoritative international and national journals and publishing houses.</p>
                    <p>Scientific publications editorial contact telephone number: (067) 998-02-70, (057) 704-91-97</p>
                </div>
            </div>
            @foreach($journals as $index => $journal)
                    @if($journal->publishing)
                    <div class="row top10">
                        <div class="col-md-12">
                            @include('eng.journal.index_element')
                        </div>
                    </div>
                    @endif
            @endforeach
        </div> {{-- container --}}
    @else
        <p>No journals</p>
    @endif
@stop
