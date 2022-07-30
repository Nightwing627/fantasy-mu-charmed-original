<?php

loadModuleConfigs('news');
include(__PATH_MODULES__ . 'news.php');

if ($templateConfig['changelogs']) {
    echo '
<h3>
    ' . lang('changelogs_txt_1', true) . '
    <a href="' . __BASE_URL__ . 'changelogs" class="btn-simple btn-icon-plus pull-right"></a>
</h3>';

    $Changelog = new Changelog();
    $changelogsData = $Changelog->retrieveChangelogs($templateConfig['changelogs_limit']);

    if (is_array($changelogsData)) {
        echo '
<div class="panel-group" id="changelog" role="tablist" aria-multiselectable="true">';

        $changelogId = 1;
        foreach ($changelogsData as $thisLog) {
            if ($changelogId == 1) {
                $linkClass = 'class="collapsed"';
                $expanded = 'true';
                $expandedBody = ' in';
            } else {
                $linkClass = '';
                $expanded = 'false';
                $expandedBody = '';
            }

            echo '
    <div class="panel panel-default">
        <a ' . $linkClass . ' role="button" data-toggle="collapse" data-parent="#changelog" href="#changelog' . $changelogId . '"
           aria-expanded="' . $expanded . '" aria-controls="changelog' . $changelogId . '">
            <div class="panel-heading" role="tab" id="changelogTitle' . $changelogId . '">
                <h4 class="panel-title changelog">
                    ' . $thisLog['title'] . '
                    <div class="panel-title-date-div">';

            if ($thisLog['type'] == "1") {
                // server
                echo '<b><span style="text-transform: uppercase;"><small><span class="label label-warning">' . lang('changelogs_txt_5', true) . '</span></small></span></b>';
            } else {
                // website
                echo '<b><span style="text-transform: uppercase;"><small><span class="label label-success">' . lang('changelogs_txt_4', true) . '</span></small></span></b>';
            }

            echo '
                        <b>
                            <span style="text-transform: uppercase;">
                                <small>
                                    <span class="label label-default">' . date($config["time_date_format"], strtotime($thisLog['date'])) . '</span>
                                </small>
                            </span>
                        </b>
                    </div>
                </h4>
            </div>
        </a>
        <div id="changelog' . $changelogId . '" class="panel-collapse collapse' . $expandedBody . '" role="tabpanel" aria-labelledby="changelogTitle' . $changelogId . '">
            <div class="panel-body">
                ' . $thisLog['text'] . '
            </div>
        </div>
    </div>';

            $changelogId++;
        }

        echo '
</div>';
    } else {
        echo lang('changelogs_error_1', true);
    }
}

if ($templateConfig['characters_rankings']) {
    $ranking_data = LoadCacheData('rankings_characters.cache');
    $ranking_data_d = LoadCacheData('daily_rankings/rankings_characters.cache');
    $ranking_data_w = LoadCacheData('weekly_rankings/rankings_characters.cache');
    $ranking_data_m = LoadCacheData('monthly_rankings/rankings_characters.cache');
    $rankingsCfg = loadConfigurations('rankings');
    ?>
    <div class="row">
        <div id="carousel-characters-rankings" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <?php
                if ($rankingsCfg['rankings_enable_characters']['@attributes']['general'] == "1") {
                    if ($templateConfig['characters_rankings_default'] == "general") {
                        $active = ' active';
                    } else {
                        $active = '';
                    }

                    ?>
                    <div class="item<?php echo $active; ?>">
                        <section id="home-ranking-box" class="col-xs-12 home-ranking-box">
                            <h5>
                                <?php echo lang('template_txt_36', true) . ' - ' . lang('res_template_txt_4', true); ?>
                                <a href="<?php echo __BASE_URL__ . 'rankings/characters/' ?>" class="btn-simple btn-icon-plus pull-right"></a>
                            </h5>
                            <div class="table-responsive rankings-table">
                                <table class="table dark-tiny text-center">
                                    <tr>
                                        <th class="headerRow"></th>
                                        <?php
                                        echo '
                                <th class="headerRow">' . lang('rankings_txt_10', true) . '</th>
                                <th class="headerRow">' . lang('rankings_txt_11', true) . '</th>
                                <th class="headerRow">' . lang('global_module_5', true) . '</th>
                                <th class="headerRow">' . lang('global_module_6', true) . '</th>';

                                        if ($config["use_resets"]) {
                                            echo '<th class="headerRow">' . lang('global_module_7', true) . '</th>';
                                        }
                                        if ($config["use_grand_resets"]) {
                                            echo '<th class="headerRow">' . lang('global_module_8', true) . '</th>';
                                        }
                                        if ($config["flags"]) {
                                            echo '<th class="headerRow">' . lang('global_module_11', true) . '</th>';
                                        }
                                        ?>
                                    </tr>
                                    <?php

                                    $i = 0;
                                    foreach ($ranking_data as $rdata) {
                                        if ($i > 10) break;
                                        if ($i >= 1) {
                                            echo '
                            <tr class="link-row rank-pos-' . $i . '">
                                <td>';

                                            if ($i >= 1 && $i <= 3) {
                                                echo '<img src="' . __PATH_TEMPLATE__ . 'images/rank' . $i . '.png">';
                                            } else {
                                                echo $i;
                                            }

                                            echo '</td>
                                <td id="RankingWidgetResultName' . $i . '">
                                    <a href="' . __BASE_URL__ . 'profile/player/req/' . hex_encode($rdata[0]) . '">
                                        ' . $common->replaceHtmlSymbols($rdata[0]) . '
                                    </a>
                                </td>
                                <td id="RankingWidgetResultClass' . $i . '">' . $custom['character_class'][$rdata[1]][1] . '</td>
                                <td id="RankingWidgetResultLevel' . $i . '">' . $rdata[2] . '</td>
                                <td id="RankingWidgetResultMasterLevel' . $i . '">' . $rdata[3] . '</td>';

                                            if ($config["use_resets"]) {
                                                echo '<td>' . $rdata[4] . '</td>';
                                            }
                                            if ($config["use_grand_resets"]) {
                                                echo '<td>' . $rdata[5] . '</td>';
                                            }

                                            if ($config["flags"]) {
                                                echo '<td><img src="' . __PATH_TEMPLATE__ . 'images/blank.png" class="flag-icon flag-icon-' . $rdata[6] . '" alt="' . $custom['countries'][$rdata[6]] . '" title="' . $custom['countries'][$rdata[6]] . '" /></td>';
                                            }

                                            echo '
                            </tr>';
                                        }
                                        $i++;
                                    }

                                    ?>
                                </table>
                            </div>
                        </section>
                        <div class="carousel-caption"></div>
                    </div>
                    <?php
                }
                if ($rankingsCfg['rankings_enable_characters']['@attributes']['monthly'] == "1") {
                    if ($templateConfig['characters_rankings_default'] == "monthly") {
                        $active = ' active';
                    } else {
                        $active = '';
                    }

                    ?>
                    <div class="item<?php echo $active; ?>">
                        <section id="home-ranking-box" class="col-xs-12 home-ranking-box">
                            <h5>
                                <?php echo lang('template_txt_36', true) . ' - ' . lang('res_template_txt_7', true); ?>
                                <a href="<?php echo __BASE_URL__ . 'rankings/characters/' ?>" class="btn-simple btn-icon-plus pull-right"></a>
                            </h5>
                            <div class="table-responsive rankings-table">
                                <table class="table dark-tiny text-center">
                                    <tr>
                                        <th class="headerRow"></th>
                                        <?php
                                        echo '
                                    <th class="headerRow">' . lang('rankings_txt_10', true) . '</th>
                                    <th class="headerRow">' . lang('rankings_txt_11', true) . '</th>
                                    <th class="headerRow">' . lang('global_module_5', true) . '</th>
                                    <th class="headerRow">' . lang('global_module_6', true) . '</th>';

                                        if ($config["use_resets"]) {
                                            echo '<th class="headerRow">' . lang('global_module_7', true) . '</th>';
                                        }
                                        if ($config["use_grand_resets"]) {
                                            echo '<th class="headerRow">' . lang('global_module_8', true) . '</th>';
                                        }
                                        if ($config["flags"]) {
                                            echo '<th class="headerRow">' . lang('global_module_11', true) . '</th>';
                                        }
                                        ?>
                                    </tr>
                                    <?php

                                    $i = 0;
                                    foreach ($ranking_data_m as $rdata) {
                                        if ($i > 10) break;
                                        if ($i >= 1) {
                                            echo '
                                <tr class="link-row rank-pos-' . $i . '">
                                    <td>';

                                            if ($i >= 1 && $i <= 3) {
                                                echo '<img src="' . __PATH_TEMPLATE__ . 'images/rank' . $i . '.png">';
                                            } else {
                                                echo $i;
                                            }

                                            echo '</td>
                                    <td id="RankingWidgetResultName' . $i . '">
                                        <a href="' . __BASE_URL__ . 'profile/player/req/' . hex_encode($rdata[0]) . '">
                                            ' . $common->replaceHtmlSymbols($rdata[0]) . '
                                        </a>
                                    </td>
                                    <td id="RankingWidgetResultClass' . $i . '">' . $custom['character_class'][$rdata[1]][1] . '</td>
                                    <td id="RankingWidgetResultLevel' . $i . '">' . $rdata[2] . '</td>
                                    <td id="RankingWidgetResultMasterLevel' . $i . '">' . $rdata[3] . '</td>';

                                            if ($config["use_resets"]) {
                                                echo '<td>' . $rdata[4] . '</td>';
                                            }
                                            if ($config["use_grand_resets"]) {
                                                echo '<td>' . $rdata[5] . '</td>';
                                            }

                                            if ($config["flags"]) {
                                                echo '<td><img src="' . __PATH_TEMPLATE__ . 'images/blank.png" class="flag-icon flag-icon-' . $rdata[6] . '" alt="' . $custom['countries'][$rdata[6]] . '" title="' . $custom['countries'][$rdata[6]] . '" /></td>';
                                            }

                                            echo '
                                </tr>';
                                        }
                                        $i++;
                                    }

                                    ?>
                                </table>
                            </div>
                        </section>
                        <div class="carousel-caption"></div>
                    </div>
                    <?php
                }
                if ($rankingsCfg['rankings_enable_characters']['@attributes']['weekly'] == "1") {
                    if ($templateConfig['characters_rankings_default'] == "weekly") {
                        $active = ' active';
                    } else {
                        $active = '';
                    }

                    ?>
                    <div class="item<?php echo $active; ?>">
                        <section id="home-ranking-box" class="col-xs-12 home-ranking-box">
                            <h5>
                                <?php echo lang('template_txt_36', true) . ' - ' . lang('res_template_txt_6', true); ?>
                                <a href="<?php echo __BASE_URL__ . 'rankings/characters/' ?>" class="btn-simple btn-icon-plus pull-right"></a>
                            </h5>
                            <div class="table-responsive rankings-table">
                                <table class="table dark-tiny text-center">
                                    <tr>
                                        <th class="headerRow"></th>
                                        <?php
                                        echo '
                                    <th class="headerRow">' . lang('rankings_txt_10', true) . '</th>
                                    <th class="headerRow">' . lang('rankings_txt_11', true) . '</th>
                                    <th class="headerRow">' . lang('global_module_5', true) . '</th>
                                    <th class="headerRow">' . lang('global_module_6', true) . '</th>';

                                        if ($config["use_resets"]) {
                                            echo '<th class="headerRow">' . lang('global_module_7', true) . '</th>';
                                        }
                                        if ($config["use_grand_resets"]) {
                                            echo '<th class="headerRow">' . lang('global_module_8', true) . '</th>';
                                        }
                                        if ($config["flags"]) {
                                            echo '<th class="headerRow">' . lang('global_module_11', true) . '</th>';
                                        }
                                        ?>
                                    </tr>
                                    <?php

                                    $i = 0;
                                    foreach ($ranking_data_w as $rdata) {
                                        if ($i > 10) break;
                                        if ($i >= 1) {
                                            echo '
                                <tr class="link-row rank-pos-' . $i . '">
                                    <td>';

                                            if ($i >= 1 && $i <= 3) {
                                                echo '<img src="' . __PATH_TEMPLATE__ . 'images/rank' . $i . '.png">';
                                            } else {
                                                echo $i;
                                            }

                                            echo '</td>
                                    <td id="RankingWidgetResultName' . $i . '">
                                        <a href="' . __BASE_URL__ . 'profile/player/req/' . hex_encode($rdata[0]) . '">
                                            ' . $common->replaceHtmlSymbols($rdata[0]) . '
                                        </a>
                                    </td>
                                    <td id="RankingWidgetResultClass' . $i . '">' . $custom['character_class'][$rdata[1]][1] . '</td>
                                    <td id="RankingWidgetResultLevel' . $i . '">' . $rdata[2] . '</td>
                                    <td id="RankingWidgetResultMasterLevel' . $i . '">' . $rdata[3] . '</td>';

                                            if ($config["use_resets"]) {
                                                echo '<td>' . $rdata[4] . '</td>';
                                            }
                                            if ($config["use_grand_resets"]) {
                                                echo '<td>' . $rdata[5] . '</td>';
                                            }

                                            if ($config["flags"]) {
                                                echo '<td><img src="' . __PATH_TEMPLATE__ . 'images/blank.png" class="flag-icon flag-icon-' . $rdata[6] . '" alt="' . $custom['countries'][$rdata[6]] . '" title="' . $custom['countries'][$rdata[6]] . '" /></td>';
                                            }

                                            echo '
                                </tr>';
                                        }
                                        $i++;
                                    }

                                    ?>
                                </table>
                            </div>
                        </section>
                        <div class="carousel-caption"></div>
                    </div>
                    <?php
                }
                if ($rankingsCfg['rankings_enable_characters']['@attributes']['daily'] == "1") {
                    if ($templateConfig['characters_rankings_default'] == "daily") {
                        $active = ' active';
                    } else {
                        $active = '';
                    }

                    ?>
                    <div class="item<?php echo $active; ?>">
                        <section id="home-ranking-box" class="col-xs-12 home-ranking-box">
                            <h5>
                                <?php echo lang('template_txt_36', true) . ' - ' . lang('res_template_txt_5', true); ?>
                                <a href="<?php echo __BASE_URL__ . 'rankings/characters/' ?>" class="btn-simple btn-icon-plus pull-right"></a>
                            </h5>
                            <div class="table-responsive rankings-table">
                                <table class="table dark-tiny text-center">
                                    <tr>
                                        <th class="headerRow"></th>
                                        <?php
                                        echo '
                                    <th class="headerRow">' . lang('rankings_txt_10', true) . '</th>
                                    <th class="headerRow">' . lang('rankings_txt_11', true) . '</th>
                                    <th class="headerRow">' . lang('global_module_5', true) . '</th>
                                    <th class="headerRow">' . lang('global_module_6', true) . '</th>';

                                        if ($config["use_resets"]) {
                                            echo '<th class="headerRow">' . lang('global_module_7', true) . '</th>';
                                        }
                                        if ($config["use_grand_resets"]) {
                                            echo '<th class="headerRow">' . lang('global_module_8', true) . '</th>';
                                        }
                                        if ($config["flags"]) {
                                            echo '<th class="headerRow">' . lang('global_module_11', true) . '</th>';
                                        }
                                        ?>
                                    </tr>
                                    <?php

                                    $i = 0;
                                    foreach ($ranking_data_d as $rdata) {
                                        if ($i > 10) break;
                                        if ($i >= 1) {
                                            echo '
                                <tr class="link-row rank-pos-' . $i . '">
                                    <td>';

                                            if ($i >= 1 && $i <= 3) {
                                                echo '<img src="' . __PATH_TEMPLATE__ . 'images/rank' . $i . '.png">';
                                            } else {
                                                echo $i;
                                            }

                                            echo '</td>
                                    <td id="RankingWidgetResultName' . $i . '">
                                        <a href="' . __BASE_URL__ . 'profile/player/req/' . hex_encode($rdata[0]) . '">
                                            ' . $common->replaceHtmlSymbols($rdata[0]) . '
                                        </a>
                                    </td>
                                    <td id="RankingWidgetResultClass' . $i . '">' . $custom['character_class'][$rdata[1]][1] . '</td>
                                    <td id="RankingWidgetResultLevel' . $i . '">' . $rdata[2] . '</td>
                                    <td id="RankingWidgetResultMasterLevel' . $i . '">' . $rdata[3] . '</td>';

                                            if ($config["use_resets"]) {
                                                echo '<td>' . $rdata[4] . '</td>';
                                            }
                                            if ($config["use_grand_resets"]) {
                                                echo '<td>' . $rdata[5] . '</td>';
                                            }

                                            if ($config["flags"]) {
                                                echo '<td><img src="' . __PATH_TEMPLATE__ . 'images/blank.png" class="flag-icon flag-icon-' . $rdata[6] . '" alt="' . $custom['countries'][$rdata[6]] . '" title="' . $custom['countries'][$rdata[6]] . '" /></td>';
                                            }

                                            echo '
                                </tr>';
                                        }
                                        $i++;
                                    }

                                    ?>
                                </table>
                            </div>
                        </section>
                        <div class="carousel-caption"></div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <ol class="carousel-indicators">
                <?php
                $counter = 0;
                if ($rankingsCfg['rankings_enable_characters']['@attributes']['general'] == "1") {
                    if ($templateConfig['characters_rankings_default'] == "general") {
                        $active = ' class="active"';
                    } else {
                        $active = '';
                    }
                    echo '<li data-target="#carousel-characters-rankings" data-slide-to="' . $counter . '"' . $active . '></li>';
                    $counter++;
                }
                if ($rankingsCfg['rankings_enable_characters']['@attributes']['monthly'] == "1") {
                    if ($templateConfig['characters_rankings_default'] == "monthly") {
                        $active = ' class="active"';
                    } else {
                        $active = '';
                    }
                    echo '<li data-target="#carousel-characters-rankings" data-slide-to="' . $counter . '"' . $active . '></li>';
                    $counter++;
                }
                if ($rankingsCfg['rankings_enable_characters']['@attributes']['weekly'] == "1") {
                    if ($templateConfig['characters_rankings_default'] == "weekly") {
                        $active = ' class="active"';
                    } else {
                        $active = '';
                    }
                    echo '<li data-target="#carousel-characters-rankings" data-slide-to="' . $counter . '"' . $active . '></li>';
                    $counter++;
                }
                if ($rankingsCfg['rankings_enable_characters']['@attributes']['daily'] == "1") {
                    if ($templateConfig['characters_rankings_default'] == "daily") {
                        $active = ' class="active"';
                    } else {
                        $active = '';
                    }
                    echo '<li data-target="#carousel-characters-rankings" data-slide-to="' . $counter . '"' . $active . '></li>';
                    $counter++;
                }
                ?>
            </ol>

        </div>
    </div>
    <?php
}
if ($templateConfig['guilds_rankings']) {
    $ranking_gdata = LoadCacheData('rankings_guilds.cache');
    $rankingsCfg = loadConfigurations('rankings');
    ?>
    <div class="row">
        <section id="home-ranking-box" class="col-xs-12 col-md-12 col-lg-12 home-ranking-box">
            <h5>
                <?php echo lang('template_txt_37', true); ?>
                <a href="<?php echo __BASE_URL__ . 'rankings/guilds/' ?>" class="btn-simple btn-icon-plus pull-right"></a>
            </h5>
            <div class="table-responsive rankings-table">
                <table class="table dark-tiny text-center">
                    <tr>
                        <th class="headerRow"></th>
                        <?php

                        echo '
                    <th class="headerRow">' . lang('rankings_txt_17', true) . '</th>
                    <th class="headerRow">' . lang('rankings_txt_28', true) . '</th>
                    <th class="headerRow">' . lang('rankings_txt_18', true) . '</th>
                    <th class="headerRow">' . lang('rankings_txt_66', true) . '</th>';

                        if ($rankingsCfg['rankings_guild_type']) {
                            echo '
                    <th class="headerRow">' . lang('rankings_txt_45', true) . '</th>
                    <th class="headerRow">' . lang('rankings_txt_85', true) . '</th>';

                            if ($config["use_resets"]) {
                                echo '<th class="headerRow">' . lang('rankings_txt_86', true) . '</th>';
                            }
                            if ($config["use_grand_resets"]) {
                                echo '<th class="headerRow">' . lang('rankings_txt_87', true) . '</th>';
                            }
                        } else {
                            echo '<th class="headerRow">' . lang('rankings_txt_19', true) . '</th>';
                        }
                        ?>
                    </tr>

                    <?php

                    $i = 0;
                    foreach ($ranking_gdata as $rdata) {
                        if ($i > 5) break;
                        if ($i >= 1) {
                            echo '
                    <tr class="link-row rank-pos-' . $i . '">
                        <td>';

                            if ($i >= 1 && $i <= 3) {
                                echo '<img src="' . __PATH_TEMPLATE__ . 'images/rank' . $i . '.png">';
                            } else {
                                echo $i;
                            }

                            echo '</td>';

                            echo '<td><a href="' . __BASE_URL__ . 'profile/guild/req/' . hex_encode($rdata[0]) . '/">' . $common->replaceHtmlSymbols($rdata[0]) . '</a></td>';
                            echo '<td>' . returnGuildLogo($rdata[6], 26) . '</td>';
                            echo '<td><a href="' . __BASE_URL__ . 'profile/player/req/' . hex_encode($rdata[1]) . '/">' . $common->replaceHtmlSymbols($rdata[1]) . '</a></td>';
                            echo '<td>' . number_format($rdata[7]) . '</td>';

                            if ($rankingsCfg['rankings_guild_type']) {
                                echo '<td>' . number_format($rdata[2]) . '</td>';
                                echo '<td>' . number_format($rdata[3]) . '</td>';

                                if ($config["use_resets"]) {
                                    echo '<td>' . number_format($rdata[4]) . '</td>';
                                }
                                if ($config["use_grand_resets"]) {
                                    echo '<td>' . number_format($rdata[5]) . '</td>';
                                }
                            } else {
                                echo '<td>' . number_format($rdata[8]) . '</td>';
                            }

                            echo '
                    </tr>';
                        }
                        $i++;
                    }

                    ?>
                </table>
            </div>
        </section>
    </div>
    <?php
}