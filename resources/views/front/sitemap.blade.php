{!! '<' !!}?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<!-- created with Free Online Sitemap Generator www.xml-sitemaps.com -->


    <url>
        <loc>{{ env('APP_URL') }}</loc>
        <priority>1.00</priority>
    </url>

    @foreach($pages as $page)
    <url>
        <loc>{{ url('/', $page->path) }}</loc>
        <priority>0.90</priority>
    </url>
    @endforeach

    @foreach($posts as $post)
    <url>
        <loc>{{ $post->url }}</loc>
        <lastmod>{{ $post->updated_at->format('Y-m-d\TH:i:s+03:30') }}</lastmod>
        <priority>0.90</priority>
    </url>
    @endforeach

    @foreach($categories as $category)
    <url>
        <loc>{{ url('/categories') . '/' . $category->id . '/' . Str::slug($category->title, '-', null) }}</loc>
        <priority>0.80</priority>
    </url>
    @endforeach

    @foreach($authors as $author)
    <url>
        <loc>{{ url('/@' . $author->username) }}</loc>
        <priority>0.80</priority>
    </url>
    @endforeach


</urlset>