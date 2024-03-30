<!doctype html>
<html class="welcome">
	<head>
		<title>Учетная запись подтверждена|{!!config('app.name')!!}</title>
		<link rel="icon" href="{{ asset('/content/images/favicon.ico') }}" type="image/x-icon">
		<meta name="description" content="BussyDog Leightweight OpenSource System"> 
		<meta charset="utf-8">
        <link rel="stylesheet" href="{{ asset('/content/css/mainstyle.css') }}">
	</head>
	<body>
        <div class="bodysection">
            <div class="loginBox">
                <img style="height:25%; width:25%; vertical-align:baseline;" src="{{ asset('/content/images/eseapplogotransparent.png') }}"/>
                <br>
                <h1>{!!config('app.name')!!}</h1>
                <h1>Учетная запись успешно подтверждена!</h1>
                <a class="button2" href="{{route('LogOnPage')}}">Авторизоваться</a>                
                <hr>
                <p>{!!config('app.name')!!} v.{!!config('app.ver')!!}</p>
            </div>
           
        </div>
	</body>
</html>