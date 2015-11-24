@extends('layouts.default')

@section('seo_headers')
    <title>Перелік авторів видань Харківського університету Повітряних Сил</title>
    <meta name="keywords" content="автор, наукове видання, хупс" >
    <meta name="description" content="Перелік авторів видань Харківського університету Повітряних Сил" >
@stop

@section('bread_crumps')
    <li class="active">Автори</li>
@stop

@section('content')
    <script type="text/javascript">
        function updateAuthors(letter) {
            $('#authors_by_letter').load('author/by_letter/' + letter);
        }
    </script>

        <div class="container">

            <div class="row top10">
                <div class="col-md-1">
                    <b>УКР</b>
                </div>
                <div class="col-md-11">
                    <div class="container">
                        <div class="btn-toolbar">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-default" onclick="updateAuthors('А')">А</button>
                                <button class="btn btn-default" onclick="updateAuthors('Б')">Б</button>
                                <button class="btn btn-default">В</button>
                                <button class="btn btn-default">Г</button>
                                <button class="btn btn-default">Ґ</button>
                                <button class="btn btn-default">Д</button>
                                <button class="btn btn-default">Е</button>
                                <button class="btn btn-default">Є</button>
                                <button class="btn btn-default">Ж</button>
                                <button class="btn btn-default">З</button>
                                <button class="btn btn-default">И</button>
                                <button class="btn btn-default">І</button>
                                <button class="btn btn-default">Ї</button>
                                <button class="btn btn-default">Й</button>
                                <button class="btn btn-default">К</button>
                                <button class="btn btn-default">Л</button>
                                <button class="btn btn-default">М</button>
                                <button class="btn btn-default">Н</button>
                                <button class="btn btn-default">О</button>
                                <button class="btn btn-default">П</button>
                                <button class="btn btn-default">Р</button>
                                <button class="btn btn-default">С</button>
                                <button class="btn btn-default">Т</button>
                                <button class="btn btn-default">У</button>
                                <button class="btn btn-default">Ф</button>
                                <button class="btn btn-default">Х</button>
                                <button class="btn btn-default">Ц</button>
                                <button class="btn btn-default">Ч</button>
                                <button class="btn btn-default">Ш</button>
                                <button class="btn btn-default">Щ</button>
                                <button class="btn btn-default">Ь</button>
                                <button class="btn btn-default">Ю</button>
                                <button class="btn btn-default">Я</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-1">
                    <b>ENG</b>
                </div>
                <div class="col-md-11">
                    <div class="container">
                        <div class="btn-toolbar">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-default">A</button>
                                <button class="btn btn-default">B</button>
                                <button class="btn btn-default">C</button>
                                <button class="btn btn-default">D</button>
                                <button class="btn btn-default">E</button>
                                <button class="btn btn-default">F</button>
                                <button class="btn btn-default">G</button>
                                <button class="btn btn-default">H</button>
                                <button class="btn btn-default">I</button>
                                <button class="btn btn-default">J</button>
                                <button class="btn btn-default">K</button>
                                <button class="btn btn-default">L</button>
                                <button class="btn btn-default">M</button>
                                <button class="btn btn-default">N</button>
                                <button class="btn btn-default">O</button>
                                <button class="btn btn-default">P</button>
                                <button class="btn btn-default">Q</button>
                                <button class="btn btn-default">R</button>
                                <button class="btn btn-default">S</button>
                                <button class="btn btn-default">T</button>
                                <button class="btn btn-default">U</button>
                                <button class="btn btn-default">V</button>
                                <button class="btn btn-default">W</button>
                                <button class="btn btn-default">X</button>
                                <button class="btn btn-default">Y</button>
                                <button class="btn btn-default">Z</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div id="authors_by_letter">
        <script type="text/javascript">
            window.onload = updateAuthors('А');
        </script>
    </div>
@stop