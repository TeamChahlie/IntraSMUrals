$(document).ready(function() {

    populateSports();
    populateAllUpcomingGames();
    //addLoginClickListener();


    // if (parseInt(sessionStorage.getItem('userID')) != 1 && sessionStorage.getItem('userID') != null) {

    //     $('#navLoginForm').hide();
    //     $('#createAccount').hide();
    //     $('#loginInformation').text("Welcome, " + sessionStorage.getItem("firstName") + "!").show();
    //     $('#logout').text("Logout").show();
    //     $('#mySports').show();
    // }

    //checkAdmin();

});

function populateSports() {
    var sportList = document.getElementById('homeSportList');
    var sports = JSON.parse(sessionStorage.getItem('sports'));
    for(var i = 0; i < sports.length; i++) {
        var li = document.createElement('li');
        sportList.appendChild(li);

        var a = document.createElement('a');
        a.textContent = sports[i];
        a.href = "/sportHome.php?sport=" + sports[i];
        li.appendChild(a);

    }
}

function populateAllUpcomingGames() {

    // var matchList = document.getElementById('homeUpcomingGameList');

    // $.getJSON('api/getUpcomingMatches', function(info) {
    //     info = 'This needs to be filled up by the DB. The getUpcomingMatches returns a blank Json. Needs to be fixed. ';
    //     console.log(info);
    //     document.getElementById('homeUpcomingGameList').textContent = info;
    // });

    {


        $.getJSON('api/getTeamSchedule/Acadia', function(games) {

            var scheduleDiv = document.getElementById('homeUpcomingGameList');
            //scheduleDiv.innerHTML = "<h2 class='sectionHeader'>Upcoming Games</h2>";

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

                    // var hostTeam = document.createElement('span');
                    // hostTeamDiv.className = "hostTeam";
                    // hostTeamDiv.textContent = "Acadia";
                    // container.appendChild(hostTeamDiv);

                    var vsDiv = document.createElement('span');
                    vsDiv.className = "vs";
                    vsDiv.textContent = " Acadia vs:";
                    container.appendChild(vsDiv);

                    var opponentDiv = document.createElement('span');
                    opponentDiv.className = "eventOpponent";
                    //               opponentDiv.textContent = games[key].opponent;
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


}