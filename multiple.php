<?php
require_once('functions.php');

if(isset($_GET)) {
  if(isset($_GET['aps'])) {
    $aps = explode(',', $_GET['aps']);
  } else {
    $aps = array();
  }
  if(isset($_GET['mls'])) {
    $mls = explode(',', $_GET['mls']);
  } else {
    $mls = array();
  }
  if(isset($_GET['dvs'])) {
    $dvs = explode(',', $_GET['dvs']);
  } else {
    $dvs = array();
  }

  /*

  1. Average each dimension so you are plotting on the same slice for each point.
  2. Get each atlas with one fixed point.

  */

  $query = array();
  $query['aps'] = $_GET['aps'];
  $query['mls'] = $_GET['mls'];
  $query['dvs'] = $_GET['dvs'];

  $avg_ap = 0;
  $avg_ml = 0;
  $avg_dv = 0;
  if(count($aps) == count($mls) && count($aps) == count($dvs)) {
    for($i=0;$i<count($aps);$i++) {
      $avg_ap += $aps[$i];
      $avg_ml += $mls[$i];
      $avg_dv += $dvs[$i];
      //$atlases[$i] = get_atlas($aps[$i], $mls[$i], $dvs[$i]);
    }

    $avg_ap = $avg_ap / $i;
    $avg_ml = $avg_ml / $i;
    $avg_dv = $avg_dv / $i;

    if(isset($_GET['show_channel'])) {
      $channel = (int)$_GET['show_channel'];
      $ap_slice = $aps[$channel - 1];
      $ml_slice = $mls[$channel - 1];
      $dv_slice = $dvs[$channel - 1];
    } else {
      $ap_slice = $avg_ap;
      $ml_slice = $avg_ml;
      $dv_slice = $avg_dv;
    }

    $ap_atlases = array();
    $queries = array();
    for($i=0;$i<count($aps);$i++) {
      $ap_atlases[$i] = get_atlas($ap_slice, $mls[$i], $dvs[$i]);
      $tmp = array();
      $tmp['show_channel'] = $i + 1;
      $queries[$i] = http_build_query(array_merge($query, $tmp));
    }
    $ml_atlases = array();
    for($i=0;$i<count($mls);$i++) {
      $ml_atlases[$i] = get_atlas($aps[$i], $ml_slice, $dvs[$i]);
    }
    $dv_atlases = array();
    for($i=0;$i<count($dvs);$i++) {
      $dv_atlases[$i] = get_atlas($aps[$i], $mls[$i], $dv_slice);
    }

  }
}

$dot_px = 10;

//var_dump($atlases);

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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <style>
      <?php if(!empty($ap_atlases)): ?>
        <?php for($i=0;$i<count($ap_atlases);$i++): ?>
          <?php $step = floor(300 / (count($ap_atlases) - 1)); ?>
          <?php
            $red = floor(($aps[$i] + 6) * (255/8));
            $green = floor(abs($mls[$i]) * (255/5));
            $blue = floor($dvs[$i] * (255/10));
          ?>
          <?php $blur = floor(abs($aps[$i] - $ap_slice)); ?>
          .dot-ap<?php echo $i; ?> {
            border:rgb(<?php echo $red;?>, <?php echo $green; ?>, <?php echo $blue; ?>) <?php echo $dot_px / 2; ?>px solid;
            width: 0px;
            height: 0px;
            border-radius: 50%;
            position:absolute;

            -webkit-filter: blur(<?php echo $blur; ?>px); 
            -moz-filter: blur(<?php echo $blur; ?>px); 
            filter: blur(<?php echo $blur; ?>px);
          }
        <?php endfor; ?>
      <?php endif; ?>

      <?php if(!empty($ml_atlases)): ?>
        <?php for($i=0;$i<count($ml_atlases);$i++): ?>
          <?php
            $red = floor(($aps[$i] + 6) * (255/8));
            $green = floor(abs($mls[$i]) * (255/5));
            $blue = floor($dvs[$i] * (255/10));
          ?>
          <?php $blur = floor(abs($mls[$i] - $ml_slice)); ?>
          .dot-ml<?php echo $i; ?> {
            border:rgb(<?php echo $red;?>, <?php echo $green; ?>, <?php echo $blue; ?>) <?php echo $dot_px / 2; ?>px solid;
            width: 0px;
            height: 0px;
            border-radius: 50%;
            position:absolute;

            -webkit-filter: blur(<?php echo $blur; ?>px); 
            -moz-filter: blur(<?php echo $blur; ?>px); 
            filter: blur(<?php echo $blur; ?>px);
          }
        <?php endfor; ?>
      <?php endif; ?>

      <?php if(!empty($dv_atlases)): ?>
        <?php for($i=0;$i<count($dv_atlases);$i++): ?>
          <?php
            $red = floor(($aps[$i] + 6) * (255/8));
            $green = floor(abs($mls[$i]) * (255/5));
            $blue = floor($dvs[$i] * (255/10));
          ?>
          <?php $blur = floor(abs($dvs[$i] - $dv_slice)); ?>
          .dot-dv<?php echo $i; ?> {
            border:rgb(<?php echo $red;?>, <?php echo $green; ?>, <?php echo $blue; ?>) <?php echo $dot_px / 2; ?>px solid;
            width: 0px;
            height: 0px;
            border-radius: 50%;
            position:absolute;

            -webkit-filter: blur(<?php echo $blur; ?>px); 
            -moz-filter: blur(<?php echo $blur; ?>px); 
            filter: blur(<?php echo $blur; ?>px);
          }
        <?php endfor; ?>
      <?php endif; ?>
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

    <div style="text-align:center;margin-left:0;" class="row">
      <div class ="span12">
        <p class="try"><small><a href="/rat-brain-atlas">Full Atlas</a> &bull; <a href="./tetrodes.php">Tetrode Tool</a></small></p>
      </div>
    </div>

    <br/>

    <div style="text-align:center;margin-left:0;" class="row page">
      <?php if(isset($_GET['show_channel'])): ?>
        <p><strong>Channel <?php echo $_GET['show_channel']; ?></strong> of <?php echo count($aps); ?> &mdash; Click a dot to change focus</p>
      <?php endif; ?>

      <p>
        <?php for($i=0;$i<count($ap_atlases);$i++): ?>
          <button type="button" class="btn btn-default btn-xs" href="#" onclick="$('.dot-ap<?php echo $i; ?>').tooltip('toggle');return false;"><?php echo $i+1; ?></button>
        <?php endfor; ?>
      </p>

      <hr/>

      <p class="lead">Coronal</p>
      <?php if(!empty($ap_atlases)): ?>
        <div class ="span12">
          <?php for($i=0;$i<count($ap_atlases);$i++): ?>
            <a href="/rat-brain-atlas/multiple.php?<?php echo $queries[$i]; ?>"><div data-toggle="tooltip" title="<?php echo $i+1; ?>" class="dot-ap<?php echo $i; ?>" style="margin-left:<?php echo ($ap_atlases[$i]['coronal']['left']) - ($dot_px / 2); ?>px;margin-top:<?php echo ($ap_atlases[$i]['coronal']['top']) - ($dot_px / 2); ?>px;"></div></a>
          <?php endfor; ?>
          <img src="<?php echo $ap_atlases[0]['coronal']['image']; ?>" />
        </div>
      <?php endif; ?>
    </div>

    <div style="text-align:center;margin-left:0;" class="row page">
      <p class="lead">Sagittal</p>
      <div class ="span12">
        <?php if(!empty($ml_atlases)): ?>
          <?php for($i=0;$i<count($ml_atlases);$i++): ?>
            <a href="/rat-brain-atlas/multiple.php?<?php echo $queries[$i]; ?>"><div data-toggle="tooltip" title="<?php echo $i+1; ?>" class="dot-ml<?php echo $i; ?>" style="margin-left:<?php echo ($ml_atlases[$i]['sagittal']['left']) - ($dot_px / 2); ?>px;margin-top:<?php echo ($ml_atlases[$i]['sagittal']['top']) - ($dot_px / 2); ?>px;"></div></a>
          <?php endfor; ?>
          <img src="<?php echo $ap_atlases[0]['sagittal']['image']; ?>" />
        <?php endif; ?>
      </div>
    </div>

    <div style="text-align:center;margin-left:0;" class="row">
      <p class="lead">Horizontal</p>
      <div class ="span12">
        <?php if(!empty($dv_atlases)): ?>
          <?php for($i=0;$i<count($dv_atlases);$i++): ?>
            <a href="/rat-brain-atlas/multiple.php?<?php echo $queries[$i]; ?>"><div data-toggle="tooltip" title="<?php echo $i+1; ?>" class="dot-dv<?php echo $i; ?>" style="margin-left:<?php echo ($dv_atlases[$i]['horizontal']['left']) - ($dot_px / 2); ?>px;margin-top:<?php echo ($dv_atlases[$i]['horizontal']['top']) - ($dot_px / 2); ?>px;"></div>
          <?php endfor; ?></a>
          <img src="<?php echo $ap_atlases[0]['horizontal']['image']; ?>" />
        <?php endif; ?>
      </div>
    </div>

    <hr>

    <div style="text-align:center;" class="row">
      <p><strong>Atlas Source:</strong> Paxinos, George, and Charles Watson. <em>The rat brain in stereotaxic coordinates: hard cover edition.</em> Access Online via Elsevier, 2006.</p>
    </div>
    <br/>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">

      $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

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
