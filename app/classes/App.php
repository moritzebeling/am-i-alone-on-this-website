<?php

class App {

  // Time
  protected $time;

  // Id
  public $id;

  // Storage
  protected $storage;

  // int
  public $companions;

  public function __construct(){

    $this->setId();

    $this->time = new Time();
    $this->storage = new Storage( $this->time, $this->id );

    $this->storage->report();
    $this->companions = count( $this->storage->index() );

  }

  public function __toString(): string
  {
    return strval( $this->companions );
  }

  public function status(): string
  {
    if( $this->companions === 0 ){
      return 'alone';
    }
    return 'companion';
  }

  public function setId()
  {
    if( isset($_GET['id']) ){
      $id = htmlspecialchars( $_GET['id'] );
    } else if ( isset($_COOKIE['id']) ) {
      $id = htmlspecialchars( $_COOKIE['id'] );
    } else {
      $id = md5( microtime() .'-'. rand(0,100000) );
    }
    setcookie("id", $id, time()+3600);
    $this->id = $id;
    return $id;
  }

}
