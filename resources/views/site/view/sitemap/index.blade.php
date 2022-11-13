<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <sitemap>
        <loc>{{route('sitemap.all')}}</loc>
        <lastmod>{{ $blog->created_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
    </sitemap>

    <sitemap>
        <loc>{{route('sitemap.blogs')}}</loc>
        <lastmod>{{ $blog->created_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
    </sitemap>

    <sitemap>
        <loc>{{route('sitemap.courses')}}</loc>
        <lastmod>{{ $course->created_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
    </sitemap>

    <sitemap>
        <loc>{{route('sitemap.services')}}</loc>
        <lastmod>{{ $service->created_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
    </sitemap>

    <sitemap>
        <loc>{{route('sitemap.portfolios')}}</loc>
        <lastmod>{{ $portfolio->created_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
    </sitemap>



</sitemapindex>
