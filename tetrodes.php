<?php
require_once('functions.php');

if(isset($_GET)) {
  if(isset($_GET['ap'])) {
    $ap = (float) $_GET['ap'];
  } else {
    $ap = 0;
  }
  if(isset($_GET['ml'])) {
    $ml = (float) $_GET['ml'];
  } else {
    $ml = 0;
  }
}

$dot_px = 10;

if(isset($_GET['startdv']) && $_GET['startdv'] != '') {
  $dv = $_GET['startdv'];
} else {
  $dv = 0;
}

$atlas = get_atlas($ap, $ml, $dv, $dot_px);

if(isset($_GET['targetdv']) && $_GET['targetdv'] != '') {
  $target_atlas = get_atlas($ap, $ml, $_GET['targetdv'], $dot_px);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Rat Brain Atlas - Tetrodes<?php if(isset($_GET)){ echo " ml=".$_GET['ml'].", ap=".$_GET['ap'].", dv=".$_GET['dv']; }?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Matt Gaidica">

    <link href="https://fonts.googleapis.com/css?family=Stalemate" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Raleway:600,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" media="screen,print" href="css/bootstrap.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="favicon.png">

    <style>
      .dot {
        border:red <?php echo $dot_px / 2; ?>px solid;
        width: 0px;
        height: 0px;
        border-radius: 50%;
        position:absolute;
      }
      .triangle {
        border:blue 2px solid;
        width: <?php echo $dot_px / 2; ?>px;
        height: <?php echo $dot_px / 2; ?>px;
        border-radius: 50%;
        position:absolute;
      }
      /*.triangle {
        position:absolute;
        width: 0; 
        height: 0; 
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 10px solid blue;
      }*/
    </style>
  </head>

  <body>

    <div class="container marketing">
      <div style="text-align:center;" class="featurette">
        <h2 class="featurette-heading">Rat Brain Atlas</h2>
      </div>
    </div>
    <form class="form-inline">
      <div style="text-align:center;" class="row">
        <div class="span12" style="margin-left:32px;">
            <div class="input-prepend input-append" style="display:inline-block;">
              <span class="add-on">ML</span>
              <input name="ml" value="<?php echo $_GET['ml']; ?>" class="span2" id="appendedPrependedInput" type="text" style="width:50px;">
              <span class="add-on">mm</span>
            </div>&nbsp;&nbsp;
            <div class="input-prepend input-append" style="display:inline-block;">
              <span class="add-on">AP</span>
              <input name="ap" value="<?php echo $_GET['ap']; ?>" class="span2" id="appendedPrependedInput" type="text" style="width:50px;">
              <span class="add-on">mm</span>
            </div>&nbsp;&nbsp;
           <!--  <div class="input-prepend input-append" style="display:inline-block;">
              <span class="add-on">DV</span>
              <input name="dv" value="<?php echo $_GET['dv']; ?>" class="span2" id="appendedPrependedInput" type="text" style="width:50px;">
              <span class="add-on">mm</span>
            </div>&nbsp;&nbsp; -->
            <button type="submit" class="btn btn-success">Submit</button>
            </br><br/>
            <p class="try"><small><a href="http://gaidi.ca/rat-brain-atlas/tetrodes.php?ml=3.62&ap=-.4&dv=0&port=6&channels=10%2C12%2C14%2C16&target=Striatum&targetdv=5.5&turns=22">CPu caudate putamen (striatum)</a> &bull; <a href="http://gaidi.ca/rat-brain-atlas/tetrodes.php?ml=2&ap=-5.7&dv=0&port=32&channels=58%2C60%2C62%2C64&target=SNr&targetdv=8.4&turns=33.6">SNR Substantia Nigra Pars Reticulata</a> &bull; <a href="./">Full Atlas</a></small></p>
        </div>
      </div>

      <hr/>

      <div style="text-align:center;margin-left:0;" class="row">
        <div style="text-align:left;" class ="span4">
          <div style="padding-bottom:10px;" class="input-prepend input-append">
            <span class="add-on" style="width:100px;">Port</span>
            <input name="port" value="<?php echo $_GET['port']; ?>" class="span2" id="appendedPrependedInput" type="text" style="width:175px;">
          </div>
          <div style="padding-bottom:10px;" class="input-prepend input-append">
            <span class="add-on" style="width:100px;">Channels</span>
            <input name="channels" value="<?php echo $_GET['channels']; ?>" class="span2" id="appendedPrependedInput" type="text" style="width:175px;">
          </div>
          <div style="padding-bottom:10px;" class="input-prepend input-append">
            <span class="add-on" style="width:100px;">Target</span>
            <input name="target" value="<?php echo $_GET['target']; ?>" class="span2" id="appendedPrependedInput" type="text" style="width:175px;">
          </div>
          <div style="padding-bottom:10px;" class="input-prepend input-append">
            <span class="add-on" style="width:100px;">Start DV</span>
            <input name="startdv" value="<?php echo $_GET['startdv']; ?>" class="span2" id="appendedPrependedInput" type="text" style="width:140px;">
            <span class="add-on">mm</span>
          </div>
          <div style="padding-bottom:10px;" class="input-prepend input-append">
            <span class="add-on" style="width:100px;">Target DV</span>
            <input name="targetdv" value="<?php echo $_GET['targetdv']; ?>" class="span2" id="appendedPrependedInput" type="text" style="width:140px;">
            <span class="add-on">mm</span>
          </div>
          <div style="padding-bottom:10px;" class="input-prepend input-append">
            <span class="add-on" style="width:100px;">Turns</span>
            <input name="turns" value="<?php echo $_GET['turns']; ?>" class="span2" id="appendedPrependedInput" type="text" style="width:175px;">
          </div>
      </form>
        <br/>
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Date</th>
              <th>Turns</th>
              <th>(mm)</th>
              <th style="width:50%;">Notes</th>
            </tr>
          </thead>
          <tbody>
            <?php for($i=0;$i<20;$i++): ?>
            <tr style="height:35px;">
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <?php endfor; ?>
          </tbody>
        </table>
      </div>
      <div class ="span8">
        <p class="lead">Coronal</p>
        <div class="dot" style="margin-left:<?php echo ($atlas['coronal']['left'] / (940/620)) - ($dot_px / 2); ?>px;margin-top:<?php echo ($atlas['coronal']['top'] / (940/620)) - ($dot_px / 2); ?>px;"></div>
        <?php if(isset($target_atlas)): ?>
          <div class="triangle" style="margin-left:<?php echo ($target_atlas['coronal']['left'] / (940/620)) - ($dot_px / 2); ?>px;margin-top:<?php echo ($target_atlas['coronal']['top'] / (940/620)) - ($dot_px / 2); ?>px;"></div>
        <?php endif; ?>
        <img src="<?php echo $atlas['coronal']['image']; ?>" />

        <p class="lead">Sagittal</p>
        <div class="dot" style="margin-left:<?php echo ($atlas['sagittal']['left'] / (940/620)) - ($dot_px / 2); ?>px;margin-top:<?php echo ($atlas['sagittal']['top'] / (940/620)) - ($dot_px / 2); ?>px;"></div>
        <?php if(isset($target_atlas)): ?>
          <div class="triangle" style="margin-left:<?php echo ($target_atlas['sagittal']['left'] / (940/620)) - ($dot_px / 2); ?>px;margin-top:<?php echo ($target_atlas['sagittal']['top'] / (940/620)) - ($dot_px / 2); ?>px;"></div>
        <?php endif; ?>
        <img src="<?php echo $atlas['sagittal']['image']; ?>" />
      </div>
    </div>

    <hr>

    <div style="text-align:center;margin-left:0;" class="row">
      <p><strong>Atlas Source:</strong> Paxinos, George, and Charles Watson. <em>The rat brain in stereotaxic coordinates: hard cover edition.</em> Access Online via Elsevier, 2006.</p>
    </div>
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-34484337-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
  </body>
</html>
