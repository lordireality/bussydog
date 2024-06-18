@extends('templates.PageCoreWiki',['def_popups'=>['wiki.popup.createChildStructurePopup']])

@php 
    
    function buildStructureTree($data, $parentId = null, $parentcount = 1)
    {
        $result = '';
        foreach ($data as $row) {
            if ($row->parent == $parentId) {
                if($row){;
                    $result .= '<h3><a style="box-shadow:none;" class="button2" href="javascript:DeleteStructure('.$row->id.')"><p class="icon-button xmark"></p></a><a style="box-shadow:none;" class="button2" href="javascript:EditStructure('.$row->id.')"><p class="icon-button pen"></p></a><a style="box-shadow:none;" class="button2" href="javascript:CreateChild('.$row->id.')"><p class="icon-button plus"></p></a>'.str_repeat('-',$parentcount).$row->name.'</h3>';
                    $result .= buildStructureTree($data, $row->id, $parentcount+1);
                } 
                
            }
        }       
        return $result;
    }

@endphp

@section('pagename', 'wiki-Редактирование структуры')



@section('content')
<div class="panel">
    <h3>Редактирование структуры</h3>
</div>
<div style="color:black; text-align:left;">
    <h3><a style="box-shadow:none;" class="button2" href="javascript:CreateChild(0)"><p class="icon-button plus"></p></a>Корень</h3>
    {!!buildStructureTree($structure,null)!!}
</div>


<script>

function EditStructure(id){

}

function DeleteStructure(id){
    try{
        let params = [
        {
            "key" : "id",
            "value" : id
        }
        ];
        var responseRaw = BussyDog.Rest.HTTPPost(window.location.origin+'/api/Wiki/DeleteStructure',params,false);
        response = JSON.parse(responseRaw);
        if(response.status == 200){
            document.location.reload(true); 
        } else {
            console.log(response.message);
        }
    }
    catch(err) {
        //document.location.href = window.location.origin+"/error?stacktrace="+err;
    }
}

function CreateChild(id){
    document.getElementById("createChildStructure_popup").style="display:block";
    document.getElementById("popupBlocker").style="display:block";
    document.getElementById('newStructureParent').value = id;
}



</script>

@endsection