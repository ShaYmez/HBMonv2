<?php
$progname = basename($_SERVER['SCRIPT_FILENAME'],".php");
include_once 'include/config.php';
include_once 'include/version.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="30">
  <title>HBlink3 DMR Server - Lastheard</title>
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
    <div style="width: 1150px; margin: 0 auto;">
      <p style="text-align:center;"><span style="color:#000;font-size: 18px; font-weight:bold;"><?php echo htmlspecialchars(REPORT_NAME);?></span></p>
    </div>
    <?php include_once 'buttons.html'; ?>
    <div style="width: 1100px; margin: 0 auto;">
      <div style="overflow-x:auto;">
        <fieldset style="background-color:#e0e0e0; margin:15px; font-size:14px; border-radius: 10px;">
          <table style="border-collapse: collapse; border: 1px solid #C1DAD7; width: 100%; background-color:#f0f0f0;">
            <thead><tr><th colspan="9" style="height: 30px; font-size:18px; font-weight:bold;">LastHeard</th></tr></thead>
            <tr class="theme_color" style="height:35px; text-align: center; font-weight:bold;"><th>&nbsp;&nbsp;Date</th><th>&nbsp;Time</th><th>&nbsp;Callsign (DMR-Id)</th><th>&nbsp;&nbsp;Name</th><th>&nbsp;TG#</th><th>&nbsp;&nbsp;TG Name</th><th>TX (s)&nbsp;</th><th>Source</th>
            </tr>

<?php
// logging extension "last heard list" for hbmonitor
// developed by Heiko Amft,DL1BZ dl1bz@bzsax.de

// define array for CSV import of logfile
$log_time=array();
$transmit_timer=array();
$calltype=array();
$event=array();
$system=array();
$src_id=array();
$src_name=array();
$ts=array();
$tg=array();
$tgname=array();
$user_id=array();
$user_call=array();
$user_name=array();

// define location and name of logfile
// best practise is write logfile in the directory where this php script is saved because some php installations have problems to read files outside the webserver directories
$handle = fopen("/opt/HBMonv2/log/lastheard.log","r");

// import to array
while (($data = fgetcsv ($handle)) !==false)
{
    $log_time[] = $data[0];
    $transmit_timer[] = $data[1];
    $calltype[] = $data[2];
    $event[] = $data[3];
    $system[] = $data[4];
    $src_id[] = $data[5];
    $src_name[] = $data[6];
    $ts[] = $data[7];
    $tg[] = $data[8];
    $tgname[] = $data[9];
    $user_id[] = $data[10];
    $user_call[] = $data[11];
    $user_name[] = $data[12];
}

// define some macros for table output
$s = "<TD class=\"log\">";
$s_r = "<TD align=\"right\">";
$s_m = "<TD align=\"center\">";

// output to html table from the newest entry to the oldest
for ($i=count($log_time)-1; $i >= 0; $i--)

{
// prepare date string for output in european format
$split_date = substr($log_time[$i],0,10);
$date_eu = explode("-", $split_date);

$ts[$i] = substr($ts[$i],-1);
$tg[$i] = substr($tg[$i],2);

// define special character convert for number zero - we write calls with number zero with this character in logs in Germany
$src_name[$i] = str_replace("0","&Oslash;",$src_name[$i]);
if (substr($user_call[$i],2,1)=="0") { $user_call[$i] = str_replace("0","&Oslash;",$user_call[$i]); }

$log_time[$i]=substr($log_time[$i],0,19);

// thats a special thing for an Id comes without DMR-Id from PEGASUS project - it means we need to convert to "NoCall" thats for calls from source ECHOLINK
if ($user_id[$i]=="1234567") {$user_call[$i] = "*NoCallsign*"; $user_id[$i]="-";}

// output table
echo "<tr class=\"log\" style=\"height:25px; text-align: center;\">";
echo "<td class=\"log\">&nbsp;".$date_eu[2].".".$date_eu[1].".".$date_eu[0]."</td>";
echo "<td class=\"log\">&nbsp;".substr($log_time[$i],11,5)."</td>";
echo "<td class=\"log\"><span style=\"color:#0066ff;\"><b>&nbsp;".htmlspecialchars($user_call[$i])."</b></span>";
echo "<span style=\"font-size:smaller;\"> (".htmlspecialchars($user_id[$i]).")</span></td>";
echo "<td class=\"log\"><span style=\"color:#002d62;\"><b>".htmlspecialchars(trim($user_name[$i]))."</b></span></td>";
echo "<td class=\"log\"><span style=\"color:#b5651d;\"><b>".htmlspecialchars($tg[$i])."</b></span></td>";
echo "<td class=\"log\"><span style=\"color:green;\"><b>&nbsp;".htmlspecialchars($tgname[$i])."</b></span></td>";
echo "<td class=\"log\" style=\"text-align:center;\">".htmlspecialchars(round($transmit_timer[$i]))."</td>";
echo "<td class=\"log\">".htmlspecialchars($system[$i])."</td>";
echo "</tr>\n";
}

echo "\n</table></fieldset></div></div>";

// close logfile after parsing
fclose ($handle);
?>
    <!--footer-->
    <?php include_once 'elements/footer.php'; ?>
    <!--//footer-->
  </div>
</body>
</html>
