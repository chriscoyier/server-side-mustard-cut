<?php

  // This file is just a FAKE ROUTER

  if (isset($_COOKIE["screen-width"]) == 1) {

    // Large screen
    if ($_COOKIE["screen-width"] > 700) {

      include_once("screen-large.php");

    // Small screen
    } else {

      include_once("screen-small.php");

    }

  // Choose a default
  } else {

    include_once("screen-small.php");

  }

?>