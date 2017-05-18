<?php
require '../config/config.php'
?>

<script src="<?php print $baseUrl ?>/src/external/plotly/plotly-finance.min.js"></script>
<div id="activityPlot" style="width: 100%; height: 100%;"></div>

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
    SELECT  DATE(time) date, COUNT(*) activities
    FROM user_actions
    GROUP BY DATE(time)
  ");
  $statement->execute();

  
  //  $results=$statement->fetchAll(PDO::FETCH_ASSOC);
  // print json_encode($results)

  $x = array();
  $y = array();
  
  while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $x[] = $row['date'];
      $y[] = $row['activities'];
  }
  $option = [];
  $option['x'] = $x;
  $option['y'] = $y;
  $option['type'] = 'scatter';

  $json=json_encode($option);
  print 'var data = ';
  print $json;
  print ';';

  ?>
  var layout = {
    "xaxis": {
      "title": "Date"
    },
    "yaxis": {
      "title": "Number of activities"
    }
  }
  Plotly.newPlot('activityPlot', [data], layout);
</script>