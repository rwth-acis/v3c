<?php
$conn = require '../php/db_connect.php';

$course_id = filter_input(INPUT_GET, 'id');
$course_lang = filter_input(INPUT_GET, 'lang');

$point_to_time_factor = 1;


// Get course units
$stmt = $conn->prepare("SELECT course_units.*, course_units_lng.*
    FROM course_units, course_units_lng
    WHERE course_units.course_id = :course_id
    AND course_units.id = course_units_lng.unit_id
    AND course_units_lng.lang = (SELECT
    IFNULL( (SELECT lang FROM course_units_lng
    WHERE course_units_lng.unit_id = course_units.id AND course_units_lng.lang = :course_lang) ,
    course_units.default_lang))");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

if (!$stmt->execute()) {
    print_r( $stmt->errorInfo() );
    die();
}

$course_units = $stmt->fetchAll();

// get active users
$stmt = $conn->prepare("SELECT user_id, unit_id, given_name, family_name
  FROM user_progression, course_units, users
  WHERE user_progression.unit_id = course_units.id AND course_units.course_id = :course_id AND user_progression.user_id = users.id");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);

if (!$stmt->execute()) {
    print_r( $stmt->errorInfo() );
    die();
}

// extract users
$user_data = array();
while($user_progression = $stmt->fetch()) {
  if (!array_key_exists($user_progression["user_id"], $user_data)) {
    $user_data[$user_progression["user_id"]] = array(
      "user_id" => $user_progression["user_id"],
      "given_name" => $user_progression["given_name"],
      "family_name" => $user_progression["family_name"],
      "submissions" => array(),
    );
  }
}

// submissions
foreach ($user_data as $key => &$value) {
  $stmt = $conn->prepare(
    "SELECT course_units.id AS unit_id, course_elements.id AS element_id, widget_data_feedback_submissions.content AS content, widget_data_feedback_lng.title AS title
      FROM course_units, course_elements, widget_data_feedback_submissions, widget_data_feedback_lng
      WHERE course_units.course_id = :course_id
        AND course_elements.unit_id = course_units.id
        AND widget_data_feedback_submissions.element_id = course_elements.id
        AND widget_data_feedback_submissions.user_id = :user_id
        AND widget_data_feedback_lng.element_id = course_elements.id
        AND widget_data_feedback_lng.lang = course_elements.default_lang
    ");
  $stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
  $stmt->bindParam(":user_id", $value['user_id'], PDO::PARAM_INT);
  if (!$stmt->execute()) {
    print_r( $stmt->errorInfo() );
    die();
  }

  foreach ($course_units as $unitkey => $unit) {
    $value["submissions"][$unit['unit_id']] = array();
  }

  while ($data = $stmt->fetch()) {
    $value["submissions"][$data['unit_id']][$data['element_id']] = array(
      "title" => $data['title'],
      "content" => $data['content']
    );
  }
}

?>

<p><strong><?php echo sizeof($user_data) ?></strong> participants</p>

<div class="list-group list-group-root well">
  <?php foreach ($user_data as $value1): ?>
    <a href="#item-<?php echo $value1['user_id'] ?>" class="list-group-item" data-toggle="collapse">
      <?php echo $value1['family_name'] ?>, <?php echo $value1['given_name'] ?>
    </a>
    <div class="list-group collapse" id="item-<?php echo $value1['user_id'] ?>">
      <?php foreach ($course_units as $unitkey => $unit): ?>
        <a href="#item-<?php echo $value1['user_id'] ?>-<?php echo $unit['unit_id'] ?>" class="list-group-item" data-toggle="collapse">
          <?php echo $unit['title'] ?>
        </a>
        <div class="list-group collapse" id="item-<?php echo $value1['user_id'] ?>-<?php echo $unit['unit_id'] ?>">
          <?php foreach ($value1['submissions'][$unit['unit_id']] as $elementkey => $element): ?>
            <a href="#" class="list-group-item">
              <b><?php echo $element['title'] ?></b><br />
              <textarea readonly><?php echo $element['content'] ?></textarea>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
</div>
