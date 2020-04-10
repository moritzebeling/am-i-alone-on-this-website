<?php

class Storage {

  // Time of visit
  protected $time;

  // id of visitor
  protected $id;

  // String with root path of `/data`
  protected $store;

  // Array with ids
  protected $companions;

  public function __construct( Time $time, $id )
  {
    $this->time = $time;
    $this->id = $id;

    $this->store = ROOT . DS . 'data';

    if( !is_dir( $this->store ) ){
      if ( mkdir( $this->store, 0777, true) ) {
        // data directory created
      } else {
        throw new Exception('Could not create ' . $this->store);
        return;
      }
    }
  }
  public function report(): bool
  {
    $folder = $this->store . DS . $this->time;

    if( !is_dir( $folder ) ){
      if ( mkdir( $folder, 0777, true) ) {
        // data directory created
      } else {
        throw new Exception('Could not create ' . $folder);
        return false;
      }
    }

    $file = $folder . DS . $this->id;
    if( is_file( $file ) ){
      return true;
    }
    if ( touch( $file ) ) {
      return true;
    } else {
      throw new Exception('Could not create ' . $file);
      return false;
    }
  }
  public function index( int $seconds = 5 ): array
  {
    $this->companions = [];

    $timeslots = scandir( $this->store );
    $threshold = $this->time->threshold( $seconds );

    foreach( $timeslots as $timeslot ){
      if( substr($timeslot, 0, 1) === '.' ){
        continue;
      }
      if( $timeslot < $threshold ){
        $this->remove( $timeslot );
      } else {
        $ids = scandir( $this->store . DS . $timeslot );
        foreach( $ids as $id ){
          if( substr($id, 0, 1) === '.' ){
            continue;
          }
          if( in_array( $id, $this->companions ) ){
            continue;
          }
          if( $id === $this->id ){
            continue;
          }
          $this->companions[] = $id;
        }
      }
    }

    return $this->companions;

  }

  public function remove( $timeslot ){
    if( $timeslot === '.' || $timeslot === '..' ){
      return false;
    }
    $timeslot = $this->store . DS . $timeslot;

    $folder = opendir( $timeslot );
    while( $file = readdir( $folder ) ) {
      if( $file === '.' || $file === '..' ){
        continue;
      }
      unlink( $timeslot . DS . $file );
    }
    closedir( $folder );
    rmdir( $timeslot );
    return true;
  }

}
