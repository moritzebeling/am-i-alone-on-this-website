<?php

class Storage {

  // string
  protected $basePath = '';

  // string
  protected $storagePath = '';

  // oktal
  protected $mode = 0777;

  public function __construct()
  {
    try {
        $this->setBase();
    } catch (Exception $e) {
        echo 'Error: ',  $e->getMessage(), "\n";
    }
  }

  public function reportPresence( $time )
  {
    $this->createDirectory( $time->stamp() );
  }

  public function checkCompanion()
  {
    echo 'checkCompanion()';
  }

  public function toPath( $path = '' ): string
  {
    $components = [
      $this->basePath,
      $this->storagePath
    ];
    if( is_array( $path ) ){
      array_push( $components, ...$path );
    } else if ( is_string( $path ) ) {
      array_push( $components, $path );
    }
    return implode( '/', $components );
  }

  public function directoryExists( string $path ): bool
  {
    return is_dir( $path );
  }
  public function fileExists( string $filename ): bool
  {
    return is_file( $filename );
  }

  public function setBase( string $storagePath = 'data' ){
    $this->basePath = $_SERVER['DOCUMENT_ROOT'];
    $this->storagePath = $storagePath;

    $this->createDirectory();
  }

  public function createDirectory( string $name = null ): bool
  {

    $path = $this->toPath( $name );

    if( $this->directoryExists( $path ) ){
      return true;
    }

    if ( mkdir( $path, $this->mode, true) ) {
      return true;
    } else {
      throw new Exception('Could not create '.$path);
      return false;
    }

  }

}
