<title>{{ $metaTitle }}</title>
@if(strlen($metaDescription))
<meta name="description" content="{{ $metaDescription }}" />
@endif
@if(isset($date))
	<meta property="article:published_time" content="{{ $date->toW3cString() }}" />
@endif
@if(isset($updatedAt))
	<meta property="article:modified_time" content="{{ $updatedAt->toW3cString() }}" />
@endif
@if($noIndex)
	<meta name="robots" content="noindex, nofollow">
@endif
@stack('canonical')
<meta property="og:type" content="website" />
<meta property="og:locale" content="{{ $locale }}" />
<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ $ogTitle }}" />
<meta property="og:description" content="{{ $ogDescription }}" />
{{--meta property="article:publisher" content="https://www.facebook.com/YourBrand/" />--}}
@if(isset($ogImage))
	@foreach (Statamic::tag('glide:generate')->src($ogImage)->width(1200)->height(627)->fit('crop_focal')->fm('jpg') as $image)
		<meta property="og:image" content="{!! url($image['url']) !!}" />
		<meta property="og:image:width" content="1200" />
		<meta property="og:image:height" content="627" />
	@endforeach
@endif
