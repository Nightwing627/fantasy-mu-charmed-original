<?php

function isSidebar()
{
	if ((strtolower($_REQUEST['page']) == '') || (strtolower($_REQUEST['page']) == NULL) || (strtolower($_REQUEST['page']) == 'news')) {
		return true;
	}
	else {
		return false;
	}
}

function isHome()
{
	if ((strtolower($_REQUEST['page']) == '') || (strtolower($_REQUEST['page']) == NULL) || ((strtolower($_REQUEST['page']) == 'news') && ((strtolower($_REQUEST['subpage']) == '') || strtolower($_REQUEST['subpage'] == NULL)))) {
		return true;
	}
	else {
		return false;
	}
}

function check_port($ip, $port)
{
	$conn = @fsockopen($ip, $port, $errno, $errstr, 2);

	if ($conn) {
		fclose($conn);
		return true;
	}
	else {
		return false;
	}
}

function generateBreadcrumb()
{
	$breadcrumb = '<ol class="breadcrumb hidden-xs"><li><a href="' . __BASE_URL__ . '"><i class="glyphicon glyphicon-home"></i></a></li>';

	if ($_REQUEST['subpage'] == NULL) {
		if (lang('breadcrumb_' . $_REQUEST['page'], true) != NULL) {
			$breadcrumb .= '<li class="active">' . lang('breadcrumb_' . $_REQUEST['page'], true) . '</li>';
		}
		else {
			$breadcrumb .= '<li class="active">' . ucwords(str_replace('_', ' ', str_replace('-', ' ', $_REQUEST['page']))) . '</li>';
		}
	}
	else if ((lang('breadcrumb_' . $_REQUEST['page'], true) != NULL) && (lang('breadcrumb_' . $_REQUEST['page'] . '_' . $_REQUEST['subpage'], true) != NULL)) {
		if (($_REQUEST['page'] == 'donation') && ($_REQUEST['subpage'] == 'manualdonation')) {
			$breadcrumb .= '<li><a href="' . __BASE_URL__ . $_REQUEST['page'] . '">' . lang('breadcrumb_' . $_REQUEST['page'], true) . '</a></li><li class="active">' . ucwords($_GET['gateway']) . '</li>';
		}
		else if (($_REQUEST['page'] == 'usercp') && (($_REQUEST['subpage'] == 'startingkit') || ($_REQUEST['subpage'] == 'achievements'))) {
			if ($_REQUEST['request'] == NULL) {
				$breadcrumb .= '<li><a href="' . __BASE_URL__ . $_REQUEST['page'] . '">' . lang('breadcrumb_' . $_REQUEST['page'], true) . '</a></li><li class="active">' . lang('breadcrumb_' . $_REQUEST['page'] . '_' . $_REQUEST['subpage'], true) . '</li>';
			}
			else {
				$breadcrumb .= "\n" . '                    <li><a href="' . __BASE_URL__ . $_REQUEST['page'] . '">' . lang('breadcrumb_' . $_REQUEST['page'], true) . '</a></li>' . "\n" . '                    <li><a href="' . __BASE_URL__ . $_REQUEST['page'] . '/' . $_REQUEST['subpage'] . '">' . lang('breadcrumb_' . $_REQUEST['page'] . '_' . $_REQUEST['subpage'], true) . '</a></li>' . "\n" . '                    <li class="active">' . hex_decode($_GET['char']) . '</li>';
			}
		}
		else {
			$breadcrumb .= '<li><a href="' . __BASE_URL__ . $_REQUEST['page'] . '">' . lang('breadcrumb_' . $_REQUEST['page'], true) . '</a></li><li class="active">' . lang('breadcrumb_' . $_REQUEST['page'] . '_' . $_REQUEST['subpage'], true) . '</li>';
		}
	}
	else if (lang('breadcrumb_' . $_REQUEST['page'], true) != NULL) {
		$breadcrumb .= '<li><a href="' . __BASE_URL__ . $_REQUEST['page'] . '">' . lang('breadcrumb_' . $_REQUEST['page'], true) . '</a></li><li class="active">' . ucwords(str_replace('_', ' ', str_replace('-', ' ', $_REQUEST['subpage']))) . '</li>';
	}
	else if (lang('breadcrumb_' . $_REQUEST['page'] . '_' . $_REQUEST['subpage'], true) != NULL) {
		$breadcrumb .= '<li><a href="' . __BASE_URL__ . $_REQUEST['page'] . '">' . ucwords(str_replace('_', ' ', str_replace('-', ' ', $_REQUEST['page']))) . '</a></li><li class="active">' . lang('breadcrumb_' . $_REQUEST['page'] . '_' . $_REQUEST['subpage'], true) . '</li>';
	}

	$breadcrumb .= '</ol>';
	$breadcrumb .= '<div class="visible-xs float-right">';

	if ($_REQUEST['subpage'] != NULL) {
		if ((lang('breadcrumb_' . $_REQUEST['page'], true) != NULL) && (lang('breadcrumb_' . $_REQUEST['page'] . '_' . $_REQUEST['subpage'], true) != NULL)) {
			$breadcrumb .= '<a href="' . __BASE_URL__ . $_REQUEST['page'] . '"><button class="btn btn-warning">' . lang('breadcrumb_' . $_REQUEST['page'], true) . '</button></a>';
		}
		else {
			$breadcrumb .= '<a href="' . __BASE_URL__ . $_REQUEST['page'] . '"><button class="btn btn-warning">' . ucwords(str_replace('_', ' ', str_replace('-', ' ', $_REQUEST['page']))) . '</button></a>';
		}
	}

	$breadcrumb .= '</div>';
	return $breadcrumb;
}

function checkBanProtection($username)
{
	global $dB;
	global $dB2;
	$checkBan = $dB->query_fetch_single('SELECT AccountID FROM MUCMS_BANS WHERE AccountID = ? AND banned_by = ? AND ban_reason = ?', [$username, 'X', 'MUCMS Protection']);

	if (is_array($checkBan)) {
		if (check_value($_POST['unblock_protection'])) {
			if ($_SESSION['token'] == $_POST['token']) {
				if (config('SQL_USE_2_DB', true)) {
					$dB2->query('UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?', [0, $username]);
				}
				else {
					$dB->query('UPDATE MEMB_INFO SET bloc_code = ? WHERE memb___id = ?', [0, $username]);
				}

				$dB->query('DELETE FROM MUCMS_BANS WHERE AccountID = ? AND banned_by = ? AND ban_reason = ?', [$username, 'X', 'MUCMS Protection']);
			}
		}
		else {
			$token = time();
			$_SESSION['token'] = $token;
			echo "\n" . '    <div class="row topbar ban-protection">' . "\n" . '        <div class="col-xs-12 col-md-10">';
			message('info', lang('template_txt_59', true));
			echo "\n" . '        </div>' . "\n" . '        <div class="col-xs-12 col-md-2">' . "\n" . '            <form method="post">' . "\n" . '                <input type="hidden" name="token" value="' . $token . '">' . "\n" . '                <input type="submit" name="unblock_protection" value="' . lang('template_txt_60', true) . '" class="btn btn-success full-width-btn" />' . "\n" . '            </form>' . "\n" . '        </div>' . "\n" . '    </div>';
		}
	}
}

?>