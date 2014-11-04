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

    $.getJSON('api/getTeamCaptain/' + get('team'), function(captain) {
        console.log(captain);
    });

    $.getJSON('api/getTeamInfo/' + get('team'), function(info) {
        console.log(info);
    });
}

