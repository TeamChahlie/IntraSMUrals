

$(document).ready(function() {
    insertTeamButtons();
});

function insertTeamButtons() {

    var userID = sessionStorage.getItem('userID');
    $.getJSON('api/getStudentTeams/' + userID, function(teams) {
        console.log(teams.length);
        if (teams.length == 0) {
            document.getElementById('noTeams').className = "visible";
        } else {
            for(var key in teams) {
                var teamName = teams[key].teamName;

                var teamList = document.getElementById('studentTeamList');

                var div = document.createElement('div');
                div.className = "teamButton";
                div.textContent = teamName;
                div.addEventListener('click', teamButtonListener, false);
                teamList.appendChild(div);
            }
        }
    });
}

function teamButtonListener() {
    var buttons = document.getElementsByClassName('teamButtonSelected');
    for(var button in buttons) {
        buttons[button].className = "teamButton";
    }
    this.className = "teamButtonSelected";

    var teamName = this.textContent;

    $.getJSON('api/getTeamSchedule/' + teamName, function(games) {

        var scheduleDiv = document.getElementById('studentSchedule');
        scheduleDiv.innerHTML = "<h2 class='sectionHeader'>Upcoming Games</h2>";

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

                var dateDiv = document.createElement('div');
                dateDiv.className = "eventDate";
                dateDiv.textContent = games[key].date;
                container.appendChild(dateDiv);

                var timeDiv = document.createElement('div');
                timeDiv.className = "eventTime";
                timeDiv.textContent = games[key].time;
                container.appendChild(timeDiv);

                var vsDiv = document.createElement('div');
                vsDiv.className = "vs";
                vsDiv.textContent = "vs:";
                container.appendChild(vsDiv);

                var opponentDiv = document.createElement('div');
                opponentDiv.className = "eventOpponent";
//                opponentDiv.textContent = games[key].opponent;
                container.appendChild(opponentDiv);

                var teamLink = document.createElement('a');
                teamLink.href = "/teams.php?team=" + games[key].opponent;
                teamLink.textContent = games[key].opponent;
                opponentDiv.appendChild(teamLink);


                var locationDiv = document.createElement('div');
                locationDiv.className = "eventLocation";
                locationDiv.textContent = "Intramural Fields";
                container.appendChild(locationDiv);
            }
        }
    });
}