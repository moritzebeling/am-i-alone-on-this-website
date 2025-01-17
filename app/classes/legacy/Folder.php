<?php

class Folder {

  // string
  protected $base = '';         /* /base */
  protected $path = '';         /* pa/th */
  protected $name = '';         /* name */
  protected $basePath = '';     /* /base/pa/th */
  protected $pathName = '';     /* pa/th/name */
  protected $basePathName = ''; /* /base/pa/th/name */

  // array
  protected $folders = [];
  protected $files = [];
  protected $index = [];
  protected $contents = [];

  public function __construct( string $pathname )
  {
    $parts = explode( '/', $pathname );

    $this->base = ROOT;
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

  public function folder( string $name ): Folder
  {
    return new Folder( toPath([ $this->pathName, $name ]) );
  }

  public function file( string $name ): File
  {
    return new File( toPath([ $this->pathName, $name ]) );
  }

  public function folders(): array
  {
    if( empty( $this->folders ) ){
      $this->scan();
    }
    return $this->folders;
  }

  public function files(): array
  {
    if( empty( $this->files ) ){
      $this->scan();
    }
    return $this->files;
  }

  public function scan()
  {
    $items = scandir( $this->basePathName );

    $folders = [];
    $files = [];

    foreach( $items as $item ){
      if( substr($item, 0, 1) === '.' ){
        continue;
      }
      $path = toPath([ $this->basePathName, $item ]);
      if( is_dir( $path ) ){
        $folders[] = $item;
      } else if( is_file( $path ) ){
        $files[] = $item;
      }
    }

    $this->folders = $folders;
    $this->files = $files;
  }

  public function index(): array
  {
    $index = [];
    foreach( $this->folders() as $f ){
      $folder = new Folder( $this->pathName .'/'. $f );
      $index[ $f ] = $folder->files();
    }
    $this->index = $index;
    return $this->index;
  }

  public function contents(): array
  {
    $contents = [];
    foreach( $this->folders() as $fo ){
      $folder = new Folder( $this->pathName .'/'. $fo );
      foreach ($folder->files() as $fi) {
        if( !in_array( $fi, $contents ) ){
          $contents[] = $fi;
        }
      }
    }
    $this->contents = $contents;
    return $this->contents;
  }

  public function remove( string $dirname = null ): bool
  {
    if( $dirname === null ){
      $dirname = $this->basePathName;
    } else {
      
    }

    if( !is_dir( $dirname ) ){
      echo 'Cannot delete '.$dirname.' ';
      return false;
    }

    $dir_handle = opendir( $dirname );
    while( $file = readdir( $dir_handle ) ) {
      if( $file != "." && $file != ".." ) {
        if( !is_dir( $dirname."/".$file ) ){
          unlink( $dirname."/".$file );
        } else {
          remove_directory( $dirname.'/'.$file );
        }
      }
    }
    closedir( $dir_handle );
    rmdir( $dirname );
    return true;
  }

}
