var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

function parseDate(dateString) {

    var dateParsed = dateString.split("-");
    var prettyString = months[parseInt(dateParsed[1])-1] + " " + dateParsed[2] + ", " + dateParsed[0];
    return prettyString;
}

function parseTime(timeString) {
    var timeParsed = timeString.split(":");
    var hours = (parseInt(timeParsed[0]) > 12 ? parseInt(timeParsed[0])-12 : parseInt(timeParsed[0]));
    var minutes = timeParsed[1];
    var ampm = (parseInt(timeParsed[0]) > 12 ? "PM" : "AM");
    var prettyString = hours + ":" + minutes + " " + ampm;
    return prettyString;
}
