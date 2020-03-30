<?php

class Ip {

  // string
  protected $address = '';

  public function __construct( bool $getVisitorIp = true )
  {
    if( $getVisitorIp === true ){
      $this->getVisitorIp();
    }
    return $this;
  }

  public function __toString(): string
  {
    return $this->address;
  }

  public function slug( string $glue = '-' ): string
  {
    return preg_replace('/([^0-9a-z])/i', $glue, $this->address);
  }

  public function getVisitorIp(): string
  {
    $ip = 'localhost';
    if (getenv('HTTP_CLIENT_IP')){
      $ip = getenv('HTTP_CLIENT_IP');
    } else if(getenv('HTTP_X_FORWARDED_FOR')){
      $ip = getenv('HTTP_X_FORWARDED_FOR');
    } else if(getenv('HTTP_X_FORWARDED')){
      $ip = getenv('HTTP_X_FORWARDED');
    } else if(getenv('HTTP_FORWARDED_FOR')){
      $ip = getenv('HTTP_FORWARDED_FOR');
    } else if(getenv('HTTP_FORWARDED')){
      $ip = getenv('HTTP_FORWARDED');
    } else if(getenv('REMOTE_ADDR')){
      $ip = getenv('REMOTE_ADDR');
    } else {
      $ip = 'localhost';
    }
    $this->address = $ip;
    return $this;
  }

}
