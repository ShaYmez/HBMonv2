<?php
include_once 'include/config.php';
include_once 'include/version.php';
include_once 'include/seo.php';

function lastheard_log_path() {
    if (defined('LASTHEARD_LOG') && LASTHEARD_LOG !== '') {
        return LASTHEARD_LOG;
    }
    $candidates = array(
        '/var/log/hbmon/lastheard.log',
        '/opt/HBMonv2/log/lastheard.log',
    );
    foreach ($candidates as $path) {
        if (is_readable($path)) {
            return $path;
        }
    }
    return '/opt/HBMonv2/log/lastheard.log';
}

function lastheard_field($data, $i) {
    return (is_array($data) && isset($data[$i])) ? (string)$data[$i] : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="30">
<?php hbmon_seo_head('Lastheard'); ?>
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
    <div style="width: 1100px; margin: 0 auto;">
      <div style="overflow-x:auto;">
        <fieldset style="width:1050px; background-color:#e0e0e0; margin-left:15px; margin-right:15px; font-size:14px; border-radius: 10px;">
          <table style="border-collapse: collapse; border: 1px solid #C1DAD7; width: 100%; background-color:#f0f0f0;">
            <thead><tr><th colspan="8" style="height: 30px; font-size:18px; font-weight:bold;">LastHeard</th></tr></thead>
            <tr class="theme_color" style="height:35px; text-align: center; font-weight:bold;"><th>&nbsp;&nbsp;Date</th><th>&nbsp;Time</th><th>&nbsp;Callsign (DMR-Id)</th><th>&nbsp;&nbsp;Name</th><th>&nbsp;TG#</th><th>&nbsp;&nbsp;TG Name</th><th>TX (s)&nbsp;</th><th>Source</th>
            </tr>
<?php
$log_path = lastheard_log_path();
$handle = is_readable($log_path) ? fopen($log_path, 'r') : false;
if ($handle) {
    $rows = array();
    while (($data = fgetcsv($handle)) !== false) {
        $rows[] = $data;
    }
    fclose($handle);
    for ($i = count($rows) - 1; $i >= 0; $i--) {
        $data = $rows[$i];
        $stamp = lastheard_field($data, 0);
        $date_eu = explode('-', substr($stamp, 0, 10));
        $day = isset($date_eu[2]) ? $date_eu[2] : '';
        $month = isset($date_eu[1]) ? $date_eu[1] : '';
        $year = isset($date_eu[0]) ? $date_eu[0] : '';
        $tg = substr(lastheard_field($data, 8), 2);
        $user_id = lastheard_field($data, 10);
        $user_call = lastheard_field($data, 11);
        $user_name = lastheard_field($data, 12);
        $duration = lastheard_field($data, 1);
        $system = lastheard_field($data, 4);
        $tgname = lastheard_field($data, 9);
        if ($user_id === '1234567') {
            $user_call = '*NoCallsign*';
            $user_id = '-';
        }
        echo '<tr class="log" style="height:25px; text-align: center;">';
        echo '<td class="log">&nbsp;'.htmlspecialchars($day.'.'.$month.'.'.$year).'</td>';
        echo '<td class="log">&nbsp;'.htmlspecialchars(substr($stamp, 11, 5)).'</td>';
        echo '<td class="log"><span style="color:#0066ff;"><b>&nbsp;'.htmlspecialchars($user_call).'</b></span>';
        echo '<span style="font-size:smaller;"> ('.htmlspecialchars($user_id).')</span></td>';
        echo '<td class="log"><span style="color:#002d62;"><b>'.htmlspecialchars(trim($user_name)).'</b></span></td>';
        echo '<td class="log"><span style="color:#b5651d;"><b>'.htmlspecialchars($tg).'</b></span></td>';
        echo '<td class="log"><span style="color:green;"><b>&nbsp;'.htmlspecialchars($tgname).'</b></span></td>';
        echo '<td class="log" style="text-align:center;">'.htmlspecialchars((string)round((float)$duration)).'</td>';
        echo '<td class="log">'.htmlspecialchars($system).'</td>';
        echo "</tr>\n";
    }
}
?>
          </table>
        </fieldset>
      </div>
    </div>
    <!--footer-->
    <?php include_once 'elements/footer.php'; ?>
    <!--//footer-->
  </div>
</body>
</html>
