<?php

require_once 'Folder.php';

class Storage {

  // Directory
  protected $storage;

  public function __construct()
  {
    $this->storage = new Folder('data');
  }

  public function reportPresence( $time, $ip )
  {
    echo 'reportPresence()';
    $this->storage->createFolder( $time->stamp() )->createFolder( $ip->slug() );
  }

  public function checkCompanion()
  {
    echo 'checkCompanion()';
  }

}
