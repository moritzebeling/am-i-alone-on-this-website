<?php

class Folder {

  // string
  protected $base = '';         /* /base */
  protected $path = '';         /* pa/th */
  protected $name = '';         /* name */
  protected $basePath = '';     /* /base/pa/th */
  protected $pathName = '';     /* pa/th/name */
  protected $basePathName = ''; /* /base/pa/th/name */

  public function __construct( string $pathname )
  {
    $parts = explode( '/', $pathname );

    $this->base = $_SERVER['DOCUMENT_ROOT'];
    $this->name = array_pop( $parts );
    $this->path = $this->toPath( $parts );

    $this->basePath = $this->toPath([
      $this->base, $this->path
    ]);
    $this->pathName = $this->toPath([
      $this->path, $this->name
    ]);
    $this->basePathName = $this->toPath([
      $this->base, $this->path, $this->name
    ]);

    $this->create( $this->basePathName );
  }

  public function toPath( array $parts = [] ): string {
    $parts = array_filter( $parts );
    return implode('/', $parts );
  }

  public function create( string $path ): bool
  {
    if( is_dir( $path ) ){
      return true;
    }
    if ( mkdir( $path, 0777, true) ) {
      return true;
    } else {
      throw new Exception('Could not create ' . $path);
      return false;
    }
  }

  public function createFolder( string $name ): Folder
  {
    return new Folder( $this->toPath([ $this->pathName, $name ]) );
  }

}
