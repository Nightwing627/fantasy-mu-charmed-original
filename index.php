<?php

if (!defined('access') || !access) {
	exit();
}

define('__RESPONSIVE__', 'TRUE');
include 'inc/template.functions.php';
$templateConfig = loadConfigurations('template.config');
echo "\n" . '<!DOCTYPE html>' . "\n" . '<html>' . "\n" . '<head>' . "\n" . '    ';
echo $handler->printHeader();
echo '    <meta charset="UTF-8">' . "\n" . '    <meta http-equiv="X-UA-Compatible" content="IE=edge">' . "\n" . '    <meta name="viewport" content="width=device-width, initial-scale=1">' . "\n" . '    <link href="';
echo __PATH_TEMPLATE__;
echo 'css/colors.css?v=5" rel="stylesheet">' . "\n" . '    <link href="';
echo __PATH_TEMPLATE__;
echo 'css/bootstrap.min.css?v=3" rel="stylesheet">' . "\n" . '    <link href="';
echo __PATH_TEMPLATE__;
echo 'css/normalize.css" rel="stylesheet">' . "\n" . '    ';
echo '    <link href="';
echo __PATH_TEMPLATE_ASSETS__;
echo 'fontawesome5/css/all.min.css" rel="stylesheet">' . "\n" . '    ';
echo '    <link href="';
echo __PATH_TEMPLATE__;
echo 'css/mucms.css?v=61" rel="stylesheet">' . "\n" . '    <link href="';
echo __PATH_TEMPLATE__;
echo 'css/style.css" rel="stylesheet">' . "\n" . '    <link href="';
echo __PATH_TEMPLATE__;
echo 'css/verticalCarousel.css" rel="stylesheet">' . "\n" . '    <link href="';
echo __PATH_TEMPLATE__;
echo 'css/flag-icon.min.css" rel="stylesheet"/>' . "\n" . '    <link href="';
echo __PATH_TEMPLATE__;
echo 'css/main.css?v=1" rel="stylesheet">' . "\n" . '    <link href="';
echo __PATH_TEMPLATE__;
echo 'css/custom.css?v=2" rel="stylesheet">' . "\n" . '    <!--[if gte IE 9]' . "\n" . '        <style type="text/css">.gradient { filter: none;}</style>' . "\n" . '    <![endif]-->' . "\n" . '    <script src="';
echo __PATH_TEMPLATE__;
echo 'js/jquery.min.js"></script>' . "\n\n" . '    ';
include_once 'inc/modules/google_analytics.php';
echo "\n" . '    ';
if ($config['show_countdown'] && ($date < $config['countdown_date'])) {
	echo '        <script type="text/javascript">' . "\n" . '            $(document).ready(function () {' . "\n" . '                var days, hours, minutes, seconds;' . "\n" . '                var targetTime = ';
	echo strtotime($config['countdown_date']);
	echo ';' . "\n" . '                var addSec = 0;' . "\n\n" . '                setInterval(function () {' . "\n" . '                    var serverTime = ';
	echo time();
	echo ';' . "\n" . '                    serverTime = serverTime + addSec;' . "\n" . '                    var countdown = targetTime - serverTime;' . "\n\n" . '                    days = parseInt(countdown / 86400);' . "\n" . '                    countdown = countdown % 86400;' . "\n" . '                    hours = parseInt(countdown / 3600);' . "\n" . '                    countdown = countdown % 3600;' . "\n" . '                    minutes = parseInt(countdown / 60);' . "\n" . '                    seconds = parseInt(countdown % 60);' . "\n\n" . '                    $("#days").html(days);' . "\n" . '                    $("#hours").html(hours);' . "\n" . '                    $("#minutes").html(minutes);' . "\n" . '                    $("#seconds").html(seconds);' . "\n\n" . '                    addSec++;' . "\n" . '                }, 1000);' . "\n" . '            });' . "\n" . '        </script>' . "\n" . '    ';
}

echo '</head>' . "\n" . '<body>' . "\n" . '<div class="wrapper">' . "\n" . '    <nav id="main-navbar" class="navbar navbar-default navbar-fixed-top">' . "\n" . '        <div class="container semi-fluid">' . "\n" . '            ';
include 'inc/modules/navigation.php';
echo '        </div>' . "\n" . '    </nav>' . "\n" . '    ';

if ($templateConfig['slider'] == '1') {
	include 'inc/modules/slider.php';
	$contentPaddingWithoutSlider = '';
}
else {
	$contentPaddingWithoutSlider = ' contentPaddingWithoutSlider';
}

echo '    <div class="container semi-fluid';
echo $contentPaddingWithoutSlider;
echo '">' . "\n\n" . '        ';
$date = date('Y/m/d H:i', time());
if ($config['show_countdown'] && ($date < $config['countdown_date'])) {
	if ($templateConfig['countdown_position'] == 'center') {
		$countdownPos = ' col-md-offset-4';
	}
	else if ($templateConfig['countdown_position'] == 'left') {
		$countdownPos = '';
	}
	else if ($templateConfig['countdown_position'] == 'right') {
		$countdownPos = ' col-md-offset-8';
	}

	$countdownClass = 'index-countdown-' . $templateConfig['countdown_position'];
	echo '            <div class="row">' . "\n" . '                <div class="col-xs-12 col-md-4';
	echo $countdownPos . ' ' . $countdownClass;
	echo ' ">' . "\n" . '                    <div class="col-xs-12 index-countdown-title">' . "\n" . '                        ';
	echo lang('res_template_txt_41', true);
	echo '                    </div>' . "\n" . '                    <div class="col-xs-3 timer-bg">' . "\n" . '                        <div id="days" class="timer-number"></div>';
	echo lang('res_template_txt_37', true);
	echo '                    </div>' . "\n" . '                    <div class="col-xs-3 timer-bg">' . "\n" . '                        <div id="hours" class="timer-number"></div>';
	echo lang('res_template_txt_38', true);
	echo '                    </div>' . "\n" . '                    <div class="col-xs-3 timer-bg">' . "\n" . '                        <div id="minutes" class="timer-number"></div>';
	echo lang('res_template_txt_39', true);
	echo '                    </div>' . "\n" . '                    <div class="col-xs-3 timer-bg">' . "\n" . '                        <div id="seconds" class="timer-number"></div>';
	echo lang('res_template_txt_40', true);
	echo '                    </div>' . "\n" . '                </div>' . "\n" . '            </div>' . "\n" . '        ';
}

echo "\n" . '        ';
include_once 'inc/modules/topbar.php';
echo "\n" . '        <div class="row">' . "\n" . '            <div id="content-wrapper">' . "\n" . '                ';

if (isSidebar()) {
	echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">';
	include 'inc/modules/announcement.php';
}
else {
	echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
}

echo '<div class="content-box">';

if (isHome()) {
	include 'inc/modules/home.php';
}
else {
	$handler->loadModule($_REQUEST['page'], $_REQUEST['subpage']);
}

echo '</div></div>';
echo "\n" . '                ';

if (isSidebar()) {
	echo '<div class="sidebar col-xs-12 col-sm-12 col-md-12 col-lg-3">';
	include 'inc/modules/sidebar.php';
	echo '</div>';
}

echo '            </div>' . "\n" . '        </div>' . "\n" . '    </div>' . "\n" . '    <div class="container semi-fluid">' . "\n" . '        <footer>' . "\n" . '            <div class="row quick-nav-footer">' . "\n" . '                ';
include 'inc/modules/footer.php';
echo '            </div>' . "\n" . '            ';
$handler->mucmsPoweredResponsive();
echo '        </footer>' . "\n" . '    </div>' . "\n" . '</div>' . "\n" . '</body>' . "\n\n" . '<script src="';
echo __PATH_TEMPLATE__;
echo 'js/bootstrap.min.js"></script>' . "\n" . '<script type="text/javascript" src="';
echo __PATH_TEMPLATE__;
echo 'js/global_functions.js"></script>' . "\n" . '<script src="';
echo __PATH_TEMPLATE__;
echo 'js/verticalCarousel.js"></script>' . "\n" . '<script src="';
echo __PATH_TEMPLATE__;
echo 'js/template.js?v=16"></script>' . "\n" . '<!--[if lt IE 9]>' . "\n" . '<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>' . "\n" . '<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>' . "\n" . '<![endif]-->' . "\n" . '<script type="text/javascript">' . "\n" . '    const baseUrl = "';
echo __BASE_URL__;
echo '";' . "\n\n" . '    $(function () {' . "\n" . '        // Initiate Server Time' . "\n" . '        serverTime.init("footerServerTime", "footerLocalTime");' . "\n" . '    });' . "\n" . '</script>' . "\n" . '</html>' . "\n";

?>