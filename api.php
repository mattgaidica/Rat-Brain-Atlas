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

echo json_encode($atlas);