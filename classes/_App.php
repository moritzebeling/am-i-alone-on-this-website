<?php

require_once 'Ip.php';
require_once 'Time.php';
require_once 'Storage.php';

function dump( $variable ){
  echo '<pre style="margin: 1rem 0; padding: 1rem; border: 1px solid #ccc;">';

    $backtrace = debug_backtrace();
    echo '<div style="color:#ccc;">';
    echo $backtrace[0]['file'] . ' at line ' . $backtrace[0]['line'];
    echo '</div>';

  echo print_r($variable, true);
  echo '</pre>';
}

class App {

  // Time
  protected $time;

  // Ip
  protected $ip;

  // Storage
  protected $storage;

  // bool
  protected $companion;

  public function __construct(){

    $this->time = new Time();
    $this->ip = new Ip();
    $this->storage = new Storage( $this->time, $this->ip );

    $this->reportPresence();
    // $this->checkCompanion();

  }

  public function __toString(): string
  {
    return strval( $this->$companion );
  }

  public function __call( string $method, array $arguments = [] )
  {
    // public property access
    if (isset($this->$method) === true) {
      return $this->$method;
    }
  }

  public function id( string $glue = '_' ): string
  {
    return $this->time->round() . $glue . $this->ip->slug();
  }

  public function reportPresence()
  {
    $this->storage->reportPresence( $this->time, $this->ip );
  }

  public function checkCompanion()
  {
    $this->storage->checkCompanion( $this->time, $this->ip );
  }

}
