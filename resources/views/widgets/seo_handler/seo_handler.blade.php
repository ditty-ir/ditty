@if (!empty($items))
    @if ($items['title'])
    <title>{{ $items['title'] }}</title>
    @else
    <title>{{ config('app.name') }}</title>
@endif
@if ($items['canonical'])
    <link rel="canonical" href="{!! $items['canonical'] !!}" />
@endif

@foreach ($items['meta'] as $meta)
    <meta {!! $meta['attribute_title'] !!}="{!! $meta['attribute_value'] !!}" content="{!! $meta['content'] !!}">
@endforeach

@endif