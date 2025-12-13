<?php
$progname = basename($_SERVER['SCRIPT_FILENAME'],".php");
include_once 'include/config.php';
include_once 'include/version.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HBlink3 DMR Server - OpenBridge Systems</title>
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
    <div style="width: 1100px; margin: 0 auto;">
      <noscript>You must enable JavaScript</noscript>
      <div id="opb"></div>
    </div>
    <!--footer-->
    <?php include_once 'elements/footer.php'; ?>
    <!--//footer-->
  </div>
</body>
</html>
