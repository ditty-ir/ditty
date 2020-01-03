@php echo '<?xml version="1.0" encoding="UTF-8" ?>' @endphp

<rss version="2.0">
  <channel>
		<title>{{ config('app.name') }}</title>
		<link>{{ config('app.url') }}</link>
		<description>{{ config('app.description') }}</description>
		@foreach ($posts as $post)
		<item>
			<title>{{ $post->title }}</title>
            <link>{{ $post->url}}</link>
			<pubDate>{{ $post->updated_at }}</pubDate>
			<description><![CDATA[{{ $post->brief_text }}<br><br><img src="{{ url($post->cover_image) }}"> ]]></description>
		</item>
		@endforeach
	</channel>
</rss>