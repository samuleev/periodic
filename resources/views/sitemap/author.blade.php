<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($authors as $author)
        <url>
            <loc>http://www.hups.mil.gov.ua/periodic-app/author/{{{$author->author_id}}}</loc>
            <lastmod>{{{str_replace(' ', 'T', $author->updated) . "+00:00"}}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>