function thisPopupClose(popupid){
    document.getElementById(popupid).style="display:none";
    document.getElementById(popupid+"_blocker").style="display:none";
}
/* -------------------------USERS------------------------------------------------------------ */
//Вывод popup окна с информацией о пользователе
function userInfoPopup(userid, popupid){
    document.getElementById(popupid+"_PhotoContainer").src = getProfilePhotoPath(userid);
    var userData = JSON.parse(HTTPGet(window.location.origin+'/api/ESE/USERS/UserInfo?id='+userid));
    document.getElementById(popupid+"_UserInfo_FullName").innerHTML = userData.lastname + " " + userData.firstname + " " + userData.middlename;
    document.getElementById(popupid+"_UserInfo_Position").innerHTML = "Должность: "+(userData.Position != null ? userData.Position : "");
    document.getElementById(popupid+"_UserInfo_Email").innerHTML = 'Эл. почта: '+(userData.email != null ? '<a href="mailto:'+userData.email+'">'+userData.email+'</a>' : '');
    document.getElementById(popupid+"_UserInfo_Description").innerHTML = userData.description;
    //Включаем отображение popup окна
    document.getElementById(popupid).style="display:block";
    document.getElementById(popupid+"_blocker").style="display:block";
}


/*---------------------------TASKS------------------------------------------------------------*/
//Показ попапа с комментом
function AddCommentTaskPopup(popupid, taskId){
    document.getElementById(popupid).style="display:block";
    document.getElementById(popupid+"_blocker").style="display:block";
}

//Добавления коммента к задаче из попапа
async function AddCommentTask(popupid, taskId){
    var textValue = document.getElementById(popupid+'_CommentText').value;
    var file = document.getElementById(popupid+'_CommentAttach').files[0];
    let params = {};
    if(file != null){
        let base64filedata = await new Promise((resolve) => {
            let fileReader = new FileReader();
            fileReader.onload = (e) => resolve(fileReader.result);
            fileReader.readAsDataURL(file);
        });
        params = {
            text: textValue,
            task: taskId,
            file_base64: base64filedata,
            file_name: file.name,
            file_type: file.type
        }
    } else {
        params = {
            text: textValue,
            task: taskId
        }
    }
    var responseRaw = HTTPPostFormData(window.location.origin+'/api/ESE/TASKS/AddComment',params,false);
    response = JSON.parse(responseRaw);
    if(response.status == 200){
        document.location.reload(true);    
    } else {
        console.log(response.message);
    }
}

function CreateTaskPopup(popupid){
    document.getElementById(popupid+"_TaskExecutor").innerHTML = "";
    var users = JSON.parse(HTTPGet(window.location.origin+'/api/ESE/USERS/AllUsers'));
    for(var i=0; i< users.length; i++){
        document.getElementById(popupid+"_TaskExecutor").add(new Option(users[i].lastname + " " + users[i].firstname + " " + " " + users[i].middlename + "("+users[i].Position+")",users[i].id));
    }


    document.getElementById(popupid).style="display:block";
    document.getElementById(popupid+"_blocker").style="display:block";
}
function CreateTask(popupid){
    var taskName = document.getElementById(popupid+"_TaskName").value;
    var taskDescription = document.getElementById(popupid+"_TaskDescription").value;
    var taskExecutorId = document.getElementById(popupid+"_TaskExecutor").value;
    var taskDeadline = document.getElementById(popupid+"_TaskDeadline").value;
    let params = [
        {
            "key" : "taskName",
            "value" : taskName
        },
        {
            "key" : "taskDescription",
            "value" : taskDescription
        },
        {
            "key" : "taskExecutorId",
            "value" : taskExecutorId
        },
        {
            "key" : "taskDeadline",
            "value" : taskDeadline
        }
    ];
    var responseRaw = HTTPPost(window.location.origin+'/api/ESE/TASKS/CreateTask',params,false);
    response = JSON.parse(responseRaw);
    if(response.status == 200){
        window.location.href = window.location.origin+'/Task/'+response.taskId;
    } else {
        console.log(response.message);
    }
}
//
function CreateSubTaskPopup(popupid, taskid){
    document.getElementById(popupid+"_TaskExecutor").innerHTML = "";
    document.getElementById(popupid+"_ParentTaskId").value = taskid;
    var users = JSON.parse(HTTPGet(window.location.origin+'/api/ESE/USERS/AllUsers'));
    for(var i=0; i< users.length; i++){
        document.getElementById(popupid+"_TaskExecutor").add(new Option(users[i].lastname + " " + users[i].firstname + " " + " " + users[i].middlename + "("+users[i].Position+")",users[i].id));
    }


    document.getElementById(popupid).style="display:block";
    document.getElementById(popupid+"_blocker").style="display:block";
}
function CreateSubTask(popupid){
    var taskName = document.getElementById(popupid+"_TaskName").value;
    var taskDescription = document.getElementById(popupid+"_TaskDescription").value;
    var taskExecutorId = document.getElementById(popupid+"_TaskExecutor").value;
    var taskDeadline = document.getElementById(popupid+"_TaskDeadline").value;
    var parentTaskId = document.getElementById(popupid+"_ParentTaskId").value;
    let params = [
        {
            "key" : "taskName",
            "value" : taskName
        },
        {
            "key" : "taskDescription",
            "value" : taskDescription
        },
        {
            "key" : "taskExecutorId",
            "value" : taskExecutorId
        },
        {
            "key" : "taskDeadline",
            "value" : taskDeadline
        },
        {
            "key" : "parentTaskId",
            "value" : parentTaskId
        }
    ];
    var responseRaw = HTTPPost(window.location.origin+'/api/ESE/TASKS/CreateSubTask',params,false);
    response = JSON.parse(responseRaw);
    if(response.status == 200){
        window.location.href = window.location.origin+'/Task/'+response.taskId;
    } else {
        console.log(response.message);
    }
}

//



function ChangeTaskExecutorPopup(popupid){
    document.getElementById(popupid+"_TaskExecutor").innerHTML = "";
    var users = JSON.parse(HTTPGet(window.location.origin+'/api/ESE/USERS/AllUsers'));
    for(var i=0; i< users.length; i++){
        var a = new Option(users[i].lastname,users[i].id);
        document.getElementById(popupid+"_TaskExecutor").add(new Option(users[i].lastname + " " + users[i].firstname + " " + " " + users[i].middlename + "("+users[i].Position+")",users[i].id));
    }


    document.getElementById(popupid).style="display:block";
    document.getElementById(popupid+"_blocker").style="display:block";
}
function ChangeTaskExecutor(popupid, taskId){
    var taskExecutorId = document.getElementById(popupid+"_TaskExecutor").value;
    let params = [
        {
            "key" : "task",
            "value" : taskId
        },
        {
            "key" : "newExecutor",
            "value" : taskExecutorId
        }
    ];
    var responseRaw = HTTPPost(window.location.origin+'/api/ESE/TASKS/ChangeExecutor',params,false);
    response = JSON.parse(responseRaw);
    if(response.status == 200){
        document.location.reload(true); 
    } else {
        console.log(response.message);
    }
}

function ChangeStatusPopup(popupid, taskId){
    document.getElementById(popupid).style="display:block";
    document.getElementById(popupid+"_blocker").style="display:block";
}

//Добавления коммента к задаче из попапа
function CloseTask(popupid, taskId){
    let params = [
        {
            "key" : "task",
            "value" : taskId
        }
    ];
    var responseRaw = HTTPPost(window.location.origin+'/api/ESE/TASKS/CloseTask',params,false);
    response = JSON.parse(responseRaw);
    if(response.status == 200){
        document.location.reload(true);    
    } else {
        console.log(response.message);
    }
}

//Добавления коммента к задаче из попапа
function ReopenTask(popupid, taskId){
    let params = [
        {
            "key" : "task",
            "value" : taskId
        }
    ];
    var responseRaw = HTTPPost(window.location.origin+'/api/ESE/TASKS/ReopenTask',params,false);
    response = JSON.parse(responseRaw);
    if(response.status == 200){
        document.location.reload(true);    
    } else {
        console.log(response.message);
    }
}


/*----------------------------------Widgets----------------------------------------------------------------*/
function SetWidgetPopup(popupid,zoneNum){
    document.getElementById(popupid+"_widget").innerHTML = "";
    document.getElementById(popupid+"_zoneNum").value = zoneNum;
    var widgets = JSON.parse(HTTPGet(window.location.origin+'/api/ESE/Widgets/GetAllWidgets')).widgets;
    for(var i=0; i< widgets.length; i++){
        document.getElementById(popupid+"_widget").add(new Option(widgets[i].visiblename,widgets[i].id));
    }

    document.getElementById(popupid).style="display:block";
    document.getElementById(popupid+"_blocker").style="display:block";
    
}
function SetWidgetToZone(popupid){
    var zoneNum = document.getElementById(popupid+"_zoneNum").value;
    var widgetId = document.getElementById(popupid+"_widget").value;
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
    var responseRaw = HTTPPost(window.location.origin+'/api/ESE/MainPage/SetWidgetToZone',params,false);
    response = JSON.parse(responseRaw);
    if(response.status == 200){
        document.location.reload(true); 
    } else {
        console.log(response.message);
    }
}