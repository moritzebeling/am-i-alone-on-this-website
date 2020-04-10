<?php

class App {

  // Time
  protected $time;

  // Ip
  protected $ip;

  // Storage
  protected $storage;

  // bool
  protected $companions;

  public function __construct(){

    $this->time = new Time();
    $this->ip = new Ip();
    $this->storage = new Storage( $this->time, $this->ip );

    $this->storage->report();
    $this->companions = count( $this->storage->index() ) - 1;

  }

  public function __toString(): string
  {
    return strval( $this->companions );
  }

}
