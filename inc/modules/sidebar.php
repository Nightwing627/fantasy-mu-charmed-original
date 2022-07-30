<?php

if ($config["language_switch_active"]) {
    echo '
<div class="row hidden-xs">
    <div class="col-xs-12 text-center">
        <span class="footerLang">
        ' . lang('res_template_txt_27', true) . '&nbsp;';

    foreach ($config["languages"] as $thisLang) {
        echo '<a href="' . __BASE_URL__ . 'language/switch/?to=' . $thisLang[1] . '" data-toggle="tooltip" data-placement="bottom" title="' . $thisLang[0] . '"><img src="' . __PATH_TEMPLATE__ . 'images/blank.png" class="flag-icon flag-icon-' . $thisLang[2] . ' footerFlag" alt="' . $custom['countries'][$thisLang[2]] . '" title="' . $thisLang[0] . '" /></a> ';
    }

    echo '
        </span>
    </div>
</div>';
}

?>

<div class="panel panel-default quick-link-home-panel">
    <div class="panel-body">
        <ul>
            <?php if (isLoggedIn()) { ?>
                <a href="<?= __BASE_URL__ ?>usercp">
                    <li>
                        <div class="icon"><i class="glyphicon glyphicon-fire"></i></div>
                        <div class="content">
                            <span class="title link-color"><?php echo lang('res_template_txt_18', true); ?></span>
                            <span class="text"><?php echo lang('res_template_txt_19', true); ?></span>
                        </div>
                    </li>
                </a>
                <a href="<?= __BASE_URL__ ?>logout">
                    <li>
                        <div class="icon"><i class="glyphicon glyphicon-log-out"></i></div>
                        <div class="content">
                            <span class="title link-color"><?php echo lang('res_template_txt_20', true); ?></span>
                            <span class="text"><?php echo lang('res_template_txt_21', true); ?></span>
                        </div>
                    </li>
                </a>
            <?php } else { ?>
                <a href="<?= __BASE_URL__ ?>login">
                    <li>
                        <div class="icon"><i class="glyphicon glyphicon-log-in"></i></div>
                        <div class="content">
                            <span class="title link-color"><?php echo lang('res_template_txt_22', true); ?></span>
                            <span class="text"><?php echo lang('res_template_txt_23', true); ?></span>
                        </div>
                    </li>
                </a>
            <?php } ?>
        </ul>
    </div>
</div>

<div class="panel panel-default server-info-home-panel">
    <div class="panel-body">
        <form action="<?= __BASE_URL__ ?>search" method="post" id="search">
            <div class="row">
                <div class="col-xs-12 col-md-8">
                    <input type="text" name="charname" class="form-control" maxlength="10" title="<?php echo lang('template_txt_29', true); ?>"
                           placeholder="<?php echo lang('template_txt_29', true); ?>">
                </div>
                <div class="col-xs-12 col-md-4">
                    <input type="submit" name="search" value="<?php echo lang('search_txt_6', true); ?>" class="btn btn-warning full-width-btn"/>
                </div>
            </div>
        </form>
    </div>
</div>

<?php

$maxOnline = $templateConfig['server_max_online'];
$activePlayers = LoadCacheData('active_players.cache');

echo '
<div class="panel panel-default server-info-home-panel">
    <div class="panel-heading">
        <h3 class="panel-title">' . lang('res_template_txt_32', true) . '</h3>
    </div>
    <div class="panel-body">
        <script type="text/javascript">
            function loadServerStatus() {
                $(\'#serverstatus\').load(\'' . __BASE_URL__ . 'ajax/server_online.php\', function() {
                    var totalOnline = $(\'#totalOnlineVal\').html();
                    if (totalOnline == undefined || totalOnline == null) {
                        totalOnline = 0;
                    }
                    $(\'#totalOnline\').html(totalOnline);
                    var maxOnline = ' . $maxOnline . ';
                    var onlinePerc = Math.round((100 * totalOnline) / maxOnline);
                    $(\'#onlineBar\').attr(\'aria-valuenow\', "" + parseInt(onlinePerc) + "");
                    $(\'#onlineBar\').css(\'width\', "" + parseInt(onlinePerc) + "%");
                    $(\'#onlineBarLabel\').html("" + parseInt(onlinePerc) + "%");
                });
            }
            
            $(document).ready(function() {
                loadServerStatus();
                setInterval(loadServerStatus, 30000);
            });
        </script>
        <ul class="sidebar-list panel-listing">
            <li>' . lang('res_template_txt_30', true) . ' <span class="pull-right" id="serverstatus"><span class="status-online"></span></span></li>
            <li>
                ' . lang('res_template_txt_31', true) . '
                <span class="pull-right" id="totalOnline">0</span>
                <div class="progress panel-progress-bar clear-radius">
                    <div id="onlineBar" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="' . $maxOnline . '" style="width: 0%;">
                        <span class="sr-only" id="onlineBarLabel">0%</span>
                    </div>
                </div>
            </li>
            <li>' . lang('res_template_txt_42', true) . ' <span class="pull-right">' . $activePlayers[1][0] . '</span></li>
        </ul>
    </div>
</div>';

echo '
<div class="panel panel-default server-info-home-panel">
    <div class="panel-heading">
        <h3 class="panel-title">' . lang('template_txt_30', true) . '</h3>
    </div>
    <div class="panel-body">
        <ul class="sidebar-list panel-listing">
            <li>' . lang('template_txt_31', true) . ' <span class="pull-right">Season 16</span></li>
            <li>' . lang('template_txt_34', true) . ' <span class="pull-right">Hard</span></li>
            <li>' . lang('template_txt_32', true) . ' <span class="pull-right">5x</span></li>
            <li>' . lang('template_txt_35', true) . ' <span class="pull-right">920</span></li>
            <li>' . lang('res_template_txt_33', true) . ' <span class="pull-right">65 535</span></li>
        </ul>
    </div>
</div>';

$castleData = LoadCacheData('castle_siege.cache');
$castleSiege = $dB->query_fetch_single("SELECT TOP 1 * FROM MuCastle_DATA");
$siegeStart = $castleSiege['SIEGE_START_DATE'];

$csSettings = loadConfigurations('castlesiege');
$now = time();

$csstartTime = explode(":", $csSettings['cs_period_start_time']);
$siegeStartCSStart = strtotime($siegeStart) + ($csSettings['cs_period_start_day'] * 86400) + ($csstartTime[0] * 3600) + ($csstartTime[1] * 60);
$periodCSStart = date('Y-m-d H:i', $siegeStartCSStart);

if ($siegeStartCSStart <= $now) {
    $siegeStartCSStart = strtotime($siegeStart) + ($csSettings['cs_period_start_day'] * 86400) + ($csstartTime[0] * 3600) + ($csstartTime[1] * 60) + ($csSettings['cs_period_cycle_day'] * 86400);
    $periodCSStart = date('Y-m-d H:i', $siegeStartCSStart);
}

$periodCSStart = strtotime($periodCSStart);

echo '
<div class="panel panel-default server-info-home-panel">
    <div class="panel-heading">
        <h3 class="panel-title">' . lang('castlesiege_txt_1', true) . '
            <a href="' . __BASE_URL__ . 'castlesiege" class="btn-simple btn-icon-plus pull-right"></a>
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-3">
                ' . returnGuildLogo($castleData[1][1], 48) . '
            </div>
            <div class="col-xs-9">
                <table width="100%">
                    <tr>
                        <td>' . lang('template_txt_6', true) . ':</td>
                        <td align="right"><b>' . $common->replaceHtmlSymbols($castleData[1][0]) . '</b></td>
                    </tr>
                    <tr>
                        <td>' . lang('template_txt_7', true) . ':</td>
                        <td align="right"><b>' . $common->replaceHtmlSymbols($castleData[1][6]) . '</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <hr class="tiny">
    <div class="row">
        <div class="col-xs-12" style="text-align: center; font-size: 1.2em;">
            ' . lang('template_txt_10', true) . ' ' . date($config["time_date_format"], $periodCSStart) . '
        </div>
    </div>
</div>';
?>

<!-- <?php include_once('icewindvalley_widget-enc.php'); ?>


<?php include_once('arkawar_widget-enc.php'); ?> -->

<?php
$Items = new Items();
$Market = new Market();
$Auction = new Auction();
echo '<script type="text/javascript" src="' . __PATH_TEMPLATE_ASSETS__ . 'js/mucms-tooltip.js" data-assets="' . __PATH_TEMPLATE_ASSETS__ . '"></script>';
$tooltipRelPath = prepareTooltipPath();
?>
<div class="panel panel-default server-info-home-panel">
    <div id="carousel-market-auction" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <!-- LATEST MARKET ITEMS -->
            <div class="item active">
                <section>
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo lang('template_txt_43', true); ?><a href="<?php echo __BASE_URL__ . 'usercp/market/' ?>" class="btn-simple btn-icon-plus pull-right"></a>
                        </h3>
                    </div>
                    <div class="panel-body panel-body-items">
                        <?php
                        $latestItems = $Market->getLatestMarketItems();
                        if (is_array($latestItems)) {
                            echo '<table class="table-body-items">';
                            foreach ($latestItems as $item) {
                                $itemInfo = $Items->ItemInfoMin($item['item']);
                                $itemThumb = $Items->ItemThumb($item['item']);
                                echo '
                                <tr>
                                    <td align="left">
                                        <span style="cursor:pointer;" title="ajax:' . $tooltipRelPath . 'ajax/item_tooltip.php?hex=' . $item['item'] . '&type=1&serial=1&details=1&opts=1&exp=0&exptime=0">' . $itemInfo['Name'] . '</span>
                                    </td>
                                    <td align="right">' . $Market->showPrice($item['price_type'], $item['price']) . '</td>
                                </tr>';
                            }
                            echo '</table>';
                        }
                        ?>
                    </div>
                </section>
                <div class="carousel-caption"></div>
            </div>
            <!-- LATEST MARKET ITEMS -->

            <!-- LATEST AUCTIONS -->
            <?php
            $auctions = $Auction->getLatestAuctions();
            $auctionsSlides = '';
            $auctionsSlidesIndex = 1;
            if (is_array($auctions)) {
                foreach ($auctions as $thisAuction) {
                    $currentBid = $Auction->getCurrentBid($thisAuction['id']);
                    $totalBids = $Auction->getTotalBids($thisAuction['id']);
                    $currency = $Auction->getCurrencyName($thisAuction['currency']);
                    $items = $Auction->getItems($thisAuction['id']);

                    $auctionsSlides .= '<li data-target="#carousel-market-auction" data-slide-to="' . $auctionsSlidesIndex . '"></li>';

                    if (is_array($items)) {
                        $itemsTxt = '';
                        $totalWidth = 0;
                        $moreItems = 0;
                        foreach ($items as $thisItem) {
                            $itemInfo = $Items->ItemInfoMin($thisItem['item']);
                            $itemThumb = $Items->ItemThumb($thisItem['item']);
                            $width = ($itemInfo['X'] * 32) / 1.5;
                            $height = ($itemInfo['Y'] * 32) / 1.5;
                            $totalWidth += $itemInfo['X'];
                            $width2 = $width + 20;
                            $padding = (85 - $height) / 2;
                            if ($totalWidth <= 6) {
                                $itemsTxt .= '
                            <div class="auction-widget-item" title="ajax:' . $tooltipRelPath . 'ajax/item_tooltip.php?hex=' . $thisItem['item'] . '&type=1&serial=1&details=1&opts=1&exp=0&exptime=0">
                                <img src="' . $itemThumb . '" height="' . $height . 'px" style="top: ' . $padding . 'px">
                            </div>';
                            } else {
                                $moreItems++;
                            }
                        }
                    }

                    echo '
            <div class="item">
                <section>
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            ' . lang('auction_txt_28', true) . '
                            <a href="' . __BASE_URL__ . 'usercp/auction/' . '" class="btn-simple btn-icon-plus pull-right"></a>
                        </h3>
                    </div>
                    <div class="panel-body panel-body-items auction-widget-body">
                        <div class="items-inventory-item-bg">
                            <div class="auction-widget-title">' . $thisAuction['name'] . '</div>
                            ' . $itemsTxt;

                    if ($moreItems > 0) {
                        echo '<div class="auction-widget-more-items">' . sprintf(lang('auction_txt_30', true), $moreItems) . '</div>';
                    }

                    echo '
                            <div class="auction-widget-current-bid">' . lang('auction_txt_5', true) . ': <b>' . number_format($currentBid) . ' ' . $currency . '</b> (' . sprintf(lang('auction_txt_6', true), $totalBids) . ')</div>
                        </div>
                    </div>
                </section>
                <div class="carousel-caption"></div>
            </div>';

                    $auctionsSlidesIndex++;
                }
            }
            ?>
            <!-- LATEST AUCTIONS -->
        </div>

        <ol class="carousel-indicators">
            <li data-target="#carousel-market-auction" data-slide-to="0" class="active"></li>
            <?php echo $auctionsSlides; ?>
        </ol>
    </div>
</div>

<?php
$bossTimerCfg = loadConfigurations('bosstimer');
if ($bossTimerCfg['active']) {
    ?>
    <script type="text/javascript">
        var bossTimerDataJSON = null;

        function getBossData() {
            $.getJSON('<?php echo __BASE_URL__; ?>ajax/boss_timer.php', function (data) {
                bossTimerDataJSON = data;
                updateBossData();
            });
        }

        function updateBossData() {
            var newTimers = '';
            var showKiller = '<?php echo $bossTimerCfg['show_killer']; ?>';
            var showDate = '<?php echo $bossTimerCfg['show_date']; ?>';
            var counter = 1;

            $.each(bossTimerDataJSON, function (i, item) {
                if (item != null && item != '') {
                    var holdTotalSecondsLeft = item.timeLeft;
                    var timeLeftFormatted = '';
                    var nextTime = '';
                    var totalSecondsLeft = item.timeLeft;
                    var hours = Math.floor(item.timeLeft / 3600);
                    item.timeLeft = item.timeLeft % 3600;
                    var minutes = Math.floor(item.timeLeft / 60);
                    var seconds = item.timeLeft % 60;

                    if (hours.toString().length == 1) hours = '0' + hours;
                    if (minutes.toString().length == 1) minutes = '0' + minutes;
                    if (seconds.toString().length == 1) seconds = '0' + seconds;

                    <?php
                    if ($bossTimerCfg['display_seconds']) {
                        echo 'timeLeftFormatted = hours + \':\' + minutes + \':\' + seconds;';
                    } else {
                        echo 'timeLeftFormatted = hours + \':\' + minutes;';
                    }
                    ?>
                    if (totalSecondsLeft > 86400) {
                        nextTime = item.nextTime + ', ' + item.nextDate;
                    }

                    if (item.nextTime == null) {
                        nextTime = '<?php echo lang('template_txt_54', true); ?>';
                    }

                    if (totalSecondsLeft <= 0) {
                        nextTime = '<?php echo lang('template_txt_54', true); ?>';
                        item.nextTime = null;
                    } else {
                        nextTime = '<?php echo lang('template_txt_58', true); ?>';
                    }

                    var lastKilledBy = '<?php echo lang('template_txt_56', true); ?>';
                    if (item.lastKiller != null && item.lastKilled != null) {
                        lastKilledBy = item.lastKiller + ', ' + item.lastKilled;
                    } else if (item.lastKiller != null && item.lastKilled == null) {
                        lastKilledBy = item.lastKiller;
                    } else if (item.lastKiller == null && item.lastKilled != null) {
                        lastKilledBy = item.lastKilled;
                    }

                    var boxHeight = '42px';

                    if (item.nextTime != null && (showKiller == "1" || showDate == "1")) {
                        boxHeight = '60px';
                    } else if (item.nextTime == null && (showKiller == "0" && showDate == "0")) {
                        boxHeight = '24px';
                    }

                    newTimers +=
                        '<dt class="boss" style="height: ' + boxHeight + '">' +
                        '<b class="rightfloat">' + nextTime + '</b>' +
                        '<b class="title">' + item.name + '</b>';

                    if (item.nextTime != null) {
                        newTimers +=
                            '<span>' +
                            '<div class="rightfloat">' + timeLeftFormatted + '</div><?php echo lang('template_txt_57', true);?>' +
                            '</span>';
                    }

                    if (showKiller == "1" || showDate == "1") {
                        newTimers +=
                            '<span>' +
                            '<div class="rightfloat">' + lastKilledBy + '</div><?php echo lang('template_txt_55', true);?>' +
                            '</span>';
                    }

                    newTimers += '</dt>';

                    if (bossTimerDataJSON[counter].timeLeft != null && bossTimerDataJSON[counter].timeLeft != undefined && bossTimerDataJSON[counter].timeLeft > 0) {
                        bossTimerDataJSON[counter].timeLeft = holdTotalSecondsLeft - 1;

                        if (bossTimerDataJSON[counter].timeLeft == 0) {
                            getEventsData();
                        }
                    }

                    counter++;
                }
            });

            if (newTimers != '') {
                $('#bossTimer').html(newTimers);
            }
        }

        getBossData();
        initBossTimer();

        function initBossTimer() {
            setTimeout(function () {
                updateBossData();
                initBossTimer();
            }, 1000);
        }

    </script>

    <div class="panel panel-default server-info-home-panel">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo lang('template_txt_53', true); ?></h3>
        </div>
        <div class="panel-body">
            <dl id="bossTimer" class="sidebar-list panel-listing">
                <div style="text-align: center;"><img src="<?= __PATH_TEMPLATE__ ?>images/loader.gif"></div>
            </dl>
        </div>
    </div>
    <?php
}
?>

<?php
$eventsTimerCfg = loadConfigurations('eventstimer');
if ($eventsTimerCfg['active']) {
    ?>
    <div class="panel panel-default server-info-home-panel">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo lang('template_txt_38', true); ?></h3>
        </div>
        <div class="panel-body">
            <script type="text/javascript">
                var eventsTimerDataJSON = null;
                Notification.requestPermission().then(function(result) {});

                function getEventsData() {
                    $.getJSON('<?php echo __BASE_URL__; ?>ajax/events_timer.php', function (data) {
                        eventsTimerDataJSON = data;
                        updateEventsTimer();
                    });
                }

                function updateEventsTimer() {
                    var newTimers = '';
                    var counter = 0;
                    var needToCallAjax = false;

                    $.each(eventsTimerDataJSON, function (i, item) {
                        needToCallAjax = false;
                        if (item != null && item != '') {
                            var holdTimeLeft = item.timeLeft;
                            var timeLeftFormatted = '';
                            var timeLeft = item.timeLeft;
                            var hours = Math.floor(timeLeft / 3600);
                            timeLeft = timeLeft % 3600;
                            var minutes = Math.floor(timeLeft / 60);
                            var seconds = timeLeft % 60;

                            if (hours.toString().length == 1) hours = '0' + hours;
                            if (minutes.toString().length == 1) minutes = '0' + minutes;
                            if (seconds.toString().length == 1) seconds = '0' + seconds;

                            if (item.timeLeft <= parseInt(item.open) * 60) {
                                eventsTimerDataJSON[counter].isActive = 1;
                            }

                            var activeEvent = '';
                            if (item.isActive) {
                                activeEvent = ' eventActive';
                            }

                            <?php
                            if ($eventsTimerCfg['display_seconds']) {
                                echo 'timeLeftFormatted = hours + \':\' + minutes + \':\' + seconds;';
                            } else {
                                echo 'timeLeftFormatted = hours + \':\' + minutes;';
                            }
                            ?>

                            if (item.timeLeft == (parseInt(item.open) * 60) || item.timeLeft == ((parseInt(item.open) * 60) * 2)) {
                                var notification = new Notification(item.name, { body: item.text + ' ' + timeLeftFormatted, icon: '<?php echo __BASE_URL__ ?>templates/assets/notification_logo.png' });
                            }

                            newTimers += '<dt class="event' + activeEvent + '"><b class="rightfloat">' + item.nextTime + '</b><b class="title">' + item.name + '</b><span><div class="rightfloat">' + timeLeftFormatted + '</div>' + item.text + '</span></dt>';
                            eventsTimerDataJSON[counter].timeLeft = holdTimeLeft - 1;

                            if (eventsTimerDataJSON[counter].timeLeft == 0) {
                                needToCallAjax = true;
                            }

                            counter++;
                        }
                    });

                    if (needToCallAjax) {
                        getEventsData();
                    }

                    if (newTimers != '' && !newTimers.indexOf("undefined") >= 0) {
                        $('#events').html(newTimers);
                    }
                }

                getEventsData();
                initEventsTimer();

                function initEventsTimer() {
                    setTimeout(function () {
                        updateEventsTimer();
                        initEventsTimer();
                    }, 1000);
                }
            </script>

            <dl id="events" class="sidebar-list panel-listing">
                <div style="text-align: center;"><img src="<?= __PATH_TEMPLATE__ ?>images/loader.gif"></div>
            </dl>
        </div>
    </div>
    <?php
}
?>

<!--<div class="panel panel-default quick-link-home-panel">
    <div class="panel-body">
        <ul>
            <a href="#">
                <li>
                    <div class="icon"><i class="glyphicon glyphicon-book"></i></div>
                    <div class="content">
                        <span class="title link-color">Special Events</span>
                        <span class="text">Discover how to participate</span>
                    </div>
                </li>
            </a>
            <a href="#">
                <li>
                    <div class="icon"><i class="glyphicon glyphicon-star"></i></div>
                    <div class="content">
                        <span class="title link-color">VIP</span>
                        <span class="text">Know the advantages</span>
                    </div>
                </li>
            </a>
            <a href="#">
                <li>
                    <div class="icon"><i class="glyphicon glyphicon-usd"></i></div>
                    <div class="content">
                        <span class="title link-color">Credits</span>
                        <span class="text">Get credit packages</span>
                    </div>
                </li>
            </a>
        </ul>
    </div>
</div>-->