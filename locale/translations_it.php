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
        "general:button:home" => "Pagina iniziale",
        "general:button:courses" => "Corsi",
        "general:button:signin" => "Registrati",
        "general:button:save" => "Salvare",
        "general:button:delete" => "Cancellare",
        "general:button:remove" => "Remove",
        "general:button:edit" => "Modifica",
        "general:button:yes" => "Sì",
        "general:button:no" => "No",
        "general:button:description" => "Descrizione",
        "general:button:help" => "Aiuto",
        "general:button:manageUsers" => "Manage Users",

        "general:header:back" => "Back",

        "general:footer:virtus" => "VIRTUS Virtual Vocational Training Centre",
        "general:footer:reach" => "Per raggiungerci a: ",
        "general:footer:erasmus" => "Il presente progetto è finanziato con il sostegno della Commissione europea. L’autore è il solo responsabile di questa pubblicazione e la Commissione declina ogni responsabilità sull’uso che potrà essere fatto delle informazioni in essa contenute. ",

        "main:welcome:headline" => "Benvenuti al Progetto V3C!",
        "main:welcome:v3cgoal" => "Il “Virtual Vocational Education and Training – VIRTUS” progetto svilupperà un innovativo, perfettamente funzionante professionale centro di istruzione e di formazione virtuale, che fornirà opportunamente progettato corsi certificati modulari componibili occupabili Skills (MES), corrispondente ad una vasta gamma di circostanze come potenziale regionale di crescita e / o ristrutturazione aziendale e l'obiettivo di aumentare il tasso di partecipazione dei discenti adulti in materia di istruzione e formazione professionale.",
        "main:welcome:v3ccourses" => "In particolare, il centro VET virtuale fornire due corsi certificati modulari su:",
        "main:welcome:tourism" => "Turismo e Ospitalità Servizi",
        "main:welcome:social" => "Imprenditoria sociale",
        "main:welcome:courses" => "Corsi",
        "main:welcome:listcourses" => "Controllare l'elenco di tutti i corsi disponibili qui.",

        "main:subjects:subject" => "Soggetti",

        "addcourse:add:create" => "Creare un nuovo corso",
        "addcourse:content:name" => "Nome del corso:",
        "addcourse:placeholder:name" => "Inserisci il tuo nome del corso",
        "addcourse:content:language" => "Default language",
        "addcourse:content:domain" => "Dominio del corso:",
        "addcourse:placeholder:domain" => "Inserisci il tuo dominio corso",
        "addcourse:content:profession" => "Professione Corso:",
        "addcourse:placeholder:profession" => "Inserisci la tua professione corso",
        "addcourse:content:desription" => "Descrizione:",
        "addcourse:placeholder:description" => "Inserisci descrizione del corso",

        "course:content:courseunits" => "Unità di corso",
        "course:content:enterroom" => "Entra nella stanza del corso",
        "course:content:createdby" > "Creato da:",
        "course:content:domain" => "Dominio:",
        "course:content:profession" => "Professione:",
        "course:content:description" => "Descrizione:",

        "coursedel:head:name" => "Eliminare corso {COURSENAME}",
        "coursedel:head:name_tmp" => "Eliminare corso ",
        "coursedel:head:confirm" => "Vuoi davvero eliminare corso {COURSENAME}?",
        "coursedel:head:confirm_tmp1" => "Vuoi davvero eliminare corso ",
        "coursedel:head:confirm_tmp2" => "?",

        "courselist:head:subcourses" => "{SUBJECT} corsi",
        "courselist:head:subcourses_tmp" => " corsi",
        "courselist:head:add" => "Aggiungere nuovo corso",
        "courselist:head:search" => "Search",
        "courselist:choose:choose" => "Scegli corso",
        "courselist:choose:name" => "Nome del corso",
        "courselist:choose:creator" => "Creato da",
        "courselist:choose:start" => "Date d'inizio",
        "courselist:choose:description" => "Description",

        "courselist:admin:translate" => "Translate to",
        "courselist:admin:edit" => "Edit",
        "courselist:admin:delete" => "Delete",

        "editcourse:head:edit" => "Modificare la Corso",
        "editcourse:edit:name" => "Nome del corso:",
        "editcourse:edit:domain" => "Dominio del corso:",
        "editcourse:edit:profession" => "Professione Corso:",
        "editcourse:edit:description" => "Descrizione:",
        "editcourse:edit:design" => "Ambiente di apprendimento di progettazione",
        "editcourse:units:add" => "Add Course Unit",

        "editcourseunit:edit:name" => "Course unit name:",
        "editcourseunit:edit:points" => "ECVET Points:",
        "editcourseunit:edit:startdate" => "Start Date:",
        "editcourseunit:edit:description" => "Description:",

        "overview:head:gallery" => "Galleria",

        "usermanagement:choose:family_name" => "Family Name",
        "usermanagement:choose:given_name" => "Given Name",
        "usermanagement:choose:role" => "Role",
        "usermanagment:choose:affiliation" => "Affiliation",
        "usermanagement:button:update" => "Update User",
        "usermanagement:search:name" => "Search by name",

        "designunit:head:title" => "Edit Course Unit",
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
        "widget:type:feedback" => "feedback form"

    );
}
