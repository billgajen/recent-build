<!DOCTYPE html>
<!--[if IEMobile 7 ]>    <html class="no-js iem7"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>SYZYGY - Timesheet - on the go!</title>
        <meta name="description" content="">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta http-equiv="cleartype" content="on">

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/touch/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/touch/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/touch/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="img/touch/apple-touch-icon-57x57-precomposed.png">
        <link rel="shortcut icon" href="img/touch/apple-touch-icon.png">

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <!-- This script prevents links from opening in Mobile Safari. https://gist.github.com/1042026 -->
        <!--
        <script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script>
        -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="jqmobile/jquery.mobile-1.2.0.min.css">
        <script src="jqmobile/jquery-1.8.2.min.js"></script>
        <!--<script src="jqmobile/jquery.mobile-1.2.0.min.js"></script>!-->
        <script src="js/vendor/modernizr-2.6.1.min.js"></script>
    </head>
    <body>
    <div class="container">
        <ul class="slide-container">
            <li class="step1">
                <section>
                    <header>
                        <hgroup>
                            <h1>SYZYGY</h1>
                            <h2>TIMESHEET</h2>
                            <h3>-! on the go !-</h3>
                        </hgroup>
                    </header>
                    <div class="message"></div>
                    <form action="php/login.php" method="post" id="login" name="login">  
                        <input id="username" name="username" type="text" placeholder="Username" />  
                        <input id="password" name="password" type="password" placeholder="Password" />  
                        <input type="button" class="button" value="Submit" />  
                        <!-- <input type="submit" class="button" value="Submit"  style="opacity:0; margin-left=-9999px" /> -->  
                    </form> 
                </section>
            </li>
            <li class="step2">
                <section>
                    <header>
                        <div class="logo"><span>-! on the go !-</span></div>
                        <div class="session">
                                <a href='#' id='logout'>Logout</a>
                                <h2></h2>
                        </div>
                    </header>
                    <div class="time-message"></div>
                    <ul class="form-selector">
                        <li>
                            <p>Select your date or week to enter</p>
                            <form class="open" action="php/timesheet.php" method="" id="date-picker">
                                <lable>Select Day:</lable>
                                <input type="date" id="single-day" placeholder="yyyy-mm-dd" />
                                <lable>Select a Week (First day)</lable>
                                <input type="date" id="week" placeholder="yyyy-mm-dd" />
                                <input type="button" class="getData" value="Submit" />
                            </form>
                        </li>
                        <li>
                            <p>Enter times by job code</p>
                            <form action="" method="post" id="enter-manual">
                                <lable>Date:</lable>
                                <input type="date" id="mdate" name="mdate" />
                                <lable>Jobcode:</lable>
                                <input type="text" id="jobcode" name="jobcode" />
                                <lable>Hours:</lable>
                                <input type="range" name="slider" id="hours" value="0" min="0.50" max="8.00" />
                                <input type="button" class="add-by-jobcode" value="Submit" />
                            </form>
                        </li>
                    </ul>
                </section>
            </li>
            <li class="step3">
                <section>
                    <header>
                        <div class="logo"><span>-! on the go !-</span></div>
                        <a class="back">Back</a>
                    </header>
                    <div class="auto-message">
                        <div class="update-message"></div>
                    </div>
                </section>
            </li>
        </ul>
<!--         <div class="quick-add">
            <form action="" method="post" id="enter-auto">
                <lable>Hours:</lable>
                <input type="text" id="addedhours" value="" />
                <input type="button" class="auto-add" value="Submit" />
            </form>
        </div>
 -->    </div>
    <script src="js/vendor/zepto.min.js"></script>
    <script src="js/helper.js"></script>
    <script src="js/main.js"></script>

    </body>
</html>
