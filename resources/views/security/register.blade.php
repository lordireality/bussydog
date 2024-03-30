<!doctype html>
<html class="welcome">
	<head>
		<title>Регистрация|{!!config('app.name')!!}</title>
		<link rel="icon" href="{{ asset('/content/images/favicon.ico') }}" type="image/x-icon">
		<meta name="description" content="BussyDog Leightweight OpenSource System"> 
		<meta charset="utf-8">
        <link rel="stylesheet" href="{{ asset('/content/css/mainstyle.css') }}">
        <script src="{{ asset('/content/js/register.js') }}"></script>
	</head>
	<body>
        <div class="bodysection">
            <div class="loginBox" style="top: 15% !important;">
                <img style="height:25%; width:25%; vertical-align:baseline;" src="{{ asset('/content/images/eseapplogotransparent.png') }}"/>
                <br>
                <h1>{!!config('app.name')!!} Регистрация</h1>
                 <table style="text-align:left;"class="formTable">
                    <tr>
                         <td><h3><b style="color:red;">*</b>Логин:</h3></td>
                         <td><input type="text" id="loginField"></td>
                    </tr>
                     <tr>
                         <td><h3><b style="color:red;">*</b>Эл. почта:</h3></td>
                         <td><input type="email" id="emailField"></td>
                    </tr>
                    <tr>
                        <td><h3><b style="color:red;">*</b>Пароль:</h3></td>
                        <td><input type="password" id="password1Field"></td>
                    </tr>
                    <tr>
                        <td><h3><b style="color:red;">*</b>Повторите пароль:</h3></td>
                        <td><input type="password" id="password2Field"></td>
                    </tr>
                    <tr>
                        <td><h3><b style="color:red;">*</b>Фамилия:</h3></td>
                        <td><input type="text" id="lastnameField"></td>
                    </tr>
                    <tr>
                        <td><h3><b style="color:red;">*</b>Имя:</h3></td>
                        <td><input type="text" id="firstnameField"></td>
                    </tr>
                    <tr>
                        <td><h3>Отчество:</h3></td>
                        <td><input type="text" id="middlenameField"></td>
                    </tr>

                </table>
                <a class="button2" href="javascript:Register()">Зарегистрироваться</a>
                <br>
                <b>Уже есть профиль?</b>
                <a class="button2" href="{{route('LogOnPage')}}">Авторизоваться</a>
                <hr>
                <p>{!!config('app.name')!!} v.{!!config('app.ver')!!}</p>
            </div>
           
        </div>
	</body>
</html>