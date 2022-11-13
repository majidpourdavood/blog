<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <!-- created with Free Online Sitemap Generator www.xml-sitemaps.com -->


    @foreach ($blogs as $blog)

        <url>
            <loc>{{url('/')}}{{ '/blog/'. $blog->slug}}</loc>
            <lastmod>{{ $blog->created_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
        </url>

    @endforeach

</urlset>
