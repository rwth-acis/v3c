<?php
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
 * @file menu.php
 * Navigation bar with links to other pages.
 */
?>
<?php
/*ob_start();
  Debugging with FireBug+FirePHP
  require_once '../php/fb.php';*/
  session_start();
  require_once '../config/config.php';
  require_once '../php/role_api.php';
  if(isset($_SESSION['access_token'])){
    $api = new RoleAPI("http://virtus-vet.eu:8081/", $_SESSION['access_token']);
    // Automated Role login if you are logged in at virtus.
    $api->login();
}
?>

<!-- jQuery -->
<script src="../external/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../external/bootstrap/dist/js/bootstrap.min.js"></script>
<link rel='stylesheet' type='text/css' href='../external/bootstrap/dist/css/bootstrap.min.css'>
<link rel="stylesheet" type='text/css' href="../external/bootstrap/dist/css/bootstrap-theme.min.css">
<!-- Bootstrap switch -->
<script src="../external/bootstrap-switch/dist/js/bootstrap-switch.min.js"></script>
<link rel='stylesheet' type='text/css' href='../external/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css'>
<!-- Bootstrap slider -->
<!--<script src="../external/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js"></script>-->
<!--<link rel='stylesheet' type='text/css' href='../external/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css'>-->
<!-- import JWS and JSRSASIGN -->
<script src="../external/jsrsasign/jws-3.3.min.js"></script>
<script src="../external/jsrsasign/jsrsasign-latest-all-min.js"></script>
<!-- Knockout -->
<script src='../external/knockoutjs/dist/knockout.js'></script>
<!-- URI.js -->
<script src='../external/uri.js/src/URI.min.js'></script>


<script src="../js/tools.js"></script>
<script src="../js/personality.js"></script>
<link rel='stylesheet' type='text/css' href='../css/style.css'>

<?php include("../php/localization.php"); ?>

<div class='navbar navbar-inverse'>
    <a href="https://github.com/rwth-acis/v3c"><img style="position: absolute; top: 0; right: 0; border: 0;"
        src="https://camo.githubusercontent.com/a6677b08c955af8400f44c6298f40e7d19cc5b2d/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f677261795f3664366436642e706e67"
        alt="Fork me on GitHub"
        data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_gray_6d6d6d.png"></a>
        <div class='container'>
            <div class='navbar-header'>
                <!-- Button for smallest screens -->

                <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#henm-nav-bar'>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                </button>
                <a href="welcome.php">
                    <img src='../images/virtus.png' class='head-logo' alt='Virtus V3C'>
                </a>
            </div>
            <div id='henm-nav-bar' class='collapse navbar-collapse'>
                <ul class='nav navbar-nav pull-right mainNav'>
                    <li><a href='welcome.php'><?php echo getTranslation("general:button:home", "Home");?></a></li>
                    <li><a href='subjects.php'><?php echo getTranslation("general:button:courses", "Courses");?></a></li>
                    <?php
                    require_once '../php/access_control.php';
                    $accessControl = new AccessControl();
                    ?>
                    <?php if ($accessControl->canEnterLecturerMode()): ?>
                      <li><a href='../php/phpbb_redirect.php'><?php echo getTranslation("general:button:forum", "Forum");?></a></li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['access_token'])): ?>
                        <form method="post" target="_blank" id="formID" style="float:left;" action="https://www.iscn.com/projects/piconew_skill_portal/capadv/virtus_login.php?oidc=<?php echo $_SESSION["access_token"]; ?>&org=<?php echo $accessControl->getUserOrganization()->name;?>" >
                            <li><a href="javascript:void(0);" onclick="$(this).closest('form').submit();"><?php echo getTranslation("general:button:LoginToECQA", "Login to ECQA");?></a></li>
                        </form>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['access_token'])): ?>
                      <li><a id="logout" href='../php/logout.php'><?php echo getTranslation("general:button:logout", "Logout");?></a></li>
                    <?php endif; ?>
                    <li>
                        <span id="signinButton">
                            <span class="oidc-signin"
                            data-callback="personality_signinCallback"
                            data-name="Learning Layers"
                            data-logo="https://raw.githubusercontent.com/learning-layers/LayersToolTemplate/master/extras/logo.png"
                            data-server="https://api.learning-layers.eu/o/oauth2"
                            data-clientid="<?php echo($oidcClientId); ?>"
                            data-scope="openid phone email address profile"></span>
                        </span>
                    </li>
            </ul>

            <select class="form-control" name="" id="select-lang">
                <?php
                $languages = getSelectableLanguages();
                foreach ($languages as $code => $language) {
                    echo $_SESSION["lang"];
                    $selected = ($_SESSION["lang"] == $code) ? "selected" : "";

                    echo "<option class='flag flag-$code' value='$code' $selected>$language</option>";
                }
                ?>
            </select>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#logout').click(function(){ 
        // Change to variable URL
        var wnd = window.open("https://api.learning-layers.eu/o/oauth2/logout");
        var timer = setInterval(function() {   
            if(wnd.location.href = "https://api.learning-layers.eu/o/oauth2/") {  
                clearInterval(timer);  
                wnd.close();
                window.location = "../php/logout.php";
            }  
        }, 100);
        return false; 
    });


    function updateQueryStringParameter(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        }
        return uri;
    }

    (function () {
        var po = document.createElement('script');
        po.type = 'text/javascript';
        po.async = true;
        po.src = '../js/oidc-button.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(po, s);
    })();

    $(document).ready(function () {

        var baseUrl = window.location.protocol + "//" + window.location.host;

        $("#select-lang").change(function () {
            var selectedLanguage = $(this).val();
            var url = baseUrl + "/src/php/set_language.php?setlang=" + selectedLanguage;
            $.ajax({
                url: url
            }).done(function () {
                var uri = updateQueryStringParameter(document.URL,"lang",selectedLanguage);
                uri = updateQueryStringParameter(uri,"ulang",selectedLanguage);
                window.location.href = uri;
            });
        });
    });
</script>
