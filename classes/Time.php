<?php

class Time {

  // int
  protected $timestamp;

  public function __construct( int $timestamp = null, string $timezone = 'Europe/Berlin' )
  {
    date_default_timezone_set( $timezone );
    if( $now === null ){
      $this->timestamp = time();
    } else {
      $this->timestamp = $timestamp;
    }
    return $this;
  }

  public function __toString(): string
  {
    return $this->dateTime();
  }

  public function stamp(): int
  {
    return $this->timestamp;
  }

  public function date( string $format = 'Y-m-d' ): string
  {
    return date( $format , $this->timestamp );
  }

  public function time( string $format = 'H:i' ): string
  {
    return date( $format , $this->timestamp );
  }

  public function dateTime( string $format = 'Y-m-d H:i' ): string
  {
    return date( $format , $this->timestamp );
  }

  public function round( int $seconds = 5 ): int
  {
    return round( $this->timestamp / $seconds ) * $seconds;
  }

}
