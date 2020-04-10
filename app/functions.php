<?php

function dump( $variable ){
  echo '<pre style="margin: 1rem 0; padding: 1rem; border: 1px solid #ccc;">';

    $backtrace = debug_backtrace();
    echo '<div style="color:#ccc;">';
    echo $backtrace[0]['file'] . ' at line ' . $backtrace[0]['line'];
    echo '</div>';

  echo print_r($variable, true);
  echo '</pre>';
}

function toPath( array $parts = [] ): string {
  $parts = array_filter( $parts );
  return implode(DS, $parts );
}
