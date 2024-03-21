function LogOut(){
    document.cookie = "email=; path=/;";
    document.cookie = "authtoken=; path=/;";
    document.location.href = window.location.origin+"/login";
}