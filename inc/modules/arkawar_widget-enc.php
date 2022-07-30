<?php


$General = new MUCMS();
if ($General = ("arkawar-widget")) {
    $arkaWinners = $dB->query_fetch("\r\n      SELECT TOP 2 ab.G_Name as G_Name, CONVERT(date, ab.WinDate) as WinDate, ab.OuccupyObelisk as OuccupyObelisk, \r\n        ab.ObeliskGroup as ObeliskGroup, CONVERT(varchar(max), g.G_Mark, 2) as G_Mark, g.G_Master as G_Master\r\n      FROM IGC_ARCA_BATTLE_WIN_GUILD_INFO ab\r\n      INNER JOIN Guild g ON ab.G_Name = g.G_Name\r\n      ORDER BY WinDate DESC\r\n    ");
    $arkaWarConfing = loadConfigurations("arkawar");
    $battleDays = [];
    if ($arkaWarConfing["monday"]) {
        array_push($battleDays, 1);
    }
    if ($arkaWarConfing["tuesday"]) {
        array_push($battleDays, 2);
    }
    if ($arkaWarConfing["wednesday"]) {
        array_push($battleDays, 3);
    }
    if ($arkaWarConfing["thursday"]) {
        array_push($battleDays, 4);
    }
    if ($arkaWarConfing["friday"]) {
        array_push($battleDays, 5);
    }
    if ($arkaWarConfing["saturday"]) {
        array_push($battleDays, 6);
    }
    if ($arkaWarConfing["sunday"]) {
        array_push($battleDays, 7);
    }
    $battleTimeStartHour = $arkaWarConfing["event_hour"];
    $battleTimeStartMinute = $arkaWarConfing["event_minute"];
    $elements = [1 => lang("arkawar_txt_23", true), 2 => lang("arkawar_txt_24", true), 3 => lang("arkawar_txt_25", true), 4 => lang("arkawar_txt_26", true), 5 => lang("arkawar_txt_27", true)];
    $areas = [1 => lang("arkawar_txt_28", true), 2 => lang("arkawar_txt_29", true), 3 => lang("arkawar_txt_30", true)];
    $days = ["1" => "monday", "2" => "tuesday", "3" => "wednesday", "4" => "thursday", "5" => "friday", "6" => "saturday", "7" => "sunday"];
    $nextDay = NULL;
    $currDay = date("N");
    foreach ($battleDays as $thisDay) {
        if ($currDay < $thisDay) {
            $nextDay = $thisDay;
            $nextBattle = strtotime("next " . $days[$nextDay]);
        } else {
            if ($thisDay == $currDay) {
                $nextDay = $currDay;
                $nextBattle = strtotime(date("Y-m-d", time()));
            }
        }
        if ($nextBattle == NULL) {
            $nextBattle = strtotime("next " . $days[$battleDays[0]]);
        }
        $nextBattle += $battleTimeStartHour * 3600 + $battleTimeStartMinute * 60;
        echo "\r\n    <div class=\"panel panel-default server-info-home-panel\">\r\n        <div class=\"panel-heading\">\r\n            <h3 class=\"panel-title\">";
        echo lang("arkawar_txt_1", true);
        echo "                <a href=\"";
        echo __BASE_URL__;
        echo "arkawar\" class=\"btn-simple btn-icon-plus pull-right\"></a>\r\n            </h3>\r\n        </div>\r\n        <div class=\"panel-body\">\r\n            <div class=\"row\">\r\n                <div class=\"col-xs-3\">\r\n                    ";
        echo returnGuildLogo($arkaWinners[0]["G_Mark"], 48);
        echo "                </div>\r\n                <div class=\"col-xs-9\">\r\n                    <table width=\"100%\">\r\n                        <tr>\r\n                            <td>";
        echo lang("arkawar_txt_3", true);
        echo ":</td>\r\n                            <td align=\"right\"><b>";
        echo $common->replaceHtmlSymbols($arkaWinners[0]["G_Name"]);
        echo "</b></td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>";
        echo lang("arkawar_txt_4", true);
        echo ":</td>\r\n                            <td align=\"right\"><b>";
        echo $common->replaceHtmlSymbols($arkaWinners[0]["G_Master"]);
        echo "</b></td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>";
        echo lang("arkawar_txt_5", true);
        echo ":</td>\r\n                            <td align=\"right\"><b>";
        echo $elements[$arkaWinners[0]["OuccupyObelisk"]];
        echo "</b></td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>";
        echo lang("arkawar_txt_6", true);
        echo ":</td>\r\n                            <td align=\"right\"><b>";
        echo $areas[$arkaWinners[0]["ObeliskGroup"]];
        echo "</b></td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td>";
        echo lang("arkawar_txt_7", true);
        echo ":</td>\r\n                            <td align=\"right\"><b>";
        if ($arkaWinners[0]["WinDate"] != NULL) {
            echo date($config["date_format"], strtotime($arkaWinners[0]["WinDate"]));
        }
        echo "</b></td>\r\n                        </tr>\r\n                    </table>\r\n                </div>\r\n            </div>\r\n            ";
        if (is_array($arkaWinners[1]) && $arkaWinners[0]["WinDate"] == $arkaWinners[1]["WinDate"]) {
            echo "                <hr class=\"tiny\">\r\n                <div class=\"row\">\r\n                    <div class=\"col-xs-3\">\r\n                        ";
            echo returnGuildLogo($arkaWinners[1]["G_Mark"], 48);
            echo "                    </div>\r\n                    <div class=\"col-xs-9\">\r\n                        <table width=\"100%\">\r\n                            <tr>\r\n                                <td>";
            echo lang("arkawar_txt_3", true);
            echo ":</td>\r\n                                <td align=\"right\"><b>";
            echo $common->replaceHtmlSymbols($arkaWinners[1]["G_Name"]);
            echo "</b></td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>";
            echo lang("arkawar_txt_4", true);
            echo ":</td>\r\n                                <td align=\"right\"><b>";
            echo $common->replaceHtmlSymbols($arkaWinners[1]["G_Master"]);
            echo "</b></td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>";
            echo lang("arkawar_txt_5", true);
            echo ":</td>\r\n                                <td align=\"right\"><b>";
            echo $elements[$arkaWinners[1]["OuccupyObelisk"]];
            echo "</b></td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>";
            echo lang("arkawar_txt_6", true);
            echo ":</td>\r\n                                <td align=\"right\"><b>";
            echo $areas[$arkaWinners[1]["ObeliskGroup"]];
            echo "</b></td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>";
            echo lang("arkawar_txt_7", true);
            echo ":</td>\r\n                                <td align=\"right\"><b>";
            if ($arkaWinners[1]["WinDate"] != NULL) {
                echo date($config["date_format"], strtotime($arkaWinners[1]["WinDate"]));
            }
            echo "</b></td>\r\n                            </tr>\r\n                        </table>\r\n                    </div>\r\n                </div>\r\n            ";
        }
        echo "        </div>\r\n        <hr class=\"tiny\">\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12\" style=\"text-align: center; font-size: 1.2em;\">\r\n                ";
        echo lang("arkawar_txt_8", true);
        echo " ";
        echo date($config["time_date_format"], $nextBattle);
        echo "            </div>\r\n        </div>\r\n    </div>\r\n    ";
    }
}

?>