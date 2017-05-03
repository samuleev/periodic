<div class="vw-breadcrumb-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="periodic-breadcrumb">
                    @section('crumbs_root')
                        <li><a href="http://www.hups.mil.gov.ua/nauka/">Наука</a></li>
                    @show
                    @yield('bread_crumbs')
                </ol>
            </div>
        </div>
    </div>
</div>