<?php
include_once 'include/config.php';
include_once 'include/version.php';
include_once 'include/tgid_store.php';
include_once 'include/seo.php';
$tg = tgid_load(true);
$tg_api_url = tgid_public_json_url();
$item_list = array();
foreach ($tg['records'] as $record) {
    $id = tgid_record_id($record);
    if ($id < 1) {
        continue;
    }
    $item_list[] = array(
        'id' => (string)$id,
        'name' => tgid_record_callsign($record),
    );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php hbmon_seo_head('Talkgroup Info', array('item_list' => $item_list)); ?>
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
    <!-- TG table -->
    <div style="width: 1100px; margin: 0 auto;">
      <fieldset style="box-shadow:0 0 10px #999; background-color:#e0e0e0; width:1050px; margin-left:15px; margin-right:15px; font-size:14px; border-radius: 10px;">
        <legend><b><span style="color:#000;">&nbsp;.: Talk Groups :.&nbsp;</span></b></legend>
        <a class="button link" href="tgmanager.php">&nbsp;Login&nbsp;</a>
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
        <br>
        <div class="tg-api">
          <label for="tg-api-url">Talkgroup API (Z3DMR, VoxDMR, other HBlink)</label>
          <input id="tg-api-url" type="text" readonly="readonly" value="<?php echo htmlspecialchars($tg_api_url); ?>" onclick="this.select();" />
          <button type="button" class="button link" id="tg-api-copy">&nbsp;Copy URL&nbsp;</button>
          <a class="button link" href="<?php echo htmlspecialchars($tg_api_url); ?>" target="_blank" rel="noopener">&nbsp;Open JSON&nbsp;</a>
        </div>
        <a class="button link" href="json.php?download=1">&nbsp;Download JSON&nbsp;</a>
        &nbsp;
        <a class="button link" href="json.php?format=csv&amp;download=1">&nbsp;Download CSV&nbsp;</a>
        <script type="text/javascript">
          (function () {
            var btn = document.getElementById('tg-api-copy');
            var input = document.getElementById('tg-api-url');
            if (!btn || !input) {
              return;
            }
            btn.onclick = function () {
              var url = input.value;
              function done() {
                btn.textContent = ' Copied ';
                setTimeout(function () { btn.textContent = ' Copy URL '; }, 1500);
              }
              if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(done, function () {
                  input.select();
                  document.execCommand('copy');
                  done();
                });
              } else {
                input.select();
                document.execCommand('copy');
                done();
              }
            };
          })();
        </script>
      </fieldset>
    </div>
    <br>
    <!--footer-->
    <?php include_once 'elements/footer.php'; ?>
    <!--//footer-->
  </div>
</body>
</html>
