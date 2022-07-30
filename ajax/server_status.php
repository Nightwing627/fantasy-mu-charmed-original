<?php


try {
    if (!(include_once "ajaxconfig.php")) {
        throw new Exception("Could not load the AJAX configurations file.");
    }
    if (!(include_once __PATH_INCLUDES__ . "serverstatus_config.php")) {
        throw new Exception("Could not load the server status configurations file.");
    }
    if (isset($config["serverstatus"]) && is_array($config["serverstatus"])) {
        foreach ($config["serverstatus"] as $server) {
            $ip = $server["ip"];
            $port = intval($server["port"]);
            $servername = xss_clean(htmlspecialchars(trim($server["servername"]), ENT_QUOTES));
            $displayname = xss_clean($server["displayname"]);
            $cssClass = "";
            if (Validator::Ip($ip) && is_integer($port) && !empty($servername)) {
                if (!empty($server["cssclass"])) {
                    $cssClass = " " . $server["cssclass"];
                }
                echo "<div class=\"realm_st" . $cssClass . "\">";
                echo "<div class=\"realmst_head\"><div class=\"realm_name\">";
                if (check_port($ip, $port)) {
                    echo "<span class=\"online\"></span>";
                } else {
                    echo "<span class=\"offline\"></span>";
                }
                if (config("SQL_USE_2_DB", true)) {
                    $online = $dB2->query_fetch_single("SELECT COUNT(*) AS count FROM MEMB_STAT WHERE ConnectStat = '1' AND ServerName = '" . $servername . "'");
                } else {
                    $online = $dB->query_fetch_single("SELECT COUNT(*) AS count FROM MEMB_STAT WHERE ConnectStat = '1' AND ServerName = '" . $servername . "'");
                }
                echo $displayname;
                echo "</div>";
                echo "<p class=\"realm-desc\">" . lang("template_txt_3", true) . " " . number_format($online["count"]) . "</p>";
                echo "</div></div>";
            }
        }
    } else {
        throw new Exception("Array for server status not defined!");
    }
} catch (Exception $e) {
    echo "Server Status Error";
}

?>