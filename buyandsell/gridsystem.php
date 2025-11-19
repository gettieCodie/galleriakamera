<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $title ?? "Red Transparency Guide Template"; ?></title>

  <style>
    body.guide-on .guide-overlay {
      display: block;
    }

    .guide-overlay {
      position: fixed;
      inset: 0;
      background: rgba(255, 0, 0, 0.06);
      pointer-events: none;
      z-index: 9999;
      display: none;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f7f7f7;
    }

    /* GRID SYSTEM */
    .grid-overlay {
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 9998;
      display: block;
    }

    .grid-cols {
      height: 100%;
      max-width: 1300px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(14, 1fr);
      gap: 16px;
      padding: 0 20px;
    }

    .col {
      background: rgba(255, 0, 0, 0.04);
    }

  </style>
</head>
<body class="guide-on">

  <div class="guide-overlay"></div>

  <div class="grid-overlay">
    <div class="grid-cols">
      <div class="col"></div><div class="col"></div><div class="col"></div><div class="col"></div>
      <div class="col"></div><div class="col"></div><div class="col"></div><div class="col"></div>
      <div class="col"></div><div class="col"></div><div class="col"></div><div class="col"></div>
      <div class="col"></div><div class="col"></div>
    </div>
  </div>

</body>
</html>
