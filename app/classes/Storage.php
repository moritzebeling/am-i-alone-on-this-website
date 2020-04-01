<?php

require_once 'Folder.php';

class Storage {

  // Time
  protected $time;

  // Ip
  protected $ip;

  // Directory
  protected $storage;

  public function __construct( Time $time, Ip $ip )
  {
    $this->time = $time;
    $this->ip = $ip;

    $this->storage = new Folder('data');
    $this->cleanOld();

  }

  public function reportPresence()
  {
    $this->storage->folder( $this->time->stamp() )->file( $this->ip->slug() );
  }

  public function cleanOld( int $seconds = 20 )
  {
    $threshold = $this->time->threshold( $seconds );

    foreach( $this->storage->folders() as $folder ){
      if( $folder < $threshold ){
        $this->storage->folder( $folder )->remove();
      }
    }

  }

  public function checkCompanion()
  {
    echo 'checkCompanion()';
  }

}
