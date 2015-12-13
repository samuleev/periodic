@foreach($sitemaps as $sitemap)
    <sitemap>
        <loc>http://www.hups.mil.gov.ua/periodic-app/{{{$sitemap}}}</loc>
        <lastmod>{{{$last_mod_date}}}</lastmod>
    </sitemap>
@endforeach
