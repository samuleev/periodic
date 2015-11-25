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
                    <b>УКР / РУС</b>
                </div>
                <div class="col-md-11">
                    <div class="container">
                        <div class="btn-toolbar">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-default" onclick="updateAuthors('А')">А</button>
                                <button class="btn btn-default" onclick="updateAuthors('Б')">Б</button>
                                <button class="btn btn-default" onclick="updateAuthors('В')">В</button>
                                <button class="btn btn-default" onclick="updateAuthors('Г')">Г</button>
                                <button class="btn btn-default" onclick="updateAuthors('Ґ')">Ґ</button>
                                <button class="btn btn-default" onclick="updateAuthors('Д')">Д</button>
                                <button class="btn btn-default" onclick="updateAuthors('Е')">Е</button>
                                <button class="btn btn-default" onclick="updateAuthors('Є')">Є</button>
                                <button class="btn btn-default" onclick="updateAuthors('Ж')">Ж</button>
                                <button class="btn btn-default" onclick="updateAuthors('З')">З</button>
                                <button class="btn btn-default" onclick="updateAuthors('И')">И</button>
                                <button class="btn btn-default" onclick="updateAuthors('І')">І</button>
                                <button class="btn btn-default" onclick="updateAuthors('Ї')">Ї</button>
                                <button class="btn btn-default" onclick="updateAuthors('Й')">Й</button>
                                <button class="btn btn-default" onclick="updateAuthors('К')">К</button>
                                <button class="btn btn-default" onclick="updateAuthors('Л')">Л</button>
                                <button class="btn btn-default" onclick="updateAuthors('М')">М</button>
                                <button class="btn btn-default" onclick="updateAuthors('Н')">Н</button>
                                <button class="btn btn-default" onclick="updateAuthors('О')">О</button>
                                <button class="btn btn-default" onclick="updateAuthors('П')">П</button>
                                <button class="btn btn-default" onclick="updateAuthors('Р')">Р</button>
                                <button class="btn btn-default" onclick="updateAuthors('С')">С</button>
                                <button class="btn btn-default" onclick="updateAuthors('Т')">Т</button>
                                <button class="btn btn-default" onclick="updateAuthors('У')">У</button>
                                <button class="btn btn-default" onclick="updateAuthors('Ф')">Ф</button>
                                <button class="btn btn-default" onclick="updateAuthors('Х')">Х</button>
                                <button class="btn btn-default" onclick="updateAuthors('Ц')">Ц</button>
                                <button class="btn btn-default" onclick="updateAuthors('Ч')">Ч</button>
                                <button class="btn btn-default" onclick="updateAuthors('Ш')">Ш</button>
                                <button class="btn btn-default" onclick="updateAuthors('Щ')">Щ</button>
                                <button class="btn btn-default" onclick="updateAuthors('Ы')">Ы</button>
                                <button class="btn btn-default" onclick="updateAuthors('Ь')">Ь</button>
                                <button class="btn btn-default" onclick="updateAuthors('Э')">Э</button>
                                <button class="btn btn-default" onclick="updateAuthors('Ю')">Ю</button>
                                <button class="btn btn-default" onclick="updateAuthors('Я')">Я</button>
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
                                <button class="btn btn-default" onclick="updateAuthors('A')">A</button>
                                <button class="btn btn-default" onclick="updateAuthors('B')">B</button>
                                <button class="btn btn-default" onclick="updateAuthors('C')">C</button>
                                <button class="btn btn-default" onclick="updateAuthors('D')">D</button>
                                <button class="btn btn-default" onclick="updateAuthors('E')">E</button>
                                <button class="btn btn-default" onclick="updateAuthors('F')">F</button>
                                <button class="btn btn-default" onclick="updateAuthors('G')">G</button>
                                <button class="btn btn-default" onclick="updateAuthors('H')">H</button>
                                <button class="btn btn-default" onclick="updateAuthors('I')">I</button>
                                <button class="btn btn-default" onclick="updateAuthors('J')">J</button>
                                <button class="btn btn-default" onclick="updateAuthors('K')">K</button>
                                <button class="btn btn-default" onclick="updateAuthors('L')">L</button>
                                <button class="btn btn-default" onclick="updateAuthors('M')">M</button>
                                <button class="btn btn-default" onclick="updateAuthors('N')">N</button>
                                <button class="btn btn-default" onclick="updateAuthors('O')">O</button>
                                <button class="btn btn-default" onclick="updateAuthors('P')">P</button>
                                <button class="btn btn-default" onclick="updateAuthors('Q')">Q</button>
                                <button class="btn btn-default" onclick="updateAuthors('R')">R</button>
                                <button class="btn btn-default" onclick="updateAuthors('S')">S</button>
                                <button class="btn btn-default" onclick="updateAuthors('T')">T</button>
                                <button class="btn btn-default" onclick="updateAuthors('U')">U</button>
                                <button class="btn btn-default" onclick="updateAuthors('V')">V</button>
                                <button class="btn btn-default" onclick="updateAuthors('W')">W</button>
                                <button class="btn btn-default" onclick="updateAuthors('X')">X</button>
                                <button class="btn btn-default" onclick="updateAuthors('Y')">Y</button>
                                <button class="btn btn-default" onclick="updateAuthors('Z')">Z</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div id="authors_by_letter">
        <div class="container">
            <div class="row top10">
                <div class="col-md-12">
                    <h3>Будь-ласка, оберіть першу літеру прізвища автора</h3>
                </div>
            </div>
        </div>
    </div>
@stop