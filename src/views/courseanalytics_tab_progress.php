<?php
$conn = require '../php/db_connect.php';

$course_id = filter_input(INPUT_GET, 'id');
$course_lang = filter_input(INPUT_GET, 'lang');

// TODO
?>


<div class="list-group list-group-root well">

  <a href="#item-1" class="list-group-item" data-toggle="collapse">
    USER
    <span class="pull-right">
        <span class="glyphicon glyphicon-question-sign margin-right margin-left"></span>
        100%
    </span>
  </a>
  <div class="list-group collapse" id="item-1">
    <a href="#" class="list-group-item">
      UNIT
      <span class="pull-right">
          <span class="glyphicon glyphicon-question-sign margin-right margin-left"></span>
          100%
      </span>
    </a>
  </div>
</div>
