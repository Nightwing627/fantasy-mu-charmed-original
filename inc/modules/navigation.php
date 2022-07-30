<div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
        <span class="sr-only"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?= __BASE_URL__ ?>">
        <img src="<?= __PATH_TEMPLATE__ ?>images/logo.png">
    </a>
</div>
<div class="collapse navbar-collapse" id="navbar-collapse-1">
    <ul class="nav navbar-nav navbar-right">
        <li><a href="<?= __BASE_URL__ ?>"><i class="glyphicon glyphicon-home"></i> Home</a></li>
        <?php
        if (isLoggedIn()) {
            echo '<li class="visible-xs"><a href="' . __BASE_URL__ . 'usercp">' . lang('res_template_txt_18', true) . '</a></li>';
        } else {
            echo '<li class="visible-xs"><a href="' . __BASE_URL__ . 'login">' . lang('res_template_txt_22', true) . '</a></li>';
            echo '<li><a href="' . __BASE_URL__ . 'register">' . lang('res_template_txt_1', true) . '</a></li>';
        }
        ?>
        <li><a href="<?= __BASE_URL__ ?>downloads"> <i class="fas fa-cloud-download-alt"></i> <?= lang('res_template_txt_2', true) ?></a></li>
        <li><a href="<?= __BASE_URL__ ?>rankings"> <i class="fas fa-axe-battle"></i> <?= lang('res_template_txt_3', true) ?></a></li>
        <li><a href="<?= __BASE_URL__ ?>guides"> <i class="fas fa-bell-on"></i> <?= lang('res_template_txt_8', true) ?></a></li>
        <li><a href="<?= __BASE_URL__ ?>donation"> <i class="fas fa-donate"></i> <?= lang('res_template_txt_9', true) ?></a></li>
        <li><a href="<?= __BASE_URL__ ?>usercp/webshop"> <i class="fal fa-axe"></i> <?= lang('res_template_txt_14', true) ?></a></li>
        <li class="dropdown">
            <a href="<?= __BASE_URL__ ?>about" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?= lang('res_template_txt_10', true) ?> <span
                        class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="<?= __BASE_URL__ ?>about"> <i class="fas fa-viruses"></i> <?= lang('res_template_txt_10', true) ?></a></li>
                <li><a href="<?= __BASE_URL__ ?>rules"> <i class="far fa-viruses"></i> <?= lang('res_template_txt_11', true) ?></a></li>
                <li><a href="<?= __BASE_URL__ ?>tos"> <i class="far fa-route-interstate"></i> <?= lang('res_template_txt_12', true) ?></a></li>
                <li><a href="<?= __BASE_URL__ ?>statistics"> <i class="fad fa-plus-square"></i> <?= lang('res_template_txt_13', true) ?></a></li>
                <?php
                // Show AdminCP
                if (isLoggedIn() && canAccessAdminCP($_SESSION['username'])) {
                    echo '<li role="separator" class="divider"></li>
                    <li><a href="' . __PATH_ADMINCP_HOME__ . '" target="_blank" class="fas fa-user-shield " \r\n "</i>AdminCP</a></li>';
                }
                // Show GMCP
                if (isLoggedIn() && canAccessGMCP($_SESSION['username'])) {
                    echo '<li role="separator" class="divider"></li>
                    <li> <i class="fas fa-user-cog"></i> <a href="' . __PATH_GMCP_HOME__ . '" target="_blank">GMCP</a></li>';
                }
                ?>
            </ul>
        </li>
        <?php
        if (isLoggedIn()) {
            echo '<li class="visible-xs"><a href="' . __BASE_URL__ . 'logout">' . lang('res_template_txt_20', true) . '</a></li>';
        }
        ?>
    </ul>
</div>