@extends('layouts.default')

@section('seo_headers')
    <title>Перелік видань Харківського університету Повітряних Сил</title>
    <meta name="keywords" content="науковий журнал, збірник наукових праць, технічні науки, військові науки" >
    <meta name="description" content="Перелік видань Харківського університету Повітряних Сил" >
@stop

@section('bread_crumbs')
        <li class="active">Видання</li>
@stop

@section('content')
    @if(count($journals))
        <div class="container main-content">
            <div class="row" style="margin-top:21px;">
                <div class="col-md-4">
                    <img src={{{ url('/public/img/archive-title-img.jpg') }}}>
                </div>
                <div class="col-md-8" style="margin-bottom:21px;">
                    <p style="text-align:justify;"><strong>Наукові видання університету мають державну реєстрацію.</strong> Електронні версії видань своєчасно розміщуються у базі наукових видань Державної бібліотеки імені Вернадського.</p>
                    <p style="text-align:justify;">Чотири наукових видання університету входять до наукометричних баз даних та до <a href="http://old.mon.gov.ua/ua/activity/563/perelik-naukovikh-fakhovikh-vidan/6797/" target="_blank">«Переліку наукових фахових видань України, в яких можуть публікуватися результати дисертаційних робіт на здобуття наукових ступенів доктора і кандидата наук»</a>.</p>
                    <p style="text-align:justify;">Редакції наукових видань ХНУПС в своїй роботі суворо керуються рекомендаціями Комітету з етики публікацій SCOPUS, а також спираються на досвід авторитетних міжнародних та вітчизняних журналів та видавництв.</p>
                    <p><a href="{{{ url('/public/data/publication_ethics_hnups.pdf') }}}" target="_blank">Етичні правила наукових видань ХНУПС</a></p>
                    <p><strong>Телефон для зв’язку:</strong> (067) 998-02-70</p>
                </div>
            </div>
            @foreach($journals as $index => $journal)
                    @if($journal->publishing)
                    <div class="row top10">
                        <div class="col-md-12">
                            @include('journal.index_element')
                        </div>
                    </div>
                    @endif
            @endforeach
        </div> {{-- container --}}
    @else
        <p>No journals</p>
    @endif
@stop
