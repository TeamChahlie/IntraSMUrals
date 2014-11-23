$(document).ready(function() {

    $('#addNewSport').click(function() {
        displayAdminModal('addSportModal');
    });

    $(document).on('submit', 'form.createSportForm', function(event) {
        event.preventDefault();
        submitSport();
    });

    $('#adminOverlay').click(function() {
        hideAdminModals();
    });

    $('.adminCloseButton').click(function() {
        hideAdminModals();
    });

});

function displayAdminModal(modalID) {
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

function hideAdminModals() {
    var forms = document.getElementsByClassName('displayAdminModal');
    for(var form in forms) {
        forms[form].className = "adminModal";
    }
    document.getElementById('adminOverlay').className = "";
}

function submitSport() {
    var sportName = $('#createSportName').val();
    alert(sportName);
}