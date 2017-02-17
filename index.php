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
  if(isset($_GET['dv'])) {
    $dv = (float) $_GET['dv'];
  } else {
    $dv = 0;
  }
}

$dot_px = 10;

$atlas = get_atlas($ap, $ml, $dv);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Rat Brain Atlas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Matt Gaidica">

    <link href="https://fonts.googleapis.com/css?family=Stalemate" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Raleway:600,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" media="screen,print" href="css/bootstrap.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <style>
      .dot {
        border:red <?php echo $dot_px / 2; ?>px solid;
        width: 0px;
        height: 0px;
        border-radius: 50%;
        position:absolute;
      }
    </style>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="favicon.png">
  </head>

  <body>

    <div class="container marketing">
      <div style="text-align:center;" class="featurette">
        <h2 class="featurette-heading">Rat Brain Atlas</h2>
      </div>
    </div>

    <?php 
      if(isset($_GET)) {
        if(isset($_GET['title'])) {
          echo '<p style="text-align:center;">'.$_GET['title'].'</p>';
        }
      }
    ?>

    <div style="text-align:center;margin-left:0;" class="row">
      <div class ="span12">
        <form class="form-inline">
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
            <div class="input-prepend input-append" style="display:inline-block;">
              <span class="add-on">DV</span>
              <input name="dv" value="<?php echo $_GET['dv']; ?>" class="span2" id="appendedPrependedInput" type="text" style="width:50px;">
              <span class="add-on">mm</span>
            </div>&nbsp;&nbsp;
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
        <!--<p>
          <small>Coronal (0, 0) : (medial, Bregma)</small>
          <br/>
          <small>sagittal (0, 0) : (Bregma, Bregma)</small>
          <br/>
          <small>Horizontal (0, 0) : (Bregma, medial)</small>
        </p>-->
        <p class="try"><small><a href="/mouse-brain-atlas">Mouse Brain Atlas</a> &bull; <a href="?ml=2.7&ap=.43&dv=5.4">CPu caudate putamen (striatum)</a></small></p>
      </div>
    </div>

    <hr/>

    <div style="text-align:center;margin-left:0;" class="row page">
      <p class="lead">Coronal</p>
      <div class ="span12">
        <div class="dot" style="margin-left:<?php echo ($atlas['coronal']['left']) - ($dot_px / 2); ?>px;margin-top:<?php echo ($atlas['coronal']['top']) - ($dot_px / 2); ?>px;"></div>
        <img src="<?php echo $atlas['coronal']['image_url']; ?>" />
      </div>
    </div>

    <div style="text-align:center;margin-left:0;" class="row page">
      <p class="lead">Sagittal</p>
      <div class ="span12">
        <div class="dot" style="margin-left:<?php echo ($atlas['sagittal']['left']) - ($dot_px / 2); ?>px;margin-top:<?php echo ($atlas['sagittal']['top']) - ($dot_px / 2); ?>px;"></div>
        <img src="<?php echo $atlas['sagittal']['image_url']; ?>" />
      </div>
    </div>

    <div style="text-align:center;margin-left:0;" class="row">
      <p class="lead">Horizontal</p>
      <div class ="span12">
        <div class="dot" style="margin-left:<?php echo ($atlas['horizontal']['left']) - ($dot_px / 2); ?>px;margin-top:<?php echo ($atlas['horizontal']['top']) - ($dot_px / 2); ?>px;"></div>
        <img src="<?php echo $atlas['horizontal']['image_url']; ?>" />
      </div>
    </div>

    <hr>

    <div style="text-align:center;" class="row">
      <p><strong>Atlas Source:</strong> Paxinos, George, and Charles Watson. <em>The rat brain in stereotaxic coordinates: hard cover edition.</em> Access Online via Elsevier, 2006.</p>
      <p>A tool by <a href="http://gaidi.ca">Matt Gaidica</a></p>
    </div>
    <br/>

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
