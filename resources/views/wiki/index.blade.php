@extends('templates.PageCoreWiki')


@section('pagename', 'wiki-Главная')

@section('content')
<div class="panel"><h1>База знаний - {{config('app.organizationname')}}</h1></div>
<?php include_once(resource_path()."/UIStaticPagesAssembly/wiki.php") ?>
<div class="panel"><h1>Поиск:</h1></div>
<input type="text" id="search" style="width:98%; padding:10px;margin:0;">
<div id="searchResults" style="text-align:left;">

</div>
<script>
    //find input
    document.getElementById('search').addEventListener("keyup", function (evt) {
        SearchArticle(this.value);
    }, false);



    function SearchArticle(query){
        var articleViewAddr = '{{route('wiki-article',['articleid'=>122334455])}}'.replace("122334455", '%id%'); //Костыль для построения роутинга
        var placeholder = document.getElementById("searchResults");
        placeholder.innerHTML = null;
        
        try{
            var xhr = new XMLHttpRequest();
            xhr.open("GET", window.location.origin+'/api/Wiki/Search?query='+query, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if(this.readyState === XMLHttpRequest.DONE){ 
                    placeholder.innerHTML = null; //Костыль если много запросов ушло на сервер
                    var resp = xhr.responseText;
                    var jsonOBJ = JSON.parse(resp);                  
                    for(var i in jsonOBJ){
                        placeholder.innerHTML += '<a href="'+articleViewAddr.replace('%id%',jsonOBJ[i].id)+'"><h3 style="color:black;">'+jsonOBJ[i].name+'</h3></a><hr>'
                    }        
                }
            }
            xhr.send();
        }
        catch(err) {
            document.location.href = window.location.origin+"/error?stacktrace="+err;
        }
    }
</script>
@endsection