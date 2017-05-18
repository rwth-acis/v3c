<?php
require '../config/config.php'
?>

<script src="<?php print $baseUrl ?>/src/external/progressbar.js/progressbar.min.js"></script>
<style>
  #progressBar {
    margin: 20px;
    width: 200px;
    height: 200px;
  }
</style>
<div id="progressBar"></div>

<script>
  <?php
  /*
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  */

  //create database connection (needs to be done before mysql_real_escape_string)
  $conn = require '../php/db_connect.php';

  $statement = $conn->prepare("
    SELECT COUNT(value) watched
    FROM user_actions
    WHERE user = 13 and action = 'watchVideo'
    GROUP BY value
  ");
  $statement->execute();

  $watched = $statement->fetch(PDO::FETCH_ASSOC);

  print 'var progress = ';
  print $watched['watched'] / 3;
  print ';';
  ?>
  progress = Math.ceil(progress*100)/100

  var color
  if (progress < .4) {
  color = 'hsla(3, 113%, 54%, 0.63)'
  } else if (progress < .7) {
  color = '#FFEA82'
  } else {
  color = 'rgba(15, 192, 15, 0.69)'
  }
  var bar = new ProgressBar.Circle(document.querySelector('#progressBar'), {
  strokeWidth: 10,
  easing: 'easeInOut',
  duration: 1400,
  color: color,
  trailColor: '#eee',
  trailWidth: 1,
  svgStyle: null
  });

  bar.setText('<b style="font-size: 40px;">'+progress*100+'%</b>')
  bar.animate(progress);
</script>
