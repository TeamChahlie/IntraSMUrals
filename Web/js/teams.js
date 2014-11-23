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
    document.getElementById('teamHeader').textContent = "Team " + get('team');

    $.getJSON('api/getTeamInfo/' + get('team'), function(info) {
        console.log(info);
        document.getElementById('sportHeader').textContent = info.sportName;
    });

    $.getJSON('api/getTeamCaptain/' + get('team'), function(captain) {
        console.log(captain);
    });
        
    $.getJSON('api/getTeamRoster/' + get('team') , function(roster) {

        
        console.log(roster);

        if (roster.length == 0) {
            var noPlayers = document.createElement('p');
            noPlayers.className = "noContent"
            noPlayers.textContent = "This team has no players.";
            document.getElementById('playerList').appendChild(noPlayers);
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

    $.getJSON('api/getTeamSchedule/' + get('team'), function(games) {

        var scheduleDiv = document.getElementById('teamSchedule');

        if(games.length == 0) {
            var html = document.createElement('p');
            html.className = "noContent";
            html.textContent = "No future games scheduled.";
            scheduleDiv.appendChild(html);
        } else {

            for (var key in games) {
                var container = document.createElement('div');
                container.className = "scheduleEvent";

                scheduleDiv.appendChild(container);

                var dateDiv = document.createElement('span');
                dateDiv.className = "eventDate";
                dateDiv.textContent = games[key].date;
                container.appendChild(dateDiv);

                var timeDiv = document.createElement('span');
                timeDiv.className = "eventTime";
                timeDiv.textContent = games[key].time;
                container.appendChild(timeDiv);

                var vsDiv = document.createElement('span');
                vsDiv.className = "vs";
                vsDiv.textContent = "vs:";
                container.appendChild(vsDiv);

                var opponentDiv = document.createElement('span');
                opponentDiv.className = "eventOpponent";
//                opponentDiv.textContent = games[key].opponent;
                container.appendChild(opponentDiv);

                var teamLink = document.createElement('a');
                teamLink.href = "/teams.php?team=" + games[key].opponent;
                teamLink.textContent = games[key].opponent;
                opponentDiv.appendChild(teamLink);


                var locationDiv = document.createElement('span');
                locationDiv.className = "eventLocation";
                locationDiv.textContent = "Intramural Fields";
                container.appendChild(locationDiv);
            }
        }
    });
}

