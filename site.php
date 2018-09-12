<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Systeme de Gestion des Resolutions</title>
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
  <link href="css/dycalendar.min.css" rel="stylesheet">
</head>

<body>
  <div id="page">
    <div id="head" class="row">
      <div id="head1"><br><br>
        <a href="https://uqo.ca" title="Site officiel UQO.ca">UQO</a>
      </div>
      <div id="head2">
        <h1 class="head2" ><a href="site.php">SGR</a></h1>
        <h5 class="head21"><a href="site.php">Systeme de Gestion des Resolutions</a></h5>
      </div>
    </div>
    <div id="container">
      Je n'ai rien mis iciiiiiiiiiiiiiiiiiiiiiiii
    </div>
    <div id="side">
      <!-- *******Debut Calendrier**********-->
      <div id="calendar">
        <div id="dycalendar-month-prev-next-button" class="dycalendar-container skin-green shadow-default">
        </div>

        <!-- javascript -->
        <script src="js/jquery.min.js"></script>
        <script src="js/dycalendar-jquery.min.js"></script>
        <script src="js/dycalendar.min.js"></script>
        <script>
        dycalendar.draw({
          target: '#dycalendar-month-prev-next-button',
          type:'month',
          prevnextbutton:"show",
          highlighttoday:true
        });
        </script>
        <!--Fin Calendrier*******-->
      </div>


    </div>

    <div id="footer">
    </div>
  </div>
  <!--
  <div id="wrapper">
  <div id="banner">
</div>
<nav id="navigation">
<ul id="nav">
<li><a href="site.php">Home</a></li>
<li><a href="#">Test</a></li>
<li><a href="#">Test</a></li>
<li><a href="#">Test</a></li>
</nav>

<div id="content_area">
<?php echo $content; ?>
</div>

<div id="sidebar">
<p>Hello world</p>
</div>

<footer>
<p> All rights reserved</p>
</div>
-->
</body>
</html>
