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
        "general:button:home" => "Inicio",
        "general:button:courses" => "Cursos",
        "general:button:signin" => "Registrarse",
        "general:button:save" => "Guardar",
        "general:button:delete" => "Borrar",
        "general:button:remove" => "Eliminar",
        "general:button:edit" => "Editar",
        "general:button:yes" => "Sí",
        "general:button:no" => "No",
        "general:button:description" => "Descripción",
        "general:button:help" => "Ayuda",
        "general:button:manageUsers" => "Gestión de usuarios",

        "general:header:back" => "Πίσω",

        "general:footer:virtus" => "VIRTUS Virtual Vocational Training Centre",
        "general:footer:reach" => "Contáctenos en: ",
        "general:footer:erasmus" => "El presente proyecto ha sido financiado con el apoyo de la Comisión Europea. Esta publicación es responsabilidad exclusiva de su autor. La Comisión no es responsable del uso que pueda hacerse de la información aquí difundida.",

        "main:welcome:courses" => "Módulo",
        "main:welcome:headline" => "¡Bienvenido al proyecto V3C!",
        "main:subjects:subject" => "Temas",
        "main:welcome:v3cgoal" => "El proyecto “Virtual Vocational Education and Training – VIRTUS” desarrollará un innovador y totalmente funcional centro virtual de educación y formación profesional, que ofrecerá cursos certificados de diseño modular en MEC (Competencias Modulares para el Empleo), de acuerdo a las circunstancias actuales como el crecimiento regional y/o la reestructuración de empresas, y con el objetivo de aumentar la tasa de participación del alumnado adulto en la formación profesional",
        "main:welcome:v3ccourses" => "En concreto, el centro virtual de EFP proporcionará dos cursos modulares certificados en:",
        "main:welcome:tourism" => "Servicios de Turismo y Hospedaje",
        "main:welcome:social" => "Emprendimiento Social",
        "main:welcome:listcourses" => "Consulte la lista de todos los módulo disponibles aquí.",

        "addcourse:add:create" => "Crear un nuevo módulo",
        "addcourse:content:name" => "Nombre del módulo:",
        "addcourse:placeholder:name" => "Introduzca el nombre de su módulo",
        "addcourse:content:language" => "Idioma predeterminado",
        "addcourse:content:domain" => "Dominio del módulo:",
        'addcourse:placeholder:domain' => 'Ingrese el dominio de su módulo',
        "addcourse:content:profession" => "Profesión del módulo:",
        'addcourse:placeholder:profession' => 'Introduzca la profesión de su módulo',
        "addcourse:content:desription" => "Descripción:",
        'addcourse:placeholder:description' => 'Introduzca la descripción del módulo',

        "course:content:courseunits" => "Unidades del módulo",
        "course:content:enterroom" => "Entrar al módulo",
        "course:content:createdby" > "Creado por:",
        "course:content:domain" => "Dominio:",
        "course:content:profession" => "Profesión:",
        "course:content:description" => "Descripción:",

        "coursedel:head:name" => "Eliminar módulo {COURSENAME}",
        "coursedel:head:name_tmp" => "Eliminar módulo ",
        "coursedel:head:confirm" => "¿Realmente desea eliminar el módulo {COURSENAME}?",
        "coursedel:head:confirm_tmp1" => "¿Realmente desea eliminar el módulo ",
        "coursedel:head:confirm_tmp2" => "?",

        "courselist:head:subcourses" => "{SUBJECT} módulo",
        "courselist:head:subcourses_tmp" => " módulo",
        "courselist:head:add" => "Añadir nuevo módulo",
        "courselist:head:search" => "Buscar",
        "courselist:choose:choose" => "Elija el módulo",
        "courselist:choose:name" => "Nombre del módulo",
        "courselist:choose:creator" => "Creado por",
        "courselist:choose:start" => "Fecha de Inicio",
        "courselist:choose:description" => "Descripción",

        "courselist:admin:translate" => "Traducir a",
        "courselist:admin:edit" => "Editar",
        "courselist:admin:delete" => "Borrar",

        "editcourse:head:edit" => "Editar su módulo",
        "editcourse:edit:name" => "Nombre del módulo:",
        "editcourse:edit:domain" => "Dominio del módulo:",
        "editcourse:edit:profession" => "Profesión del módulo:",
        "editcourse:edit:description" => "Descripción:",
        "editcourse:edit:design" => "Diseñar un entorno de aprendizaje",
        "editcourse:units:add" => "Añadir Unidad al módulo",

        "editcourseunit:edit:name" => "Nombre de la Unidad del módulo:",
        "editcourseunit:edit:points" => "Puntos ECVET:",
        "editcourseunit:edit:startdate" => "Fecha de Inicio:",
        "editcourseunit:edit:description" => "Descripción:",

        "overview:head:gallery" => "Galería",

        "usermanagement:choose:family_name" => "Apellido",
        "usermanagement:choose:given_name" => "Name",
        "usermanagement:choose:role" => "Rol",
        "usermanagment:choose:affiliation" => "Asociarse",
        "usermanagement:button:update" => "Actualizar usuario",
        "usermanagement:search:name" => "Buscar por nombre",

        "designunit:head:title" => "Editar unidad del módulo",
        "designunit:content:addcontent" => "Añadir contenidos",
        "designunit:content:uploadfile" => "Cargar archivo",
        "designunit:content:apply" => "Aplicar",
        "designunit:content:slideswidget" => "Widget diapositivas",
        "designunit:content:videowidget" => "Widget Video",
        "designunit:content:imagewidget" => "Widget imagen",
        "designunit:content:hangoutwidget" => "Widget Video Conferencia",
        "designunit:content:quizwidget" => "Widget Juegos",
        "designunit:content:title" => "Título",
        "designunit:content:link" => "Link",
        "designunit:content:videolink" => "Video or Audio",
        "designunit:content:questions" => "Preguntas",
        "designunit:content:addquestion" => "Añadir pregunta",
        "designunit:content:question" => "Pregunta",
        "designunit:content:answers" => "Respuestas",
        "designunit:content:answer" => "Respuesta",
        "designunit:content:addanswer" => "Añadir respuesta",
        "designunit:content:save" => "Guardar cambios",
        "designunit:content:toolbox" => "Caja de herramientas",
        "designunit:content:rolespace" => "Espacio ROL",
        "designunit:content:addtoflow" => "Añadir al flujo",
        "designunit:content:removefromflow" => "Quitar del flujo",
        "designunit:content:imageURL" => "Imagen URL",

        "designunit:message:inprogress" => "Por favor espere...",
        "designunit:message:stored" => "Guardado con éxito!",
        "designunit:message:error" => "Ha ocurrido un error. Por favor actualice",
        "designunit:message:advice" => "¡Los cambios de los widget y los contenidos del widget solo se aplicarán después de pinchar en este botón!",

        "widget:quiz:overview" => "vista de conjunto",
        "widget:quiz:submittedanswers" => "Enviar respuestas",
        "widget:quiz:correctanswers" => "Corregir respuestas",
        "widget:quiz:start" => "Inicio",
        "widget:quiz:submit" => "Enviar",
        "widget:chat:join" => "Unirse a la sala",
        "widget:feedback:submit" => "Enviar",
        "widget:feedback:submitted" => "Respuesta enviada!",

        "widget:general:deactivated" => "Este widget está cerrado. Por favor trabaja en los otros widgets para desbloquear este widget.",
        "widget:general:unlock" => "Desbloquear",

        "widget:type:quiz" => "Prueba",
        "widget:type:image" => "imagen",
        "widget:type:slides" => "transparencias",
        "widget:type:video" => "video",
        "widget:type:hangout" => "video conferencia",
        "widget:type:feedback" => "formulario de feedback"
    );
}