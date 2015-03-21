<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">

  <?php
    // Run this script as high up the page as you can,
    // but only if the cookie isn't already present.
    if (!isset($_COOKIE["screen-width"])) { ?>
      <script src="mobile-mustard.js"></script>
  <?php } ?>

  <title>Server Side Mustard Cutting</title>

  <link rel="stylesheet" href="style.css">

  <!-- See, we can do cool stuff like have different stylesheets -->
  <link rel="stylesheet" href="style-small.css">

  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

  <!-- See, we can do cool stuff like have different stylesheets -->
  <div class="which">
    You got the small screen document.

    <!-- Here's a way you can offer a way to fix a mistake... -->
    <div class="which-warning">
      Your screen looks bigger though...
      <a href="javascript: document.cookie = 'screen-width=; expires=Thu, 01 Jan 1970 00:00:01 GMT;'; location.reload(true);">clear cookies and refresh?</a>
    </div>
  </div>

  <?php include_once("content.php"); ?>

</body>

</html>