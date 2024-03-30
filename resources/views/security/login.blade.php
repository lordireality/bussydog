<!doctype html>
<html class="welcome">
	<head>
		<title>Авторизация|{!!config('app.name')!!}</title>
		<link rel="icon" href="{{ asset('/content/images/favicon.ico') }}" type="image/x-icon">
		<meta name="description" content="BussyDog Leightweight OpenSource System"> 
		<meta charset="utf-8">
        <link rel="stylesheet" href="{{ asset('/content/css/mainstyle.css') }}">
        <script src="{{ asset('/content/js/auth.js') }}"></script>
	</head>
	<body>
        <div class="bodysection">
            <div class="loginBox">
                <img style="height:25%; width:25%; vertical-align:baseline;" src="{{ asset('/content/images/eseapplogotransparent.png') }}"/>
                <br>
                <h1>{!!config('app.name')!!} Авторизация</h1>
                 <table style="text-align:left;"class="formTable">
                     <tr>
                         <td><h3><b style="color:red;">*</b>Эл. почта:</h3></td>
                         <td><input type="email" id="emailField"></td>
                    </tr>
                    <tr>
                        <td><h3><b style="color:red;">*</b>Пароль:</h3></td>
                        <td><input type="password" id="passwordField"></td>
                    </tr>
                </table>
                <a class="button2" href="javascript:Auth()">Авторизоваться</a>
                @if(config('app.registration') == true)
                <a class="button2" href="{{route('register')}}">Зарегистрироваться</a>
                @endif
                
                <hr>
                <p>{!!config('app.name')!!} v.{!!config('app.ver')!!}</p>
            </div>
           
        </div>
	</body>
</html>