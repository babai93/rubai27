$(function () {
    var time = new Date(),
        hours = time.getHours(),
        minutes = time.getMinutes(),
        seconds = time.getSeconds();

    var hourAngle = 0.5 * (hours * 60 + minutes + (0.5 / 60) * seconds);
    var minuteAngle = 0.1 * (minutes * 60 + seconds);
    var secondsAngle = 6 * seconds;

    var style = $("<style>");

    var styles = "";
    styles += ".hours .current { transform: rotate(" + hourAngle + "deg)}";
    styles += ".minutes .current { transform: rotate(" + minuteAngle + "deg)}";
    styles += ".seconds .current { transform: rotate(" + secondsAngle + "deg)}";

    style.text(styles);
    $("body").append(style);
    $(".watch").show();
});