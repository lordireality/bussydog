@extends('templates.PageCoreWiki')


@section('pagename', 'wiki-Редактор')

@php 
    
    function buildOptionTree($data, $parentId = null, $parentcount = 1,$articleParentId)
    {
        $result = '';
        foreach ($data as $row) {
            if ($row->parent == $parentId) {
                if($row){;
                    $result .= '<option '.($row->id == $articleParentId ? 'selected' : '').' value="'.$row->id.'">'.str_repeat('-',$parentcount).$row->name.'</option>';
                    $result .= buildOptionTree($data, $row->id, $parentcount+1, $articleParentId);
                } 
                
            }
        }       
        return $result;
    }

@endphp


@section('content')
<div class="panel"><h1>Редактирование - <input type="text" id="name" style="width:25%; padding:10px;" value="{{$article->name}}"></h1>
<a class="button2" href="javascript:Preview()">Предпросмотр</a>
<a class="button2" href="javascript:Save()">Сохранить</a>

<select id="structure" style="width:25%; padding:10px;">
    <option value="null">/Корень/</option>
    {!!buildOptionTree($structure,null,1,$article->parent)!!}
</select>
</div>
<div id="editArticle" style="text-align:left">
    <div class="panel">
        <h3>Редактор</h3>
    </div>
    <textarea id="editArticleSource" hidden>{!!$article->content!!}</textarea>
    <div class="editor" id="articleEditor"></div>
</div>
<div id="previewArticle" hidden>
    <div class="panel">
        <h3>Предпросмотр</h3>
    </div>
    <div id="previewPlaceholder" style="all: initial;">

    </div>
</div>

<script>var require = { paths: { 'vs': '{{ asset('/content/monaco-editor/min/vs/') }}' } };</script>
<script src="{{ asset('/content/monaco-editor/min/vs/loader.js') }}"></script>
<script src="{{ asset('/content/monaco-editor/min/vs/editor/editor.main.nls.js') }}"></script>
<script src="{{ asset('/content/monaco-editor/min/vs/editor/editor.main.js') }}"></script>
<link rel="stylesheet" data-name="vs/editor/editor.main" href="{{ asset('/content/monaco-editor/min/vs/editor/editor.main.css') }}">
<script>
var viewEditor = monaco.editor.create(document.getElementById('articleEditor'), {
    value: document.getElementById('editArticleSource').value,
    language: 'php',
    fontSize: 16
});

var isPreview = false;

function Preview(){
    isPreview = !isPreview;
    document.getElementById("previewPlaceholder").innerHTML = "";
    
    if(isPreview){
        document.getElementById("previewPlaceholder").innerHTML = viewEditor.getValue();
    } 
    document.getElementById("editArticle").hidden = isPreview;
    document.getElementById("previewArticle").hidden = !isPreview;
}

var articleViewAddr = '{{route('wiki-article',['articleid'=>122334455])}}'.replace("122334455", '%id%');

function Save(){
    
    try{
        var xhr = new XMLHttpRequest();
        xhr.open("POST", window.location.origin+'/api/Wiki/SaveArticle', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if(this.readyState === XMLHttpRequest.DONE){ 
                jsonData = xhr.responseText.replaceAll('/"','\\"');
                var SaveData = JSON.parse(jsonData);  
                if(SaveData["status"] == "200" ){
                    if(SaveData["state"]== "update"){
                        location.reload();
                    } else {
                        document.location.href = articleViewAddr.replace('%id%',SaveData["id"]);
                        
                    }
                    
                } else {
                    try{
                        if(AuthData["message"] == "[object Object]"){
                            alert("Произошла ошибка валидации!");
                        } else {
                            alert(AuthData["message"]);
                        }
                    } catch (error){
                        
                        alert("Произошла неизвестная ошибка!");
                    }
                }
            }
        }
        xhr.send("id={{$article->id}}&name="+document.getElementById('name').value+"&parent="+document.getElementById('structure').value+"&content="+viewEditor.getValue());
    }
    catch(err) {
        document.location.href = window.location.origin+"/error?stacktrace="+err;
    }
}

</script>
@endsection