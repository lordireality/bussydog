class BussyDogSecurity{
    constructor(){
        return this;
    }
    LogOut(){
        var userid = this.getCookie('userid');
        var authtoken = this.getCookie('authtoken');
        if(userid && authtoken){
            try{
                var xhr = new XMLHttpRequest();
                xhr.open("POST", window.location.origin+'/api/Security/LogOut', true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if(this.readyState === XMLHttpRequest.DONE){ 
                        var resp = xhr.responseText;
                        if(resp == 1){
                            console.log("Сессия прервана");
                        }else {
                            console.log("Сессия не прервана");
                        }
                        
                        document.cookie = "userid=; path=/;";
                        document.cookie = "authtoken=; path=/;";
                        document.location.href = window.location.origin+"/login";                        
                    }
                }
                xhr.send("userid="+userid+"&authtoken="+authtoken);
            }
            catch(err) {
                document.location.href = window.location.origin+"/error?stacktrace="+err;
            }
        } else {
            console.error('Нет сессии в Cookie!');
            document.cookie = "userid=; path=/;";
            document.cookie = "authtoken=; path=/;";
            document.location.href = window.location.origin+"/login";
        }
    }

    getCookie = function(name) {
        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
    }

    Auth(){
        var email = document.getElementById('emailField').value;
        var password = document.getElementById('passwordField').value;
        if(!email || !password){
            alert('Не все поля заполнены!');
            return;
        } else {
            if(this.validateEmail(email)){
                try{
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", window.location.origin+'/api/Security/Auth', true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if(this.readyState === XMLHttpRequest.DONE){ 
                            var jsonData = xhr.responseText;
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
    Register(){
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
        if(!this.validateEmail(email)){
            alert("Недопустимый формат Email");
            return;
        }
        try{
            var xhr = new XMLHttpRequest();
            xhr.open("POST", window.location.origin+'/api/Security/Register', true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if(this.readyState === XMLHttpRequest.DONE){ 
                    var jsonData = xhr.responseText;
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
                            document.location.href = window.location.origin+"/";
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
    validateEmail = (email) => {
        return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
    };


}
