<?php

class File {

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
    $this->path = toPath( $parts );

    $this->basePath = toPath([
      $this->base, $this->path
    ]);
    $this->pathName = toPath([
      $this->path, $this->name
    ]);
    $this->basePathName = toPath([
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
    if( is_file( $path ) ){
      return true;
    }
    if ( touch( $path ) ) {
      return true;
    } else {
      throw new Exception('Could not create ' . $path);
      return false;
    }
  }

}
