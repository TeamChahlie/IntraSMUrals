
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
    
    $.getJSON('api/getUpcomingMatches', function(info) {
        info = 'This needs to be filled up by the DB. This area will be filled by a JSON created by the getUpcomingMatches call. once this is done, delete this text from the home.js file. ';
        console.log(info);
        document.getElementById('homeUpcomingGameList').textContent = info;
    });
    

}