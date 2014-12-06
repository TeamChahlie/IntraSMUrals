var currentTeam = ""
var currentMatch = "";

$(document).ready(function() {
    currentTeam = get("teamName");
    console.log(currentTeam);
    $('.subHeader').text(currentTeam);

    getSchedule();
    addMatchClickListeners();
});

function get(name){
    if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
        return decodeURIComponent(name[1]);
}

function getSchedule() {
    var scheduleDiv = document.getElementById('teamSchedule');

    $.getJSON("api/getTeamSchedule/" + get("teamName"), function(games) {
        console.log(games);
        if(games.length == 0) {

        } else {
            for(var key in games) {
                var match = games[key];

                var outerDiv = document.createElement('div');
                outerDiv.className = "sportScheduleEvent";
                scheduleDiv.appendChild(outerDiv);

                var team1Div = document.createElement('div');
                team1Div.className = "sportEventTeam truncate";
                team1Div.textContent = get("teamName");
                outerDiv.appendChild(team1Div);

                var team1Score = document.createElement('div');
                team1Score.className = "sportEventScore";
                if(match.scoreFavor == null) {
                    team1Score.textContent = "--";
                } else {
                    team1Score.textContent = match.scoreFavor;
                }
                outerDiv.appendChild(team1Score);

                var vs = document.createElement('div');
                vs.className = "sportVS";
                vs.textContent = "vs.";
                outerDiv.appendChild(vs);

                var team2Div = document.createElement('div');
                team2Div.className = "sportEventTeam truncate";
                team2Div.textContent = match.opponent;
                outerDiv.appendChild(team2Div);

                var team2Score = document.createElement('div');
                team2Score.className = "sportEventScore";
                if(match.scoreAgainst == null) {
                    team2Score.textContent = "--";
                } else {
                    team2Score.textContent = match.scoreAgainst;
                }
                outerDiv.appendChild(team2Score);

                var date = document.createElement('div');
                date.className = "sportEventDate";
                date.textContent = parseDate(match.date);
                outerDiv.appendChild(date);

                var time = document.createElement('div');
                time.className = "sportEventTime";
                time.textContent = parseTime(match.time);
                outerDiv.appendChild(time);

                var editButton = document.createElement('div');
                editButton.className = "sportEventButton editMatch";
                editButton.textContent = "Scores";
                editButton.dataset.id = match.matchID;
                editButton.dataset.teamName = match.opponent;
                outerDiv.appendChild(editButton);

                var deleteButton = document.createElement('div');
                deleteButton.className = "sportEventButton deleteMatch";
                deleteButton.textContent = "Delete";
                deleteButton.dataset.id = match.matchID;
                outerDiv.appendChild(deleteButton);
            }
        }
    });
}

function addMatchClickListeners() {
    $('#teamSchedule').on('click', 'div.editMatch', function() {
        var matchID = $(this).data('id');
        var opponent = $(this).data('teamName');
        $('#team1score').text(get("teamName") + ":")
        $('#team2score').text(opponent + ":");
        var match = new Object();
        match.matchID = matchID;
        currentMatch = match;
        sessionStorage.setItem('currentMatch', JSON.stringify(currentMatch));
        displayTeamConfirmationModal('updateScoresModal');
    });

    $('#teamSchedule').on('click', 'div.deleteMatch', function() {
        var matchID = $(this).data('id');
        var match = new Object();
        match.matchID = matchID;
        currentMatch = match;
        displayTeamConfirmationModal('deleteMatchModal');
    });


    $('#yesDeleteMatch').click(function() {
        $.ajax({
            type: 'POST',
            url: 'api/deleteMatch',
            content: 'application/json',
            data: JSON.stringify(currentMatch),
            success: function(data) {
                var obj = JSON.parse(data);
                if(obj.success == true) {
                    window.location.href = "editTeam.php?teamName=" + get('teamName');
                } else {
                    alert("Error deleting match from DB.");
                }
            },
            error: function() {
                alert("Error in AJAX request.");
            }
        })
    });

    $('#noDeleteMatch').click(function() {
        hideTeamConfirmationModal();
    });
}

function displayTeamConfirmationModal(modalID) {
    var modal = document.getElementById(modalID)
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

function hideTeamConfirmationModal() {
    var forms = document.getElementsByClassName('displayAdminModal');
    for(var form in forms) {
        forms[form].className = "adminModal";
    }
    document.getElementById('adminOverlay').className = "";
}
