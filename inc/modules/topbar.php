<?php
if ($templateConfig['party_matching']) {
    $direction = 'left';
    if ($templateConfig['party_matching_align'] == '0') $direction = 'right';
    $data = $common->loadPartyMatchingSimple();
    if ($data != '') {
        echo '
    <div class="row party-matching hidden-xs">
        <div class="col-xs-12">
            <marquee behavior="scroll" direction="' . $direction . '" class="party-matching-text" onmouseover="this.stop();" onmouseout="this.start();">' . $data . '</marquee>
        </div>
    </div>';
    }
}
if (isLoggedIn()) {
    checkBanProtection($_SESSION['username']);
    ?>
    <div class="row topbar">
        <div class="col-xs-12 col-md-6 text-md-left-xs-center welcome-text">
            <?php echo sprintf(lang('res_template_txt_34', true), $_SESSION['username']) ?>
        </div>
        <div class="col-xs-12 col-md-6 text-md-right-xs-center">
            <a href="<?= __BASE_URL__ ?>usercp" class="no-decoration">
                <button class="btn btn-primary btn-xs"><?php echo lang('module_titles_txt_3', true); ?></button>
            </a>
            <a href="<?= __BASE_URL__ ?>donation" class="no-decoration">
                <button class="btn btn-primary btn-xs"><?php echo lang('donation', true); ?></button>
            </a>
            <a href="<?= __BASE_URL__ ?>usercp/vote" class="no-decoration">
                <button class="btn btn-primary btn-xs"><?php echo lang('myaccount_txt_28', true); ?></button>
            </a>
            <a href="<?= __BASE_URL__ ?>usercp/wheeloffortune" class="no-decoration">
                <button class="btn btn-primary btn-xs"><?php echo lang('wheeloffortune_txt_1', true); ?></button>
            </a>
            <a href="<?= __BASE_URL__ ?>logout" class="no-decoration">
                <button class="btn btn-danger btn-xs"><?php echo lang('menu_txt_6', true); ?></button>
            </a>
        </div>
    </div>
<?php } else { ?>
    <div class="row topbar">
        <div class="col-xs-12 col-md-6 text-md-left-xs-center welcome-text">
            <?php echo lang('res_template_txt_36', true); ?>
        </div>
        <div class="col-xs-12 col-md-6 text-md-right-xs-center">
            <a href="<?= __BASE_URL__ ?>register" class="no-decoration">
                <button class="btn btn-primary btn-xs"><?php echo lang('menu_txt_3', true); ?></button>
            </a>
            <a href="<?= __BASE_URL__ ?>login" class="no-decoration">
                <button class="btn btn-success btn-xs"><?php echo lang('menu_txt_4', true); ?></button>
            </a>
        </div>
    </div>
<?php } ?>
