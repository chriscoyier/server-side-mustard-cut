"use strict";

(function() {

  // If the browser supports cookies and they are enabled
  if (navigator.cookieEnabled) {

    // Set the cookie for 3 days
    var date = new Date();
    date.setTime(date.getTime() + (3 * 24 * 60 * 60 * 1000));
    var expires = "; expires=" + date.toGMTString();

    // This is where we're setting the mustard cutting information.
    // In this case we're just setting screen width, but it could
    // be anything. Think http://modernizr.com/
    document.cookie = "screen-width=" + screen.width + expires + "; path=/";

    /*
      Only refresh if the WRONG template loads.

      Since we're defaulting to a small screen,
      and we know if this script is running the
      cookie wasn't present on this page load,
      we should refresh if the screen is wider
      than 700.

      This needs to be kept in sync with the server
      side distinction
    */
    if (screen.width > 700) {

      // Halt the browser from loading/doing anything else.
      window.stop();

      // Reload the page, because the cookie will now be
      // set and the server can use it.
      location.reload(true);

    }

  }

}());
