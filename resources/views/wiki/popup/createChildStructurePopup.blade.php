<div class="popup" id="createChildStructure_popup">
    <div style="width:100%">
        <h3 class="popupHeader" style="float:left; margin: 15px;">Создать дочернюю структуру</h3>
        <a class="button1 popupHeader" style="float:right" href="javascript:BussyDog.Popup.thisPopupClose('createChildStructure_popup')">X</a>
    </div>
    <hr>
    <div id="popupContent" style="text-align:left; padding:5px;">
        <b>Наименование:</b>
        <input type="text" id="newStructureName" style="width:50%; padding:10px; display:inline-block;">
        <input type="text" id="newStructureParent" hidden>
    </div>
    <hr>
    <div class="popupButtons" style="text-align:right">
        <a class="button2" href="javascript:CreateStructure()">Установить</a>       
        <a class="button2" href="javascript:BussyDog.Popup.thisPopupClose('createChildStructure_popup')">Отмена</a>
    </div>
</div>

<script>
function CreateStructure(){
    try{
        let params = [
        {
            "key" : "name",
            "value" : document.getElementById('newStructureName').value
        },
        {
            "key" : "parent",
            "value" : document.getElementById('newStructureParent').value
        }
        ];
        var responseRaw = BussyDog.Rest.HTTPPost(window.location.origin+'/api/Wiki/CreateStructure',params,false);
        response = JSON.parse(responseRaw);
        if(response.status == 200){
            document.location.reload(true); 
        } else {
            console.log(response.message);
        }
    }
    catch(err) {
        document.location.href = window.location.origin+"/error?stacktrace="+err;
    }
}

</script>