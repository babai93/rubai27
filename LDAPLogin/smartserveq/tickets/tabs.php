<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Tabs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css" integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
    <style>
        /* Hide all tab content by default */
        .tab-content {
        display: none;
        }

        /* Show the active tab content */
        .tab-content.active {
        display: block;
        }
        button.active{
            background-color: red; 
            color: black;
        }
    </style>
    <!--<script>
    function openTab(evt, tabName) {
    var i, tabContent, tabButtons;
    
    // Hide all tab content
    tabContent = document.getElementsByClassName('tab-content');
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = 'none';
    }
    
    // Deactivate all tab buttons
    tabButtons = document.getElementsByClassName('tab-button');
    for (i = 0; i < tabButtons.length; i++) {
        tabButtons[i].classList.remove('active');
    }
    
    // Show the selected tab content and mark the corresponding tab button as active
    document.getElementById(tabName).style.display = 'block';
    evt.currentTarget.classList.add('active');
    }
    </script>-->
    <script>
    function openTab(evt, tabName) {
    var i, tabContent, tabButtons;
    
    // Hide all tab content
    tabContent = document.getElementsByClassName('tab-content');
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = 'none';
    }
    
    // Deactivate all tab buttons
    tabButtons = document.getElementsByClassName('tab-button');
    for (i = 0; i < tabButtons.length; i++) {
        tabButtons[i].classList.remove('active');
    }
    
    // Show the selected tab content and mark the corresponding tab button as active
    document.getElementById(tabName).style.display = 'block';
    evt.currentTarget.classList.add('active');
    }

    // Show Tab 1 content by default when the page loads
    document.getElementById('tab1').style.display = 'block';
    document.getElementsByClassName('tab-button')[0].classList.add('active');
    </script>

</head>
<body>
<div class="tabs">
  <button class="tab-button active" onclick="openTab(event, 'tab1')">Tab 1</button>
  <button class="tab-button" onclick="openTab(event, 'tab2')">Tab 2</button>
  <button class="tab-button" onclick="openTab(event, 'tab3')">Tab 3</button>
  
  <div id="tab1" class="tab-content active">
    <!-- Content of Tab 1 -->
    <h2>Tab 1 Content</h2>
    <p>This is the content of Tab 1.</p>
  </div>
  
  <div id="tab2" class="tab-content">
    <!-- Content of Tab 2 -->
    <h2>Tab 2 Content</h2>
    <p>This is the content of Tab 2.</p>
  </div>
  
  <div id="tab3" class="tab-content">
    <!-- Content of Tab 3 -->
    <h2>Tab 3 Content</h2>
    <p>This is the content of Tab 3.</p>
    <p>This is the content of Tab 3.</p>
    <p>This is the content of Tab 3.</p>
    <p>This is the content of Tab 3.</p>
    <p>This is the content of Tab 3.</p>
    <p>This is the content of Tab 3.</p>
  </div>
</div>

<div>
    <style>
        .button-xsmall {
            font-size: 70%;
        }

        .button-small {
            font-size: 85%;
        }

        .button-large {
            font-size: 110%;
        }

        .button-xlarge {
            font-size: 125%;
        }
    </style>
    <button class="button-xsmall pure-button">Extra Small Button</button>
    <button class="button-small pure-button">Small Button</button>
    <button class="pure-button">Regular Button</button>
    <button class="button-large pure-button">Large Button</button>
    <button class="button-xlarge pure-button">Extra Large Button</button>
</div>

<div>
    <style>
        .button-success,
        .button-error,
        .button-warning,
        .button-secondary {
            color: white;
            border-radius: 4px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }

        .button-success {
            background: rgb(28, 184, 65);
            /* this is a green */
        }

        .button-error {
            background: rgb(202, 60, 60);
            /* this is a maroon */
        }

        .button-warning {
            background: rgb(223, 117, 20);
            /* this is an orange */
        }

        .button-secondary {
            background: rgb(66, 184, 221);
            /* this is a light blue */
        }
    </style>
    <button class="button-success pure-button">Success Button</button>
    <button class="button-error pure-button">Error Button</button>
    <button class="button-warning pure-button">Warning Button</button>
    <button class="button-secondary pure-button">Secondary Button</button>
</div>
</body>
</html>