@php($seo_data = seo_data($page))

<title>{{ get_meta_title($seo_data) }}</title>
<meta name="description" content="{{ get_meta_description($seo_data) }}" />

@if(isset($page->updated_at))
	<meta property="article:modified_time" content="{{ $page->updated_at->toIso8601String() }}" />
@endif

@stack('canonical')

<meta property="article:publisher" content="https://www.facebook.com/CamileThai/" />
<meta property="og:type" content="website" />
<meta property="og:locale" content="{{ $site->locale }}" />
<meta property="og:site_name" content="{{ config('seo.site_name') }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ get_og_title($seo_data) }}" />
<meta property="og:description" content="{{ get_og_description($seo_data) }}" />

@foreach (Statamic::tag('glide:generate')->src(get_og_image($seo_data))->width(1200)->height(627)->fit('crop_focal')->fm('jpg') as $image)
	<meta property="og:image" content="{!! url($image['url']) !!}" />
	<meta property="og:image:width" content="1200" />
	<meta property="og:image:height" content="627" />
@endforeach
