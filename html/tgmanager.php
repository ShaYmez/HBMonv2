<?php
include_once 'include/config.php';
include_once 'include/version.php';
include_once 'include/tgid_store.php';
include_once 'include/tgmanager_auth.php';
include_once 'include/seo.php';

tgmanager_session_start();

$msg = '';
$edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? (string)$_POST['action'] : '';
    if (!tgmanager_csrf_ok()) {
        $msg = 'Login failed.';
        if (tgmanager_logged_in()) {
            $msg = 'Request failed.';
        }
    } elseif ($action === 'login') {
        $user = isset($_POST['user']) ? trim((string)$_POST['user']) : '';
        $pass = isset($_POST['pass']) ? (string)$_POST['pass'] : '';
        if (!tgmanager_has_users()) {
            $msg = 'No users configured.';
        } elseif (!tgmanager_login($user, $pass)) {
            $msg = 'Login failed.';
        } else {
            header('Location: tgmanager.php');
            exit;
        }
    } elseif ($action === 'logout') {
        tgmanager_logout();
        header('Location: info.php');
        exit;
    } elseif (!tgmanager_logged_in()) {
        $msg = 'Login failed.';
    } else {
        $tg = tgid_load(false);
        $records = $tg['records'];
        if ($action === 'add' || $action === 'edit') {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $callsign = isset($_POST['callsign']) ? trim((string)$_POST['callsign']) : '';
            $orig = isset($_POST['orig_id']) ? intval($_POST['orig_id']) : 0;
            if ($id < 1 || $callsign === '') {
                $msg = 'Invalid talkgroup.';
            } else {
                $dup = false;
                foreach ($records as $i => $record) {
                    $rid = tgid_record_id($record);
                    if ($action === 'edit' && $rid === $orig) {
                        continue;
                    }
                    if ($rid === $id) {
                        $dup = true;
                        break;
                    }
                }
                if ($dup) {
                    $msg = 'Talkgroup already exists.';
                } elseif ($action === 'add') {
                    $records[] = tgid_new_record($id, $callsign);
                    if (!tgid_save($records, $tg)) {
                        $msg = 'Save failed.';
                    } else {
                        header('Location: tgmanager.php');
                        exit;
                    }
                } else {
                    $found = false;
                    foreach ($records as $i => $record) {
                        if (tgid_record_id($record) === $orig) {
                            $records[$i] = tgid_apply_record($record, $id, $callsign);
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $msg = 'Talkgroup not found.';
                    } elseif (!tgid_save($records, $tg)) {
                        $msg = 'Save failed.';
                    } else {
                        header('Location: tgmanager.php');
                        exit;
                    }
                }
            }
            if ($action === 'edit') {
                $edit_id = $orig ? $orig : $id;
            }
        } elseif ($action === 'delete') {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $next = array();
            foreach ($records as $record) {
                if (tgid_record_id($record) !== $id) {
                    $next[] = $record;
                }
            }
            if (count($next) === count($records)) {
                $msg = 'Talkgroup not found.';
            } elseif (!tgid_save($next, $tg)) {
                $msg = 'Save failed.';
            } else {
                header('Location: tgmanager.php');
                exit;
            }
        }
    }
}

$logged_in = tgmanager_logged_in();
if (!$logged_in && $msg === '' && !tgmanager_has_users()) {
    $msg = 'No users configured.';
}
$csrf = htmlspecialchars(tgmanager_csrf_token());
$tg = tgid_load(true);
$edit_name = '';
if ($edit_id > 0) {
    $found = false;
    foreach ($tg['records'] as $record) {
        if (tgid_record_id($record) === $edit_id) {
            $edit_name = tgid_record_callsign($record);
            $found = true;
            break;
        }
    }
    if (!$found) {
        $edit_id = 0;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php hbmon_seo_head('Talkgroup Manager', array('noindex' => true)); ?>
  <link rel="stylesheet" type="text/css" href="css/styles.php" />
</head>
<body style="background-color: #d0d0d0;font: 10pt arial, sans-serif;">
  <div style="text-align: center;">
    <div style="width:1100px; text-align: center; margin:5px auto 0;">
      <p style="font-size: 10px; text-align: right; margin-right: 16px">Dashboard Version: <?php echo htmlspecialchars(DASH); ?></p>
      <img src="img/HBLINK_logoV2.png?v=<?php echo htmlspecialchars(rawurlencode(DASH)); ?>" alt="HBlink Logo" />
    </div>
    <div style="width: 1100px; margin: 0 auto;">
      <p style="text-align:center;"><span style="color:#000;font-size: 18px; font-weight:bold;"><?php echo htmlspecialchars(REPORT_NAME);?></span></p>
    </div>
    <?php include_once 'buttons.html'; ?>
<?php if (!$logged_in) { ?>
    <div style="width: 1100px; margin: 0 auto;">
      <fieldset style="box-shadow:0 0 10px #999; background-color:#e0e0e0; width:1050px; margin-left:15px; margin-right:15px; font-size:14px; border-radius: 10px;">
        <legend><b><span style="color:#000;">&nbsp;.: Login :.&nbsp;</span></b></legend>
<?php if ($msg !== '') { ?>
        <p class="tg-msg"><?php echo htmlspecialchars($msg); ?></p>
<?php } ?>
        <form method="post" action="tgmanager.php" class="tg-login">
          <input type="hidden" name="csrf" value="<?php echo $csrf; ?>" />
          <input type="hidden" name="action" value="login" />
          <table>
            <tr>
              <td>User</td>
              <td><input type="text" name="user" autocomplete="username" /></td>
            </tr>
            <tr>
              <td>Password</td>
              <td><input type="password" name="pass" autocomplete="current-password" /></td>
            </tr>
            <tr>
              <td></td>
              <td><button type="submit" class="button link">&nbsp;Login&nbsp;</button></td>
            </tr>
          </table>
        </form>
      </fieldset>
    </div>
<?php } else { ?>
    <div style="width: 1100px; margin: 0 auto;">
      <fieldset style="box-shadow:0 0 10px #999; background-color:#e0e0e0; width:1050px; margin-left:15px; margin-right:15px; font-size:14px; border-radius: 10px;">
        <legend><b><span style="color:#000;">&nbsp;.: Talk Groups :.&nbsp;</span></b></legend>
<?php if ($msg !== '') { ?>
        <p class="tg-msg"><?php echo htmlspecialchars($msg); ?></p>
<?php } ?>
        <form method="post" action="tgmanager.php" class="tg-logout">
          <input type="hidden" name="csrf" value="<?php echo $csrf; ?>" />
          <input type="hidden" name="action" value="logout" />
          <button type="submit" class="button link">&nbsp;Logout&nbsp;</button>
        </form>
<?php if ($edit_id > 0) { ?>
        <form method="post" action="tgmanager.php" class="tg-form">
          <input type="hidden" name="csrf" value="<?php echo $csrf; ?>" />
          <input type="hidden" name="action" value="edit" />
          <input type="hidden" name="orig_id" value="<?php echo htmlspecialchars((string)$edit_id); ?>" />
          <input type="number" name="id" min="1" value="<?php echo htmlspecialchars((string)$edit_id); ?>" />
          <input type="text" name="callsign" value="<?php echo htmlspecialchars($edit_name); ?>" />
          <button type="submit" class="button link">&nbsp;Save&nbsp;</button>
          <a class="button link" href="tgmanager.php">&nbsp;Cancel&nbsp;</a>
        </form>
<?php } else { ?>
        <form method="post" action="tgmanager.php" class="tg-form">
          <input type="hidden" name="csrf" value="<?php echo $csrf; ?>" />
          <input type="hidden" name="action" value="add" />
          <input type="number" name="id" min="1" placeholder="TG#" />
          <input type="text" name="callsign" placeholder="Description" />
          <button type="submit" class="button link">&nbsp;Add&nbsp;</button>
        </form>
<?php } ?>
        <table class="tg-table" style="margin-top:5px; table-layout:fixed; font: 10pt arial, sans-serif; background-color: #f9f9f9;">
          <tr class="theme_color" style="height: 32px; font: 10pt arial, sans-serif; border:0;">
            <th style="width: 150px;">TG#</th>
            <th style="width: 700px;">Description</th>
            <th style="width: 200px;">Action</th>
          </tr>
<?php foreach ($tg['records'] as $record) {
    $id = tgid_record_id($record);
    if ($id < 1) {
        continue;
    }
    $name = tgid_record_callsign($record);
?>
          <tr<?php echo ($edit_id === $id) ? ' class="tg-editing"' : ''; ?>>
            <td>&nbsp;<b>TG <?php echo htmlspecialchars((string)$id); ?></b>&nbsp;</td>
            <td><?php echo htmlspecialchars($name); ?></td>
            <td class="tg-actions">
              <a class="button link" href="tgmanager.php?edit=<?php echo htmlspecialchars((string)$id); ?>">&nbsp;Edit&nbsp;</a>
              <form method="post" action="tgmanager.php" onsubmit="return confirm('Delete this talkgroup?');">
                <input type="hidden" name="csrf" value="<?php echo $csrf; ?>" />
                <input type="hidden" name="action" value="delete" />
                <input type="hidden" name="id" value="<?php echo htmlspecialchars((string)$id); ?>" />
                <button type="submit" class="button link">&nbsp;Delete&nbsp;</button>
              </form>
            </td>
          </tr>
<?php } ?>
        </table>
      </fieldset>
    </div>
<?php } ?>
    <br>
    <!--footer-->
    <?php include_once 'elements/footer.php'; ?>
    <!--//footer-->
  </div>
</body>
</html>
