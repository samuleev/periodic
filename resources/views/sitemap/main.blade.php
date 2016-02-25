<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($sitemaps as $sitemap)
    <sitemap>
        <loc>http://www.hups.mil.gov.ua/periodic-app/{{{$sitemap}}}</loc>
        <lastmod>{{{$last_mod_date}}}</lastmod>
    </sitemap>
@endforeach
</sitemapindex>
