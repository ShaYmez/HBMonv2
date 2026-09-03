<?php
$progname = basename($_SERVER['SCRIPT_FILENAME'],".php");
include_once 'include/config.php';
include_once 'include/version.php';
include_once 'include/tgid_store.php';
$tg = tgid_load(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HBlink3 DMR Server - Talkgroup Info</title>
  <script type="text/javascript" src="scripts/hbmon.js"></script>
  <link rel="stylesheet" type="text/css" href="css/styles.php" />
  <meta name="description" content="Copyright &copy; 2016-2025. The Regents of the K0USY Group. All rights reserved. Version SP2ONG 2019-2025 HBlink3 Dashboard" />
</head>
<body style="background-color: #d0d0d0;font: 10pt arial, sans-serif;">
  <div style="text-align: center;">
    <div style="width:1100px; text-align: center; margin:5px auto 0;">
      <p style="font-size: 10px; text-align: right; margin-right: 16px">Dashboard Version: <?php echo htmlspecialchars(DASH); ?></p>
      <img src="img/HBLINK_logoV2.png?random=323527528432525.24234" alt="HBlink Logo" />
    </div>
    <div style="width: 1100px; margin: 0 auto;">
      <p style="text-align:center;"><span style="color:#000;font-size: 18px; font-weight:bold;"><?php echo htmlspecialchars(REPORT_NAME);?></span></p>
    </div>
    <?php include_once 'buttons.html'; ?>
    <!-- TG table -->
    <div style="width: 1100px; margin: 0 auto;">
      <fieldset style="box-shadow:0 0 10px #999; background-color:#e0e0e0; width:1050px; margin-left:15px; margin-right:15px; font-size:14px; border-radius: 10px;">
        <legend><b><span style="color:#000;">&nbsp;.: Talk Groups :.&nbsp;</span></b></legend>
        <a href="tgmanager.php"><button class="button link">&nbsp;Login&nbsp;</button></a>
        <table class="tg-table" style="margin-top:5px; table-layout:fixed; font: 10pt arial, sans-serif; background-color: #f9f9f9;">
          <tr class="theme_color" style="height: 32px; font: 10pt arial, sans-serif; border:0;">
            <th style='width: 150px;'>TG#</th>
            <th style='width: 900px;'>Description</th>
          </tr>
<?php foreach ($tg['records'] as $record) {
    $id = tgid_record_id($record);
    if ($id < 1) {
        continue;
    }
    $name = tgid_record_callsign($record);
?>
          <tr>
            <td>&nbsp;<b>TG <?php echo htmlspecialchars((string)$id); ?></b>&nbsp;</td>
            <td><?php echo htmlspecialchars($name); ?></td>
          </tr>
<?php } ?>
        </table>
      </fieldset>
    </div>
    <br>
    <!--footer-->
    <?php include_once 'elements/footer.php'; ?>
    <!--//footer-->
  </div>
</body>
</html>
