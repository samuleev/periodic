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
                <div class="col-md-3">
                    <div style="border:1px solid darkgrey;">
                    <br>
                    <br>
                    <div>
                        <p style="text-align:center; font-weight: bold">Загальна кількість публікацій</p>
                        <p style="letter-spacing: 1px; font-family: digital_counter_7regular; font-size: 60px; color: #000000; background-color: #ddddff; text-align:center">{{{$articleCount}}}</p>
                        <p style="text-align:center; font-weight: bold">з 1996 року</p>
                    </div>
                        <br>
                        <br>
                    </div>

                    {{--<img src={{{ url('/public/img/archive-title-img.jpg') }}}>--}}
                </div>
                <div class="col-md-9" style="margin-bottom:21px;">
                    <p style="text-align:justify;">Усі наукові видання університету мають державну реєстрацію та входять до <a href="http://old.mon.gov.ua/ua/activity/563/perelik-naukovikh-fakhovikh-vidan/6797/" target="_blank">„Переліку наукових фахових видань України, в яких можуть публікуватися результати дисертаційних робіт на здобуття наукових ступенів доктора і кандидата наук”</a>.</p>
                    <p style="text-align:justify;">Реферативна інформація зберігається у загальнодержавній реферативній базі даних Державної бібліотеки імені Вернадського „Україніка наукова” та публікується у відповідних тематичних серіях журналу „Джерело”.</p>
                    <p style="text-align:justify;">Видання індексуються міжнародними бібліометричними та наукометричними базами даних: Academic Resource Index, Google Scholar, Index Copernicus, Open Academic Journals Index, Scientific Indexed Service, Universal Impact Factor.</p>
                    <p style="text-align:justify;">Редакційні колегії наукових видань університету в своїй роботі керуються <a href="{{{ url('/public/data/publication_ethics_hnups.pdf') }}}" target="_blank">„Етичними правилами наукових видань ХНУПС”</a>, які відповідають рекомендаціям Комітету з етики публікацій SCOPUS, а також спираються на досвід авторитетних міжнародних та вітчизняних журналів та видавництв.</p>
                    <p>Контактні телефони редакції наукових видань: (067) 998-02-70, (057) 704-91-97</p>
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
