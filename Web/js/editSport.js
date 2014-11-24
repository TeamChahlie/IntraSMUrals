
var currentTeam = "";

$(document).ready(function() {
    $('.subHeader').text(get('sportName'));
    sessionStorage.setItem('currentSport', get('sportName'));
    getTeams();
    getMatches();
    addTeamHoverListeners();
    addTeamClickListeners();

});

function get(name){
    if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
        return decodeURIComponent(name[1]);
}

function getTeams() {
    $.getJSON('api/getTeamsInSport/' + get('sportName'), function(teams) {

        if(teams.length > 0) {
            for(var team in teams) {
                var teamName = teams[team].teamName;
                var teamList = document.getElementById('sportTeamList');

                var div = document.createElement('div');
                div.className = "teamEditorButton";
                teamList.appendChild(div);

                var subDiv1 = document.createElement('div');
                subDiv1.className = "teamDefault";
                div.appendChild(subDiv1);

                var h2 = document.createElement('h2');
                h2.className = "teamTitle";
                h2.textContent = teamName;
                subDiv1.appendChild(h2);

                var subDiv2 = document.createElement('div');
                subDiv2.className = "teamOptionMenu";
                div.appendChild(subDiv2);

                var editDiv = document.createElement('div');
                editDiv.className = "teamOptionButton editTeam";
                editDiv.textContent = "Edit";
                subDiv2.appendChild(editDiv);

                var deleteDiv = document.createElement('div');
                deleteDiv.className = "teamOptionButton deleteTeam";
                deleteDiv.textContent = "Delete";
                subDiv2.appendChild(deleteDiv);

            }
        }
    });
}

function getMatches() {
    var sportName = get('sportName');
    var scheduleDiv = document.getElementById('sportSchedule');

    $.getJSON('api/getMatchesInSport/' + sportName, function(matches) {
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
                date.textContent = match.dateOf;
                outerDiv.appendChild(date);

                var time = document.createElement('div');
                time.className = "sportEventTime";
                time.textContent = match.timeOf;
                outerDiv.appendChild(time);

                var location = document.createElement('div');
                location.className = "sportEventLocation truncate";
                location.textContent = "Intramural Fields";
                outerDiv.appendChild(location);

                var editButton = document.createElement('div');
                editButton.className = "sportEventButton";
                editButton.textContent = "Edit";
                editButton.dataset.ID = match.matchID;
                outerDiv.appendChild(editButton);

                var deleteButton = document.createElement('div');
                deleteButton.className = "sportEventButton";
                deleteButton.textContent = "Delete";
                deleteButton.dataset.ID = match.matchID;
                outerDiv.appendChild(deleteButton);
            }
        }
    })
}

function addTeamHoverListeners() {
    $('#sportTeamList').on('mouseenter', '.teamEditorButton', function() {
        $(this).children('.teamDefault').stop().animate({width: 'toggle'}, 200);
        $(this).children('.teamOptionMenu').stop().animate({width: 'toggle'}, 300);
    });
    $('#sportTeamList').on('mouseleave', '.teamEditorButton', function() {
        $(this).children('.teamOptionMenu').stop().animate({width: 'toggle'}, 200);
        $(this).children('.teamDefault').stop().animate({width: 'toggle'}, 300);
    });
}

function addTeamClickListeners() {
    $('#sportTeamList').on('click', 'div.editTeam', function() {
        var teamName = $(this).parent().prev().children('.teamTitle').text();
        console.log("EDIT: " + teamName);
        var url = "editTeam.php?teamName=" + teamName;
        window.location.href = url;
    });

    $('#sportTeamList').on('click', 'div.deleteTeam', function() {
        var teamName = $(this).parent().prev().children('.teamTitle').text();
        console.log("DELETE: " + teamName);
        var team = new Object()
        team.sportName = get('sportName');
        team.teamName = teamName;
        currentTeam = team;
        displayDeleteTeamConfirmationModal();

    });

    $('#yesDeleteTeam').click(function() {
        console.log(currentTeam);
        $.ajax({
            type: 'POST',
            url: 'api/deleteTeam',
            content: 'application/json',
            data: JSON.stringify(currentTeam),
            success: function(data) {
                var obj = JSON.parse(data);
                if(obj.success == true) {
                    window.location.href = "editSport.php?sportName=" + get('sportName');
                } else {
                    alert("Error deleting team from DB.");
                }
            },
            error: function() {
                alert("Error in AJAX request.")
            }
        });
    });

    $('#noDeleteTeam').click(function() {
        console.log("HERE2");
        hideDeleteTeamConfirmationModal();
    });
}

function displayDeleteTeamConfirmationModal() {
    var modal = document.getElementById('deleteTeamModal')
    var background = document.getElementById('adminOverlay');
    background.className = 'adminOverlay';
    modal.className = 'displayAdminModal';
    var width = modal.clientWidth;
    var height = modal.clientHeight;
    var displacementX = '-'+ (width/2) + 'px';
    var displacementY = '-' + (height/2) + 'px';
    modal.style.marginLeft = displacementX;
    modal.style.marginTop = displacementY;
}

function hideDeleteTeamConfirmationModal() {
    var forms = document.getElementsByClassName('displayAdminModal');
    for(var form in forms) {
        forms[form].className = "adminModal";
    }
    document.getElementById('adminOverlay').className = "";
}