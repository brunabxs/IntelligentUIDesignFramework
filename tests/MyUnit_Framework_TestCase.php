<?php
abstract class MyUnit_Framework_TestCase extends PHPUnit_Framework_TestCase
{
  protected static $dir = './tests/temp/';
  
  protected function tearDown()
  {
    self::deleteAllFiles(self::$dir);
  }
  
  protected static function countFiles()
  {
    $dir = self::$dir;
    $numFiles = 0;
    if ($handle = opendir($dir))
    {
      while (($file = readdir($handle)) !== false)
      {
        if (!in_array($file, array('.', '..')) && !is_dir($dir . $file))
        {
          $numFiles++;
        }
      }
    }
    return $numFiles;
  }
  
  private function deleteAllFiles($dir)
  {
    $files = glob($dir . '*');
    foreach ($files as $file)
    {
      if (is_file($file))
      {
        unlink($file);
      }
    }
  }
}
?>