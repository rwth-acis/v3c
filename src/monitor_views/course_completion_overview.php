<?php
require '../config/config.php'
?>

<script src="<?php print $baseUrl ?>/src/external/plotly/plotly-finance.min.js"></script>
<div id="courseCompletionPlot"></div>

<script>
  <?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  //create database connection (needs to be done before mysql_real_escape_string)
  $conn = require '../php/db_connect.php';

  $statement = $conn->prepare("
    SELECT COUNT(sub.user) users, watched
    FROM(
      SELECT COUNT(DISTINCT value) watched, user
      FROM user_actions
      WHERE action = 'watchVideo'
      GROUP BY user
    ) sub
    GROUP BY sub.watched
    
  ");
  $statement->execute();

  $x = array(0);
  $y = array(0);
  
  while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $x[] = $row['watched'] / 6;
      $y[] = $row['users'];
  }
  $option = [];
  $option['x'] = $x;
  $option['y'] = $y;
  $option['type'] = 'scatter';
  $option['fill'] = 'tonexty';
  $option['mode'] = 'line markers';

  $json=json_encode($option);
  print 'var data = ';
  print $json;
  print ';';

  ?>
  data.fillcolor = {
    "color": "rgba(70,183,105, 0.3)"
  }
  var layout = {
    "xaxis": {
      "domain": [
        0,
        1
      ],
      "title": "Course completion in %"
    },
    "yaxis": {
      "title": "Number of users"
    }
  }
  Plotly.newPlot('courseCompletionPlot', [data], layout);
</script>
