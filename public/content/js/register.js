function Register(){
    var login = document.getElementById('loginField').value;
    var email = document.getElementById('emailField').value;
    var password1 = document.getElementById('password1Field').value;
    var password2 = document.getElementById('password2Field').value;
    var lastname = document.getElementById('lastnameField').value;
    var firstname = document.getElementById('firstnameField').value;
    var midddlename = document.getElementById('middlenameField').value;

    if(!login){
        alert("Не заполнено поле \"Логин\"");
        return;
    }
    if(!email){
        alert("Не заполнено поле \"Эл. почта\"");
        return;
    }
    if(!password1){
        alert("Не заполнено поле \"Пароль\"");
        return;
    }
    if(!password2){
        alert("Не заполнено поле \"Пароль\"");
        return;
    }
    if(!lastname){
        alert("Не заполнено поле \"Фамилия\"");
        return;
    }
    if(!firstname){
        alert("Не заполнено поле \"Имя\"");
        return;
    }
    if(password1 != password2){
        alert("Введенные пароли не совпадают");
        return;
    }
    if(!validateEmail(email)){
        alert("Недопустимый формат Email");
        return;
    }
    try{
        var xhr = new XMLHttpRequest();
        xhr.open("POST", window.location.origin+'/api/Security/Register', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if(this.readyState === XMLHttpRequest.DONE){ 
                jsonData = xhr.responseText;
                jsonData = jsonData.replaceAll('/"','\\"');
                var AuthData = JSON.parse(jsonData);  
                if(AuthData["status"] == "200"){
                    if(AuthData["approveRequired"] == "false"){
                        alert("Вы успешно зарегистрировались!");
                        document.cookie = "userid="+AuthData["userid"]+"; path=/;";
                        document.cookie = "authtoken="+AuthData["authtoken"];+";path=/;";
                        document.location.href = window.location.origin+"/index";
                    } else {
                        alert("Необходимо подтверждение эл. почты. Проверьте указанный почтовый ящик.");
                    }
                } 
                else {
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

        xhr.send("login="+login+"&email="+email+"&password="+password1+"&lastname="+lastname+"&firstname="+firstname+"&middlename="+midddlename);
    }
    catch(err) {
        document.location.href = window.location.origin+"/error?stacktrace="+err;
    }


}

//Валидация Email
const validateEmail = (email) => {
    return email.match(
    /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};