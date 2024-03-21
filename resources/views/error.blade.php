@php
    $starttime = microtime(true); 
    if(!isset($pagename)){
        $pagename = 'Произошла ошибка!';
    }
@endphp
<!doctype html>
<html>
	<head>
		<title>{{$pagename}}|ESE-CRM</title>
		<link rel="icon" href="{{ asset('/ese/content/images/favicon.ico') }}" type="image/x-icon">
		<meta name="description" content="BussyDog Leightweight OpenSource System"> 
		<meta charset="utf-8">
        <link rel="stylesheet" href="{{ asset('/content/css/mainstyle.css') }}">
        <link rel="stylesheet" href="{{ asset('/content/css/theme-blue.css') }}">
	</head>
	<body>
        <header>
            <div class="menu">
                <a href="/" class="logo"><h1 style="display: inline;">{{config('app.name')}}</h1><img style="height:2em; width:2em; vertical-align:baseline;" src="{{ asset('/content/images/eseapplogotransparent.png') }}"/></a>
            </div>
        </header>
        <section class="bodysection">
        <div class="panel"><h1>Произошла ошибка!</h1>
        <h3>Передайте текст ошибки приведенный ниже вашему администратору.</h3>
        </div>
        <br>
        <div class="panel">
        {!! isset($stacktrace) ? $stacktrace : '' !!}
        </div>
        <hr>
        
        </section>
        <footer>
        <hr>
        <i style="text-align:right">
            @php
            $endtime = microtime(true);
            @printf("%s v.%s - Страница загружена за %f секунд",config('app.name'), config('app.ver') ,$endtime - $starttime );
            @endphp
        </i>
        </footer>
	</body>
</html>