// Family-Browser Version 1.1
// Author: Timo Oelerich

// Adjust Buttons to disappear on scrolling in Pixels
var leftOff = 40;
var rightOff = 40;

// H-Scrolling
function familybrowserScroll(direction) {

  if (direction == 'fnavLeft') {
    $('#fnav').animate({
      scrollLeft: "-=" + 250 + "px"
    }, function() {
      fnavButton();
    });

  } else

  if (direction == 'fnavRight') {
    $('#fnav').animate({
      scrollLeft: "+=" + 250 + "px"
    }, function() {
      fnavButton();
    });
  }
}

// Show / Hide Buttons
function fnavButton() {

  var fnavScrollMin = $('#fnav').scrollLeft();
  var fnavScrollMax = ($('#familybrowser').width() - $('#fnav').scrollLeft()) - $('#fnav').width();
  var content = $('#fnav').width() - $('#familybrowser').width();

  if (fnavScrollMin <= leftOff) {
    $('#fnav-button-left').css({
      visibility: 'hidden'
    });
  } else {
    $('#fnav-button-left').css({
      visibility: 'visible'
    });
  }
  if (fnavScrollMax <= rightOff) {
    $('#fnav-button-right').css({
      visibility: 'hidden'
    });
  } else {
    $('#fnav-button-right').css({
      visibility: 'visible'
    });
  }
}