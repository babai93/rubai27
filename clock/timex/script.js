// I use javascript only to set the initial state of the watch to the current time and date.
window.addEventListener("load", (event) => {
    var time = new Date(),
        hours = time.getHours(),
        minutes = time.getMinutes(),
        seconds = time.getSeconds(),
        date = time.getDate(),
        hourAngle = 0.5 * (hours * 60 + minutes + (0.5 / 60) * seconds),
        minuteAngle = 0.1 * (minutes * 60 + seconds),
        secondsAngle = 6 * seconds,
        dateAnimationDelay = -(
            (date - 1) * 24 * 3600 +
            hours * 3600 +
            minutes * 60 +
            seconds
        );

    document.documentElement.style.setProperty(
        "--current-hours",
        `${hourAngle}deg`
    );
    document.documentElement.style.setProperty(
        "--current-minutes",
        `${minuteAngle}deg`
    );
    document.documentElement.style.setProperty(
        "--current-seconds",
        `${secondsAngle}deg`
    );
    document.documentElement.style.setProperty(
        "--current-date",
        `${dateAnimationDelay}s`
    );
});