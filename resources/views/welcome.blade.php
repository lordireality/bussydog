<!doctype html>
<html class="welcome">
	<head>
		<title>Добро пожаловать!|{!!config('app.name')!!}</title>
		<link rel="icon" href="{{ asset('/content/images/favicon.ico') }}" type="image/x-icon">
		<meta name="description" content="{!!config('app.name')!!} Leightweight OpenSource BPMN CRM"> 
		<meta charset="utf-8">
        <!--mainstyle - Легаси файл содержащий некоторый набор готовых css к использованию компонентов.
        Рекомендуется преднастроить стиль и использовать его в связке с base.css
    
        -->
        <link rel="stylesheet" href="{{ asset('/content/css/mainstyle.css') }}">
	</head>
	<body>
    <div class="popupBlocker" id="authPopup_blocker"></div>
        <div class="popup" id="authPopup">
            <div style="width:100%">
                <h3 class="popupHeader" style="float:left; margin: 15px; color: #000;">Авторизация</h3>
                <a class="button1 popupHeader" style="float:right" href="javascript:HideAuthPopup()">X</a>
            </div>
            <hr>
            <div id="popupContent" style="text-align:left; padding:5px; color: #000;">
                
                <table style="text-align:left; width: 100%;"class="formTable">
                     <tr>
                         <td><h3><b style="color:red;">*</b>Эл. почта:</h3></td>
                         <td><input type="email" id="emailField" style="text-align:left; width: 100%;"></td>
                    </tr>
                    <tr>
                        <td><h3><b style="color:red;">*</b>Пароль:</h3></td>
                        <td><input type="password" id="passwordField" style="text-align:left; width: 100%;"></td>
                    </tr>
                </table>
                <div style="text-align:center; width:100%">
                <a class="button2" href="javascript:Auth()">Авторизоваться</a>
                <a class="button2" href="javascript:HideAuthPopup()">Закрыть</a>
                </div>
            </div>
            <hr>
        </div>
        <div class="bodysection">
            <hr>
            <img style="height:25%; width:25%; vertical-align:baseline;" src="{{ asset('/content/images/eseapplogotransparent.png') }}"/>
            <br>
            <h1>{!!config('app.name')!!} - "Легкая бизнес система с открытым исходным кодом"</h1>
            <h3>v. {{ config('app.ver') }}</h3>
            <hr>
            <h2>Это стартовая страница, доступная всем пользователям!</h2>
            <h3>В дальнейшем, вы сможете изменить её в разделе "Администрирование"</h3>
            <h3>Для начала использования системы, используйте логин "admin" и пароль "admin"</h3>
            <a class="button2" href="javascript:ShowAuthPopup()">Начать использование</a>

        </div>
        <script>
            //Для взаимодействия с popup Окнами, вы можете использовать библиотеку bdog_popup.js
            //Но рекомендуем изолировать основной код, от внешних пользователей
            function ShowAuthPopup(){
                document.getElementById("authPopup").style="display:block";
                document.getElementById("authPopup_blocker").style="display:block";
            }
            function HideAuthPopup(){
                document.getElementById("authPopup").style="display:none";
                document.getElementById("authPopup_blocker").style="display:none";
            }
            /*
            Метод авторизации на странице авторизации.

            Важно! Если вы хотите создать кастомную страницу или еще что-то подобное,
            проверяйте авторизованность пользователя непосредственно в контроллере,
            использовать клиентскую авторизацию или KeepAlive, может быть опасно!
            */
            function Auth(){
                var email = document.getElementById('emailField').value;
                var password = document.getElementById('passwordField').value;
                if(!email || !password){
                    alert('Не все поля заполнены!');
                    return;
                } else {
                    if(validateEmail(email)){
                        try{
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", window.location.origin+'/api/Security/Auth', true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.onreadystatechange = function() {
                                if(this.readyState === XMLHttpRequest.DONE){ 
                                    jsonData = xhr.responseText;
                                    jsonData = jsonData.replaceAll('/"','\\"');
                                    var AuthData = JSON.parse(jsonData);  
                                    if(AuthData["status"] == "200" ){
                                        document.cookie = "userid="+AuthData["userid"]+"; path=/;";
                                        document.cookie = "authtoken="+AuthData["authtoken"];+";path=/;";
                                        document.location.href = window.location.origin+"/index";
                                    } else {
                                        try{
                                            if(AuthData["message"] == "[object Object]"){
                                                alert("Неправильный формат электронной почты/пароля!");
                                            } else {
                                                alert(AuthData["message"]);
                                            }
                                        } catch (error){
                                            
                                            alert("Произошла неизвестная ошибка!");
                                        }
                                        }
                                    }
                                    
                            }
                            xhr.send("email="+email+"&password="+password);
                        }
                        catch(err) {
                            document.location.href = window.location.origin+"/error?stacktrace="+err;
                        }

                        
                    } else {
                        alert("Недопустимый формат Email");
                    }


                }
            }

            //Валидация Email
            const validateEmail = (email) => {
                return email.match(
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
            };
        </script>

	</body>
</html>

