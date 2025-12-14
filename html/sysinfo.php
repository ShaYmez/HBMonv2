<?php
$progname = basename($_SERVER['SCRIPT_FILENAME'],".php");
include_once 'include/config.php';
include_once 'include/version.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="300">
  <title>HBlink3 DMR Server - System Info</title>
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
    <!--
    <div>
      <a target="_blank" href="esm/"><button class="button link">&nbsp;eZ Server Monitor&nbsp;</button></a>
    </div>
    -->
    <fieldset style="background-color:#e0e0e0; display:inline-block; margin-left:20px; margin-right:20px; font-size:14px; border-radius: 10px;">
      <legend><b><span style="color:#000;">&nbsp;.: System Info :.&nbsp;</span></b></legend>
      <div style="text-align: center;">
        <!-- Temp CPU -->
        <p><img alt="CPU Temperature" src="img/tempC.png" /></p>
        <!-- Disk usage -->
        <p><img alt="Disk Usage" src="img/hdd.png" /></p>
        <!-- Memory usage -->
        <p><img alt="Memory Usage" src="img/mem.png" /></p>
        <!-- CPU loads -->
        <p><img alt="CPU Load" src="img/cpu.png" /></p>
        <!-- Network traffic -->
        <p><img alt="Network Traffic" src="img/mrtg/localhost_2-day.png" /></p>
      </div>
      <p><span style="color:blue;"><b>BLUE</b></span> Outgoing Traffic in Bits per Second | <span style="color:green;"><b>GREEN</b></span> Incoming Traffic in Bits per Second</p>
    </fieldset>
    <br>
    <!--footer-->
    <?php include_once 'elements/footer.php'; ?>
    <!--//footer-->
  </div>
</body>
</html>
