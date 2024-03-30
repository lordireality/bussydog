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