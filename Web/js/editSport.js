
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