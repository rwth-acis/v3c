/**
 * Copyright 2015 Adam Brunnmeier, Dominik Studer, Alexandra Wörner, Frederik Zwilling, Ali Demiralp, Dev Sharma, Luca Liehner, Marco Dung, Georgios Toubekis
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @file course-list.js
 * All functionality for views/course_list.php
 */

/// Initialize course_list.php
$(document).ready(function () {

    var body = $("body");

    // Event propagation for dynamically created elements (which is the case when courses are filtered)
    body.on("click", ".btn-edit", function () {
        window.location = "editcourse.php?id=" + $(this).data("id") + "&lang=" + $(this).data("lang");
    });

    body.on("click", ".btn-delete", function () {
        window.location = "course_delete.php?id=" + $(this).data("id") + "&lang=" + $(this).data("lang");
    });
});
