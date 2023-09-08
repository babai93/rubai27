$(document).ready(function() { 
    // Trigger the AJAX request on button click
    $('#ajaxButton').click(function() {
      // Create the overlay div element
      var overlay = $('<div></div>');

      // Set the overlay styles
      overlay.css({
      'position': 'fixed',
      'top': '0',
      'left': '0',
      'width': '100%',
      'height': '100%',
      'background': 'rgba(0, 0, 0, 0.5)', // 50% opacity black background
      'z-index': '9999'
      });

      // Create the loading message element
      var loadingMessage = $('<span>Loading...</span>');

      // Set the loading message styles
      loadingMessage.css({
      'color': '#fff', // White text color
      'font-size': '30px',
      'position': 'absolute',
      'top': '50%',
      'left': '50%',
      'transform': 'translate(-50%, -50%)'
      });

      // Append the loading message to the overlay
      overlay.append(loadingMessage);

      // Append the overlay to the body
      $('body').append(overlay);
    });
  });