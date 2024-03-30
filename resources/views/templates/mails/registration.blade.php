<!doctype html>
<html>
	<body style="margin: 0;">
		<div style="display: inline-block;width: 100%;height: auto; background-color: #1d6d9a; margin-bottom: 5px;">
			<div style="font-size: 200%; color: white;">{!!config('app.name')!!}</div>
		</div>
		<div style="width: 75%; margin-left:auto; margin-right:auto; background-color:#daf1ff; padding: 50px;">
				<h1>Вы успешно зарегистрировались!</h1>
				<p>Здравствуйте,{{$firstname}}! <br>Для подтверждения вашего аккаунта, пожалуйста нажмите на кнопку ниже</p>
				<a style="display: inline-block;color: white;text-decoration: none;background-color: #2689c2;padding: 8px;margin-top: 10px;margin-bottom: 10px;background-clip: border-box;background-repeat: no-repeat;background-position: center center;box-shadow: 5px 5px 15px 0px rgba(0,0,0,0.75);}" href="{!!config('app.url')!!}/verify-account?email={{$email}}&verificationToken={{$verificationToken}}">Подтвердить!</a>
				<hr>
				<p>Если по какой-то причине у вас не получается пройти по ссылке, вы можете пройти по ней вручную<br>{!!config('app.url')!!}/verify-account?email={{$email}}&verificationToken={{$verificationToken}}</p>
				
		</div>
	</body>
</html>