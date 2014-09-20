﻿<?php
abstract class MyUnit_Framework_TestCase extends PHPUnit_Framework_TestCase
{
  protected static $tempDir = null;
  protected static $datasetDir = null;

  protected function setUp()
  {
    self::$tempDir = './tests/' . get_class($this) . '.' . $this->getName() . '/';
    self::$datasetDir = './tests/' . get_class($this) . '.' . $this->getName() . '/dataset/';

    if (!is_dir(self::$tempDir))
    {
      mkdir(self::$tempDir);
    }
  }

  protected function tearDown()
  {
    self::deleteAllFiles(self::$tempDir);
    if (!is_dir(self::$datasetDir))
    {
      rmdir(self::$tempDir);
    }
  }

  protected function mockGeneticAlgorithm()
  {
    $ga = $this->getMockBuilder('GeneticAlgorithm')
               ->disableOriginalConstructor()
               ->setMethods(NULL)
               ->getMock();
    return $ga;
  }

  protected static function containsFile($dir, $fileName)
  {
    if ($handle = opendir($dir))
    {
      while (($file = readdir($handle)) !== false)
      {
        if (!in_array($file, array('.', '..')) && !is_dir($dir . $file))
        {
          if ($file == $fileName)
          {
            return true;
          }
        }
      }
    }
    return false;
  }

  protected static function countFiles($dir)
  {
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
