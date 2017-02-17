<?php

function get_atlas($ap, $ml, $dv, $dot_px) {
  $csv = array();
  $csv[] = array(); //add one empty array so it starts with 1
  $file = fopen('rat-brain-atlas.csv', 'r');
  while (($line = fgetcsv($file)) !== FALSE) {
    $csv[] = $line;
  }
  fclose($file);

  $min = array();
  foreach($csv as $k => $v) {
    if($v[0] == 'coronal') {
      $min[$k] = abs($ap - (float)$v[1]);
    }
  }
  $keys = array_keys($min, min($min)); 
  $csv_coronal_key = $keys[0];

  $coronal_image = "/images/Rat_Brain_Atlas_$csv_coronal_key.jpg";
  $coronal_pixel_x_0 = $csv[$csv_coronal_key][2];
  $coronal_pixel_y_0 = $csv[$csv_coronal_key][3];
  $coronal_px_per_mm_x = $csv[$csv_coronal_key][4];
  $coronal_px_per_mm_y = $csv[$csv_coronal_key][5];

  $coronal_margin_left = ($coronal_pixel_x_0 + ($ml * $coronal_px_per_mm_x));
  $coronal_margin_top = $coronal_pixel_y_0 + ($dv * $coronal_px_per_mm_y);

  //find sagittal using ml
  $min = array();
  foreach($csv as $k => $v) {
    if($v[0] == 'sagittal') {
      $min[$k] = abs($ml - (float)$v[1]);
    }
  }
  $keys = array_keys($min, min($min)); 
  $csv_sagittal_key = $keys[0];

  $sagittal_image = "/images/Rat_Brain_Atlas_$csv_sagittal_key.jpg";
  $sagittal_pixel_x_0 = $csv[$csv_sagittal_key][2];
  $sagittal_pixel_y_0 = $csv[$csv_sagittal_key][3];
  $sagittal_px_per_mm_x = $csv[$csv_sagittal_key][4];
  $sagittal_px_per_mm_y = $csv[$csv_sagittal_key][5];

  $sagittal_margin_left = ($sagittal_pixel_x_0 + (($ap * -1) * $sagittal_px_per_mm_x)); //inverse ap
  $sagittal_margin_top = $sagittal_pixel_y_0 + ($dv * $sagittal_px_per_mm_y);

  //find horizontal using dv
  $min = array();
  foreach($csv as $k => $v) {
    if($v[0] == 'horizontal') {
      $min[$k] = abs(($dv * -1) - (float)$v[1]);
    }
  }
  $keys = array_keys($min, min($min)); 
  $csv_horizontal_key = $keys[0];

  $horizontal_image = "/images/Rat_Brain_Atlas_$csv_horizontal_key.jpg";
  $horizontal_pixel_x_0 = $csv[$csv_horizontal_key][2];
  $horizontal_pixel_y_0 = $csv[$csv_horizontal_key][3];
  $horizontal_px_per_mm_x = $csv[$csv_horizontal_key][4];
  $horizontal_px_per_mm_y = $csv[$csv_horizontal_key][5];

  $horizontal_margin_left = ($horizontal_pixel_x_0 + (($ap * -1) * $horizontal_px_per_mm_x));
  $horizontal_margin_top = $horizontal_pixel_y_0 + (($ml * -1) * $horizontal_px_per_mm_y);

  $url_path = "http://$_SERVER[HTTP_HOST]/rat-brain-atlas";
  $r = array();
  $r['coronal'] = array(
    'image_url' => $url_path . $coronal_image, 
    'left' => $coronal_margin_left, 
    'top' => $coronal_margin_top
    );
  $r['sagittal'] = array(
    'image_url' => $url_path . $sagittal_image, 
    'left' => $sagittal_margin_left, 
    'top' => $sagittal_margin_top);
  $r['horizontal'] = array(
    'image_url' => $url_path . $horizontal_image, 
    'left' => $horizontal_margin_left, 
    'top' => $horizontal_margin_top);

  return $r;
}