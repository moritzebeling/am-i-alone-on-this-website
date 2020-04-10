<?php

class Storage {

  // Time of visit
  protected $time;

  // Ip of visitor
  protected $ip;

  // String with root path of `/data`
  protected $store;

  // Array with ips
  protected $companions;

  public function __construct( Time $time, Ip $ip )
  {
    $this->time = $time;
    $this->ip = $ip;

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

    $file = $folder . DS . $this->ip;
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
  public function index( int $seconds = 10 ): array
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
        $ips = scandir( $this->store . DS . $timeslot );
        foreach( $ips as $ip ){
          if( substr($ip, 0, 1) === '.' ){
            continue;
          }
          if( in_array( $ip, $this->companions ) ){
            continue;
          }
          if( $ip === $this->ip ){
            continue;
          }
          $this->companions[] = $ip;
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
