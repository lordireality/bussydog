class BussyDogRest{
    constructor(){
        return this;
    }
    HTTPGet(URL){
        var xhr = new XMLHttpRequest(); 
        xhr.open("GET",URL,false);
        xhr.send(null);
        return xhr.responseText;          
    }
    //Post
    /*    
    Пример структуры параметров в формате key-value
    let params = [
        {
            "key" : "num",
            "value" : zoneNum
        },
        {
            "key" : "widgetId",
            "value" : widgetId
        }
    ]; 
    
    */
    HTTPPost(URL, params, isAsync){
        var xhr = new XMLHttpRequest(); 
        xhr.open("POST",URL,isAsync);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        if(isAsync==true){
            xhr.onreadystatechange = function() {
                if(this.readyState === XMLHttpRequest.DONE){ 
                    return xhr.responseText; 
                }
            }
        }
    
        paramsString = "";
        if(params.length>0){
            paramsString = params[0].key+"="+params[0].value;
            for(var i =1;i<params.length;i++){
                paramsString = paramsString + "&"+params[i].key+"="+params[i].value
            }
        }
        xhr.send(paramsString);
        if(isAsync==false){
            if(xhr.status != null){
                return xhr.responseText;
            }
        }
    }
    //Post with form data
    HTTPPostFormData(URL, params, isAsync){     
          var boundary = String(Math.random()).slice(2);
          var boundaryMiddle = '--' + boundary + '\r\n';
          var boundaryLast = '--' + boundary + '--\r\n'
          
          var body = ['\r\n'];
          for (var key in params) {
                body.push('Content-Disposition: form-data; name="' + key + '"\r\n\r\n' + params[key] + '\r\n');
          }
          
          body = body.join(boundaryMiddle) + boundaryLast;
          
          // Тело запроса готово, отправляем
          
          var xhr = new XMLHttpRequest();
          xhr.open('POST', URL, isAsync);
          
          xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
          
          if(isAsync==true){
            xhr.onreadystatechange = function() {
                if(this.readyState === XMLHttpRequest.DONE){ 
                    return xhr.responseText; 
                }
            }
          }
          
          xhr.send(body);
          if(isAsync==false){
            if(xhr.status != null){
                return xhr.responseText;
            }
        }
    }
}