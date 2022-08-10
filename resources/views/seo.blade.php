<title>{{ SEO::metaTitle() }}</title>
<meta name="description" content="{{ SEO::metaDescription() }}" />

@if($updatedAt = SEO::updatedAt())
	<meta property="article:modified_time" content="{{ $updatedAt }}" />
@endif

@stack('canonical')

{{--
Optional attributes example
<meta property="article:publisher" content="https://www.facebook.com/YourBrand/" />
--}}

<meta property="og:type" content="website" />
<meta property="og:locale" content="{{ SEO::locale() }}" />
<meta property="og:site_name" content="{{ config('statamic-seo.site_name') }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ SEO::ogTitle() }}" />
<meta property="og:description" content="{{ SEO::ogDescription() }}" />

@if($ogImage = SEO::ogImage())
	@foreach (Statamic::tag('glide:generate')->src($ogImage)->width(1200)->height(627)->fit('crop_focal')->fm('jpg') as $image)
		<meta property="og:image" content="{!! url($image['url']) !!}" />
		<meta property="og:image:width" content="1200" />
		<meta property="og:image:height" content="627" />
	@endforeach
@endif
