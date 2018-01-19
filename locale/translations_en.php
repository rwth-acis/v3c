<?php
/**
 * Created by PhpStorm.
 * User: Sabine
 * Date: 12.12.2016
 * Time: 14:29
 */

function getLanguage()
{
    return array(
        "general:button:home" => "Home",
        "general:button:courses" => "Courses",
        "general:button:signin" => "Sign in",
        "general:button:save" => "Save",
        "general:button:delete" => "Delete",
        "general:button:remove" => "Remove",
        "general:button:edit" => "Edit",
        "general:button:yes" => "Yes",
        "general:button:no" => "No",
        "general:button:description" => "Description",
        "general:button:help" => "Help",
        "general:button:manageUsers" => "Manage Users",
        "general:button:LoginToECQA" => "Login to ECQA",

        "general:header:back" => "Back",

        "general:footer:virtus" => "VIRTUS Virtual Vocational Training Centre",
        "general:footer:reach" => "Reach us at: ",
        "general:footer:erasmus" => "This project has been funded with support from the European Commission. This publication reflects the views only of the author, and the Commission cannot be held responsible for any use which may be made of the information contained therein.",

        "main:welcome:headline" => "Welcome to the V3C Project!",
        "main:welcome:v3cgoal" => "The “Virtual Vocational Education and Training – VIRTUS” project will develop an innovative, fully functional virtual vocational education and training centre, which will provide appropriately designed modular certified courses in Modular Employable Skills (MES), corresponding to a wide range of circumstances such as regional growth potential and/or company restructuring and aiming at increasing the participation rate of adult learners in vocational education and training.",
        "main:welcome:v3ccourses" => "In particular, the virtual VET center will provide two modular certified courses on:",
        "main:welcome:tourism" => "Tourism and Hospitality Services",
        "main:welcome:social" => "Social Entrepreneurship",
        "main:welcome:courses" => "Courses",
        "main:welcome:listcourses" => "Check for the list of all the courses available here.",

        "main:subjects:subject" => "Subjects",

        "addcourse:add:create" => "Create a new module",
        "addcourse:content:name" => "Module name:",
        "addcourse:placeholder:name" => "Enter your module name",
        "addcourse:content:language" => "Default language",
        "addcourse:content:domain" => "Module Domain:",
        "addcourse:placeholder:domain" => "Enter your module domain",
        "addcourse:content:profession" => "Module Profession:",
        "addcourse:placeholder:profession" => "Enter your module profession",
        "addcourse:content:desription" => "Description:",
        "addcourse:placeholder:description" => "Enter module description",

        "course:content:courseunits" => "Module Units",
        "course:content:enterroom" => "Enter Module Room",
        "course:content:createdby" > "Created by:",
        "course:content:domain" => "Domain:",
        "course:content:profession" => "Profession:",
        "course:content:description" => "Description:",
        "course:content:notstarted" => "Module has not yet started",
        "course:content:unitnotstarted" => "Unit has not yet started",

        "coursedel:head:name" => "Delete course {COURSENAME}",
        "coursedel:head:name_tmp" => "Delete module ",
        "coursedel:head:confirm" => "Do you really want to delete module {COURSENAME}?",
        "coursedel:head:confirm_tmp1" => "Do you really want to delete module ",
        "coursedel:head:confirm_tmp2" => "?",

        "courselist:head:subcourses" => "{SUBJECT} modules",
        "courselist:head:subcourses_tmp" => " modules",
        "courselist:head:add" => "Add new module",
        "courselist:head:search" => "Search",
        "courselist:choose:choose" => "Choose module",
        "courselist:choose:name" => "Module name",
        "courselist:choose:creator" => "Created by",
        "courselist:choose:start" => "Start Dates",
        "courselist:choose:description" => "Description",

        "courselist:admin:translate" => "Translate to",
        "courselist:admin:edit" => "Edit",
        "courselist:admin:delete" => "Delete",

        "editcourse:head:edit" => "Edit Your Module",
        "editcourse:edit:name" => "Module name:",
        "editcourse:edit:domain" => "Module Domain:",
        "editcourse:edit:profession" => "Module Profession:",
        "editcourse:edit:description" => "Description:",
        "editcourse:edit:design" => "Design learning environment",
        "editcourse:units:add" => "Add Module Unit",

        "editcourseunit:edit:name" => "Module unit name:",
        "editcourseunit:edit:points" => "ECVET Points:",
        "editcourseunit:edit:startdate" => "Start Date:",
        "editcourseunit:edit:description" => "Description:",

        "overview:head:gallery" => "Gallery",

        "usermanagement:choose:family_name" => "Family Name",
        "usermanagement:choose:given_name" => "Given Name",
        "usermanagement:choose:role" => "Role",
        "usermanagment:choose:affiliation" => "Affiliation",
        "usermanagement:button:update" => "Update User",
        "usermanagement:search:name" => "Search by name",

        "designunit:head:title" => "Edit Module Unit",
        "designunit:content:addcontent" => "Add Content",
        "designunit:content:uploadfile" => "Upload File",
        "designunit:content:apply" => "Apply",
        "designunit:content:slideswidget" => "Slides Widget",
        "designunit:content:videowidget" => "Video Widget",
        "designunit:content:imagewidget" => "Image Widget",
        "designunit:content:hangoutwidget" => "Video Conference Widget",
        "designunit:content:quizwidget" => "Quizzes Widget",
        "designunit:content:title" => "Title",
        "designunit:content:link" => "Link",
        "designunit:content:videolink" => "Video or Audio",
        "designunit:content:questions" => "Questions",
        "designunit:content:addquestion" => "Add Question",
        "designunit:content:question" => "Question",
        "designunit:content:answers" => "Answers",
        "designunit:content:answer" => "Answer",
        "designunit:content:addanswer" => "Add Answer",
        "designunit:content:save" => "Save Changes",
        "designunit:content:toolbox" => "Toolbox",
        "designunit:content:rolespace" => "ROLE Space",
        "designunit:content:addtoflow" => "Add to flow",
        "designunit:content:removefromflow" => "Remove from flow",
        "designunit:content:imageURL" => "Image URL",

        "designunit:message:inprogress" => "Please wait...",
        "designunit:message:stored" => "Saved successfully!",
        "designunit:message:error" => "An error ocurred. Please refresh.",
        "designunit:message:advice" => "Changes to widget arrangements and widget contents are only applied after clicking this button!",

        "widget:quiz:overview" => "Overview",
        "widget:quiz:submittedanswers" => "Submitted answers",
        "widget:quiz:correctanswers" => "Correct answers",
        "widget:quiz:start" => "Start",
        "widget:quiz:submit" => "Submit",
        "widget:chat:join" => "Join Room",
        "widget:feedback:submit" => "Submit",
        "widget:feedback:submitted" => "Answer submitted!",

        "widget:general:deactivated" => "This widget is locked. Please work on the other widgets to unlock this widget.",
        "widget:general:unlock" => "Unlock",

        "widget:type:quiz" => "quiz",
        "widget:type:image" => "image",
        "widget:type:slides" => "slides",
        "widget:type:video" => "video",
        "widget:type:hangout" => "video conference",
        "widget:type:feedback" => "feedback form",

        "help:help" => "Help",
        "help:importantLinks" => "Important Links",
        "help:coursesDesc" => "A list of all the courses available.", 
        "help:info" => "For more information visit",
        "help:handbook" => "Handbook",
        "help:handbookLink" => "EN",
        "help:handbookDesc" => "A trainee handbook.",
    );
}
