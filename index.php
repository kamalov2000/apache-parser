<html>
<head>
    <meta charset="utf-8">
    <title>Stockfinder: Sign in</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div class="login-root">
    <div class="box-root flex-flex flex-direction--column" style="min-height: 100vh;flex-grow: 1;">
        <div class="loginbackground box-background--white padding-top--64">
            <div class="loginbackground-gridContainer">
                <div class="box-root flex-flex" style="grid-area: 8 / 4 / auto / 6;">
                    <div class="box-root box-background--gray100 animationLeftRight tans3s" style="flex-grow: 1;"></div>
                </div>

                <div class="box-root flex-flex" style="grid-area: 2 / 15 / auto / end;">
                    <div class="box-root box-background--cyan200 animationRightLeft tans4s" style="flex-grow: 1;"></div>
                </div>

                <div class="box-root flex-flex" style="grid-area: 3 / 14 / auto / end;">
                    <div class="box-root box-background--blue animationRightLeft" style="flex-grow: 1;"></div>
                </div>
            </div>
        </div>
        <div class="box-root padding-top--24 flex-flex flex-direction--column" style="flex-grow: 1; z-index: 9;">
            <div class="box-root padding-top--48 padding-bottom--24 flex-flex flex-justifyContent--center">
                <h1>
                    <a rel="dofollow">Stockfinder Log</a>
                </h1>
            </div>

            <div class="formbg-outer">
                <div class="formbg">
                    <div class="formbg-inner padding-horizontal--48">
                        <span class="padding-bottom--15">А ты узнал свои логи?</span>
                        <div class="form_container">

                            <div id="message"></div>

                            <form>
                            <div class="field padding-bottom--24">
                              <label>Введите имя до файла:</label>
                              <label>Пример использования: example_1.log</label>
                              <input type="text" name="firstName" id="firstName" value="example.log"/>
                            </div>

                            <div class="field padding-bottom--24">
                              <input id="submit" type="button" class="btn-submit" value="Submit" style="background: orange"/>
                            </div>

                            <div id="target" class="field padding-bottom--24"></div>

                            <div class="cssload-thecube">
                              <div class="cssload-cube cssload-c1"></div>
                              <div class="cssload-cube cssload-c2"></div>
                              <div class="cssload-cube cssload-c4"></div>
                              <div class="cssload-cube cssload-c3"></div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js.js"></script>
</body>

</html>
