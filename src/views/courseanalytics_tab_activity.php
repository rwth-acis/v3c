<script src="<?php print $baseUrl ?>/src/external/plotly/plotly-finance.min.js"></script>
<div id="activityPlot" style="width: 100%; height: 100%;"></div>

<script>
  <?php

  $conn = require '../php/db_connect.php';

  $course_id = filter_input(INPUT_GET, 'id');
  $course_lang = filter_input(INPUT_GET, 'lang');

  $statement = $conn->prepare("
    SELECT DATE(sub.time) date, COUNT(*) activities
    FROM (
      SELECT user_actions.time
      FROM course_units
      INNER JOIN user_actions ON course_units.id = user_actions.unit_id
      WHERE course_units.course_id = :course_id
    ) sub
    GROUP BY DATE(sub.time)
  ");
  $statement->bindParam(":course_id", $course_id, PDO::PARAM_INT);
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
      "title": "Number of user activities"
    }
  }
  Plotly.newPlot('activityPlot', [data], layout);
</script>
