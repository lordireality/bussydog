class BussyDogPopup{
    constructor(){
        return this;
    }
    thisPopupClose(popupid){
        document.getElementById(popupid).style="display:none";
        document.getElementById("popupBlocker").style="display:none";
    }


}
