function showFilterMenu() {
    let filter_menu = document.querySelector("#filter_menu");
    
    if (filter_menu.style.display === "none"){
        filter_menu.style.display = "block";
    }else{
        filter_menu.style.display = "none";
    }
}

function getLocation(){
    if (navigator.geolocation) {
        console.log('Geolocation is supported!');
    }
    else {
        console.log('Geolocation is not supported for this Browser/OS.');
    }

    let startPos;
    let errorMsg;
    let lat_lon_label = document.querySelector('#latlonlabel');
    let lat = document.querySelector('#latitude');
    let lon = document.querySelector('#longitude');
    let geoOptions = {
        timeout: 20 * 1000
    }

    lat_lon_label.innerHTML = "fetching...";


    let geoSuccess = function(position) {
        pos = position;
        lat.value = pos.coords.latitude;
        lon.value = pos.coords.longitude;
        lat_lon_label.innerHTML = "";
    };

    let geoError = function(error) {
        if (error.code === 1){
            errorMsg = "Error: Permission denied";
        }else if (error.code === 2){
            errorMsg = "Error: Position unavailable";
        }else if (error.code === 3){
            errorMsg = "Error: Timed out";
        }else {
            errorMsg = "Error: Unknown";
        }
        lat_lon_label.innerHTML = errorMsg;
    };

    if (navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions)){
        lat_lon_label.innerHTML = "";
    }
}


//AJAX

function getChatWindowAJAX(){
    setInterval(function() {
      getChatWindow();
    }, 5000);
}

function getChatWindow(){
    var username = document.querySelector('#username').value;
    if (username){
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.querySelector("#chat-window").innerHTML = this.responseText;
            }
        }
        xhttp.open("GET", "ajax.php?method=getChatWindow&username="+username, true);
        xhttp.send();
    }
}

function getSumAllUnreadMsgsAJAX(){
    setInterval(function() {
      getSumAllUnreadMsgs();
    }, 5000);
}

function getSumAllUnreadMsgs(){
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector("#sumAllUnreadChatMsgs").innerHTML = this.responseText;
        }
    }
    xhttp.open("GET", "../lib/ajax.php?method=getSumAllUnreadMsgs", true);
    xhttp.send();
}

function getSumNotificationsAJAX(){
    setInterval(function() {
      getSumNotifications();
    }, 5000);
}

function getSumNotifications(){
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector("#sumNotifications").innerHTML = this.responseText;
        }
    }
    xhttp.open("GET", "../lib/ajax.php?method=getSumNotifications", true);
    xhttp.send();
}