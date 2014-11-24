$(document).ready(function() {
    $('.pageHeader').text(get('sport'));
    populateSchedule();
    populateTeams();

});

function get(name){
    if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
        return decodeURIComponent(name[1]);
}


function populateSchedule() {

    var userID = sessionStorage.getItem('userID');
    $.getJSON('api/getMatchesInSport/' + get('sport'), function(matches) {
        var scheduleDiv = document.getElementById('sportSchedule');

        if(matches.length == 0) {

        } else {
            for(var key in matches) {
                var match = matches[key];

                var outerDiv = document.createElement('div');
                outerDiv.className = "sportScheduleEvent";
                scheduleDiv.appendChild(outerDiv);

                var team1Div = document.createElement('div');
                team1Div.className = "sportEventTeam truncate";
                team1Div.textContent = match.teamA;
                outerDiv.appendChild(team1Div);

                var team1Score = document.createElement('div');
                team1Score.className = "sportEventScore";
                if(match.teamAScore == null) {
                    team1Score.textContent = "--";
                } else {
                    team1Score.textContent = match.teamAScore;
                }
                outerDiv.appendChild(team1Score);

                var vs = document.createElement('div');
                vs.className = "sportVS";
                vs.textContent = "vs.";
                outerDiv.appendChild(vs);

                var team2Div = document.createElement('div');
                team2Div.className = "sportEventTeam truncate";
                team2Div.textContent = match.teamB;
                outerDiv.appendChild(team2Div);

                var team2Score = document.createElement('div');
                team2Score.className = "sportEventScore";
                if(match.teamBScore == null) {
                    team2Score.textContent = "--";
                } else {
                    team2Score.textContent = match.teamBScore;
                }
                outerDiv.appendChild(team2Score);

                var date = document.createElement('div');
                date.className = "sportEventDate";
                date.textContent = parseDate(match.dateOf);
                outerDiv.appendChild(date);

                var time = document.createElement('div');
                time.className = "sportEventTime";
                time.textContent = parseTime(match.timeOf);
                outerDiv.appendChild(time);

                var location = document.createElement('div');
                location.className = "sportEventLocation truncate";
                location.textContent = "Intramural Fields";
                outerDiv.appendChild(location);
            }
        }
    });
}

function populateTeams() {
    $.getJSON('api/getTeamsInSport/' + get('sport'), function(teams) {

        if(teams.length > 0) {
            for(var team in teams) {
                var teamName = teams[team].teamName;
                var teamList = document.getElementById('sportTeamList');

                var a = document.createElement('a')
                a.href = "teams.php?team=" + teamName;
                a.className = "teamButton plainLink";
                a.textContent = teamName;
                teamList.appendChild(a);

//                var subDiv1 = document.createElement('div');
//                subDiv1.className = "teamDefault";
//                div.appendChild(subDiv1);
//
//                var h2 = document.createElement('h2');
//                h2.className = "teamTitle";
//                h2.textContent = teamName;
//                subDiv1.appendChild(h2);
//
//                var subDiv2 = document.createElement('div');
//                subDiv2.className = "teamOptionMenu";
//                div.appendChild(subDiv2);
//
//                var editDiv = document.createElement('div');
//                editDiv.className = "teamOptionButton editTeam";
//                editDiv.textContent = "Edit";
//                subDiv2.appendChild(editDiv);
//
//                var deleteDiv = document.createElement('div');
//                deleteDiv.className = "teamOptionButton deleteTeam";
//                deleteDiv.textContent = "Delete";
//                subDiv2.appendChild(deleteDiv);

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


// function tableCreate(){
// var body=document.getElementsByTagName('p')[0];
// var tbl=document.createElement('table');
// tbl.style.width='100%';
// tbl.setAttribute('border','1');
// var tbdy=document.createElement('tbody');
// for(var i=0;i<2;i++){
//     var tr=document.createElement('tr');
//     for(var j=0;j<2;j++){
//         if(i==2 && j==1){
//                 break
//                  } else {
//         var td=document.createElement('td');
//         if(i==0&&j==0)
//         	td.appendChild(document.createTextNode('Team'))
//         else if(i==0&&j==1) 
//         	td.appendChild(document.createTextNode('Current Captain'))
//         else
//         td.appendChild(document.createTextNode('TEST'))
//         i==1&&j==1?td.setAttribute('rowSpan','2'):null;
//         tr.appendChild(td)
//         }
//     }
//     tbdy.appendChild(tr);
// }
// tbl.appendChild(tbdy);
// body.appendChild(tbl)
// }