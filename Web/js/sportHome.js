$(document).ready(function() {
    $('.pageHeader').text(get('sport'));

    tableCreate();
});

function get(name){
    if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
        return decodeURIComponent(name[1]);
}


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

                //var div2 = document.createElement('div');
                //div2.className = "teamButtonDropdown";
                //teamList.appendChild(div2);
                //
                //var teamLink = document.createElement('a');
                //teamLink.className = "teamLink";
                //teamLink.href = "/teams.php?team=" + teamName;
                //teamLink.textContent = "Visit Homepage";
                //div2.appendChild(teamLink);
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