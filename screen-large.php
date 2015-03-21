<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">

  <?php
    // Run this script as high up the page as you can,
    // but only if the cookie isn't already present.
    if (isset($_COOKIE["screen-width"]) == 0) { ?>
      <script src="mobile-mustard.js"></script>
  <?php } ?>

  <title>Server Side Mustard Cutting</title>

  <link rel="stylesheet" href="style.css">

  <!-- See, we can do cool stuff like have different stylesheets -->
  <link rel="stylesheet" href="style-large.css">
</head>

<body>
  
  <!-- and different HTML! -->
  <div class="which">
    You got the large screen document.
    
    <div class="which-warning">
      Your screen looks smaller though...
      <a href="javascript: document.cookie = 'screen-width=; expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/'; location.reload(true);">clear cookies and refresh?</a>
    </div>
  </div>

  <?php include_once("content.php"); ?>

</body>

</html>