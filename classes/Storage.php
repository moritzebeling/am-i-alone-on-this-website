<?php

class Storage {

  // string
  protected $path = '';

  // oktal
  protected $mode = 0777;

  public function __construct()
  {
    $this->path = $_SERVER['DOCUMENT_ROOT'].'/data';
    $this->checkPermissions();
  }

  public function reportPresence()
  {
    echo 'reportPresence()';
  }

  public function checkCompanion()
  {
    echo 'checkCompanion()';
  }

  public function checkPermissions(){
    echo 'checkPermissions()';
    chmod( $this->path , $this->mode );
  }

}
