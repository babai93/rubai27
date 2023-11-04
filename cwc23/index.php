<!-- <script disable-devtool-auto='true' src='https://cdn.jsdelivr.net/npm/disable-devtool' clear-log='true'
  disable-select='true' disable-copy='true' disable-cut='true'
  disable-paste='true'></script> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICC Cricket World Cup 2023 [By Dutta]</title>
    <link rel="stylesheet" href="./stylme.css">
    <link rel="stylesheet" href="./screen.css">
    <link rel="shortcut icon" href="https://resources.pulse.icc-cricket.com/whitelabel-assets/100356/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
      <div class="logo-container">
        <img src="./emblem.svg" alt="Logo Image" class="logo-image">
        <div class="in-text">
          <span class="bymedesktop icc-text"><em>ICC</em> MAN'S CRICKET WORLD CUP</span>
          <h1 class="logo-text">INDIA 2023</h1>
          <img class="logo-svg" src="./icccwc23.svg" alt="ICC MAN'S CRICKET WORLD CUP 2023">
          <div class="bymedesktop"><span class="byme">Brought to you by Dutta</span></div>
        </div>
        <img src="./live.png" alt="Logo Image" class="logo-image">
      </div>
      <div class="bymemobile"><span class="byme">Brought to you by Dutta</span></div>
    </header>
    <div id="videoPlayer"></div>
    <ul>
        <li><a href="#/starhin" onclick="streamMatch('./starhin.html')">
        <img src="./StarSportsHin.png" alt="STAR SPORTS HD" width="150px"><br>       
        STAR SPORTS HD (HINDI)</a></li>
        <li><a href="#/star1" onclick="streamMatch('./star1.html')">
        <img src="./StarSportsEng.png" alt="STAR SPORTS HD" width="150px"><br> 
        STAR SPORTS HD (ENGLISH)</a></li>
        <li><a href="#/hotstar" onclick="streamMatch('./ww.html')">
        <img src="./HotStar.png" alt="HOTSTAR" width="150px"><br>
        HOTSTAR (HINDI)</a></li>
        <li><a href="#/skysports" onclick="streamMatch('./skysports.html')">
        <img src="./skysports.png" alt="SKY SPORTS" width="150px"><br>
        SKY SPORTS </a></li>
        <li><a href="#/astro" onclick="streamMatch('./astro.html')">
        <img src="./astro.png" alt="ASTRO Cricket" width="150px"><br>
        ASTRO CRICKET</a></li>
        <li><a href="#/astro" onclick="window.open('https://www.cricketworldcup.com/home-page')">
        <img src="./cwc2023.png" alt="ICC World Cup 2023" width="150px"><br>
        WORLD CUP 2003 (Official)</a></li>
    </ul>

    <script src="./sd.js"></script>

    <footer>
      <div class="telegram"><img src="./JoinTelegram-sm.png" alt="Telegram" width="150px" srcset=""></div>
    </footer>
    <div class="div-text">Point Table (Group Stage)</div>
<div id="div-id">
  <div id="external-content-container"></div>
</div>
<script>
  $(document).ready(function () {
    // URL of the external website
    var externalURL = 'https://get-standings-cwc.babai93.repl.co/get-standings';

    // The specific <div> you want to append and display
    var specificDivSelector = '.standings ';

    // Make an AJAX request to fetch the content
    $.get(externalURL, function (data) {
      // Parse the response as HTML
      var externalContent = $(data);

      // Find the specific <div> within the external content
      var specificDiv = externalContent.find(specificDivSelector);

      // Check if the specific <div> was found
      if (specificDiv.length > 0) {
        // Append the specific <div> to your container
        $('#external-content-container').append(specificDiv);
      } else {
        // Handle the case where the specific <div> was not found
        $('#external-content-container').html('The specific <div> was not found on the external page.');
      }
    });
  });
</script>
</body>
</html>