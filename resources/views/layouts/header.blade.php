<header class="vw-site-header-wrapper vw-site-header-background">
	<div class="vw-site-header">
		<div class="container">
			<div class="row">
				<div class="col-md-12 vw-site-header-inner">
					<div class="vw-site-logo-wrapper">
                        @section('main_header')
                        <a href="http://www.hups.mil.gov.ua" alt="Офіційний сайт Харківського національного університету Повітряних Сил"><div class="hups-logo">
						</div></a>
						<a class="vw-site-logo-link" href="http://www.hups.mil.gov.ua">
							<!-- Site Logo -->		
							<h1 class="vw-site-title">Харківський національний університет Повітряних Сил ім. І. Кожедуба</h1>
							<h2 class="vw-site-tagline">Архiв наукових видань</h2>
						</a>
                        @show
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="container periodic-nav">
        <div class="row">
            <div class="col-md-10">
                <div class="vw-menu-main-inner clearfix">
                    <nav>
                        <ul class="periodic-nav-ul">
                            @section('main_menu')
                            <li class="periodic-nav-li">
                                <a href="{{{route('journal.index')}}}">
                                    <i class="fa fa-book"></i>
                                    <span>Видання</span>
                                </a>
                            </li>
                            <li class="periodic-nav-li periodic-item-nav-1">
                                <a href="{{{route('author.index')}}}">
                                    <i class="fa fa-users"></i>
                                    <span>Автори</span>
                                </a>
                            </li>
                            <li class="periodic-nav-li periodic-item-nav-2">
                                <a href="{{{route('topic.index')}}}">
                                    <i class="fa fa-folder"></i>
                                    <span>Тематики</span>
                                </a>
                            </li>
                            <li class="periodic-nav-li periodic-item-nav-3">
                                <a href="{{{route('search.index')}}}">
                                    <i class="fa fa-search"></i>
                                    <span>Пошук</span>
                                </a>
                            </li>
                            @show
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-md-2">
                <div style="padding: 8px 0 0 20px;"></div>
                @section('lang_switch')
                    <a style="color:#FFFFFF;text-decoration: none;" href="{{{route('eng.journal.index')}}}" alt="English version">
                        <img src={{{ url('/public/img/eng.png') }}}>
                        ENG
                    </a>
                @show
            </div>
            {{--<div class="col-md-2">--}}
                {{--<div id="google_translate_element" style="padding: 8px 0 0 20px;"></div><script type="text/javascript">--}}
                    {{--function googleTranslateElementInit() {--}}
                        {{--new google.translate.TranslateElement({pageLanguage: 'uk', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');--}}
                    {{--}--}}
                {{--</script><script async type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>--}}
            {{--</div>--}}
        </div>
    </div>
</header>
<!--<div class="container">
    <div class="row bottom10">
        <div class="col-md-2 text-center text-muted">
            <a class="btn btn-default" href="{{{ route('journal.index') }}}" role="button"><b>До переліку видань</b></a>
        </div>        
    </div>
</div>-->