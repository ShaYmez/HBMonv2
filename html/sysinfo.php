<?php
include_once 'include/config.php';
include_once 'include/version.php';
include_once 'include/seo.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="300">
<?php hbmon_seo_head('System Info'); ?>
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
    <!--
    <div>
      <a class="button link" target="_blank" href="esm/">&nbsp;eZ Server Monitor&nbsp;</a>
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
