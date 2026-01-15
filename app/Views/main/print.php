<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>

    <style>
      @page {
        size: A4;
        margin: 4mm;
      }

      body {
        font-family: "Outfit", sans-serif;
        border: 2px solid #000;
      }

      h1 {
        margin: 0;
        padding: 0;
        font-size: 32px;
      }

      .header {
        display: flex;
      }

      .header div {
        border: 1px solid #000;
        margin-bottom: 2px;
      }

      .ket {
        display: grid;
        grid-template-columns: 2fr 1fr;
        max-width: 60%;
      }

      .ket .info {
        margin-top: 12px;
        display: grid;
        grid-template-columns: 100px 10px auto;
        margin-bottom: 8px
      }

      .ket div p {
        margin: 0;
        margin-bottom: 4px;
      }

      table, th, td {
        border-collapse: collapse;
        border: 2px solid #000;
      }

      th, td {
        padding: 8px 0;
      }

      .before-shear, .after-shear {
        width: 97%;
        margin-bottom: 8px;
      }

      .checked {
        display: flex;
        justify-content: end;
        padding-right: 40px;
        margin-bottom: 8px;
      }

      .checked table {
        width: 20%;
        text-align: center;
      }

      .checked tr.signature {
        height: 80px;
      }

      .checked tr.signature-name {
        height: 20px;
      }
    </style>
</head>
<body onload="window.print()">
<!-- <body> -->
  <div class="header">
    <div>
      <span style="width: 100%;">
        <img src="<?= base_url('icon-2.png'); ?>" width="40%" alt="" style="margin-left: 4px; margin-top: 4px;">
      </span>
    </div>
    <div style="width: 100%; display: flex; justify-content: center; align-items: center;">
      <h1>KARTU HASIL SHEARING</h1>
    </div>
  </div>

  <div class="ket">
    <div class="info">
      <div>Hari / Tanggal</div>
      <div>:</div>
      <div><?= esc($tanggal) ?></div>

      <div>Shift</div>
      <div>:</div>
      <div><?= esc($shift) ?></div>
    </div>
    <div class="info">
      <div>Mesin</div>
      <div>:</div>
      <div><?= esc($mesin) ?></div>

      <div>Operator</div>
      <div>:</div>
      <div><?= esc($operator) ?></div>
    </div>
  </div>

  <table class="before-shear">
    <thead>
      <tr>
        <th rowspan="2" style="width: 20%">No. Job</th>
        <th colspan="4" style="width: 40%">Material Hasil Sheet</th>
        <th rowspan="2" style="width: 12%">Total Sheet</th>
        <th rowspan="2">Tag ID</th>
        <th rowspan="2">Supplier</th>
      </tr>
      <tr>
        <th style="width: 20%">SPEC</th>
        <th style="width: 6%">T</th>
        <th style="width: 7%">W</th>
        <th style="width: 7%">L</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="text-align: center;"><?= esc($jobNumber) ?></td>
        <td style="text-align: center;"><?= esc($mspec) ?></td>
        <td style="text-align: center;"><?= esc($mThickness) ?></td>
        <td style="text-align: center;"><?= esc($mWidth) ?></td>
        <td style="text-align: center;"><?= esc($mLength) ?></td>
        <td style="text-align: center;"><?= esc($sheet) ?></td>
        <td></td>
        <td style="text-align: center;"><?= esc($customer) ?></td>
      </tr>
    </tbody>
  </table>

  <table class="after-shear">
    <thead>
      <tr>
        <th rowspan="2" style="width: 20%">No. Job</th>
        <th colspan="4" style="width: 40%">Material Hasil Shearing</th>
        <th rowspan="2" style="width: 12%">Bentuk</th>
        <th colspan="3">Total Sheet</th>
      </tr>
      <tr>
        <th style="width: 20%">SPEC</th>
        <th style="width: 6%">T</th>
        <th style="width: 7%">W</th>
        <th style="width: 7%">L</th>
        <th>Sheet</th>
        <th>B/Q</th>
        <th>PCS</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="text-align: center;"><?= esc($jobNumber) ?></td>
        <td style="text-align: center;"><?= esc($sspec) ?></td>
        <td style="text-align: center;"><?= esc($sThickness) ?></td>
        <td style="text-align: center;"><?= esc($sWidth) ?></td>
        <td style="text-align: center;"><?= esc($sLength) ?></td>
        <td></td>
        <td style="text-align: center;"><?= esc($sheet) ?></td>
        <td style="text-align: center;"><?= esc($bq) ?></td>
        <td style="text-align: center;"><?= esc($pcs) ?></td>
      </tr>
    </tbody>
  </table>

  <div class="checked">
    <table style="width: 36%">
      <tr>
        <td>Checked</td>
        <td>Operator</td>
      </tr>
      <tr class="signature">
        <td></td>
        <td></td>
      </tr>
      <tr class="signature-name">
        <td></td>
        <td></td>
      </tr>
    </table>
  </div>
</body>
</html>