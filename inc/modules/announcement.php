<?php

if (lang('announcement_show', true) == "true") {
    echo '
    <div class="container_3 light_brown wide fading-notification" align="left">
        <span class="error_icons info"></span>
        <p class="important-notice">' . lang('announcement_txt_1', true) . '</p>
    </div>';
}
