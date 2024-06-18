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
</div>
<div id="previewArticle" hidden>
    <div class="panel">
        <h3>Предпросмотр</h3>
    </div>
    <div id="previewPlaceholder" style="all: initial;">

    </div>
</div>

<script src=" {{ asset('/content/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
tinymce.init({
  selector: 'textarea#editArticleSource',
  plugins: [
    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
    'insertdatetime', 'media', 'table',
  ],
  toolbar: 'undo redo | blocks | ' +
  'bold italic backcolor | alignleft aligncenter ' +
  'alignright alignjustify | bullist numlist outdent indent | ' +
  'removeformat | help',
  height: 500,
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
  promotion: false,
  language: 'ru'
});

var isPreview = false;

function Preview(){
    isPreview = !isPreview;
    document.getElementById("previewPlaceholder").innerHTML = "";
    
    if(isPreview){
        document.getElementById("previewPlaceholder").innerHTML = tinymce.get("editArticleSource").getContent();

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
        xhr.send("id={{$article->id}}&name="+document.getElementById('name').value+"&parent="+document.getElementById('structure').value+"&content="+tinymce.get("editArticleSource").getContent());
    }
    catch(err) {
        document.location.href = window.location.origin+"/error?stacktrace="+err;
    }
}

</script>
@endsection