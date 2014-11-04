$(document).ready(function() {
    
    loadSpecificTeamInfo();

    if (parseInt(sessionStorage.getItem('userID')) != 1 && sessionStorage.getItem('userID') != null) {
        $('#navLoginForm').hide();
        $('#createAccount').hide();
        $('#loginInformation').show();
        $('#loginInformation').text("Welcome, " + sessionStorage.getItem("firstName") + "!");
        $('#logout').text("Logout").show();
        $('#mySports').show();
        if(parseInt(sessionStorage.getItem('isAdmin')) == 1) {
            $('#adminPortal').show();
        }

    } else {
        $('#adminPortal').hide();
    }

});

 function get(name){
   if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
      return decodeURIComponent(name[1]);
}

function loadSpecificTeamInfo() {

    console.log(get('team'));
    document.getElementById('intro').textContent = "Team " + get('team');
        
    $.getJSON('api/getTeamRoster/' + get('team') , function(roster) {

        console.log(roster);

        if (roster.length == 0) {
            alert("DEVLOG: This team has no players");
        } else {
            var listContainer = document.getElementById('playerList');

            var playerList = document.createElement('ul');
            // playerList.className = "noFanciness";

            listContainer.appendChild(playerList);

            for (var key in roster) {
                var player = document.createElement('li');
                player.textContent = roster[key].fname + " " + roster[key].lname;
                playerList.appendChild(player);
            }
        }


    });

    
}

function initializeTable() {





//     var table = document.createElement('table');
// for (var i = 1; i < 4; i++){
//     var tr = document.createElement('tr');   

//     var td1 = document.createElement('td');
//     var td2 = document.createElement('td');

//     var text1 = document.createTextNode(sessionStorage.getItem('firstName'));
//     var text2 = document.createTextNode('Text2');

//     td1.appendChild(text1);
//     td2.appendChild(text2);
//     tr.appendChild(td1);
//     tr.appendChild(td2);

//     table.appendChild(tr);
// }
// document.body.appendChild(table);
}

