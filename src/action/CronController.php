<?php
class CronController
{
  private static $command = 'wget';

  private static $page = 'localhost/newGeneration.php?code=';

  private static $tempFile = '/tmp/crontab.txt';

  public static function getJobs()
  {
    return shell_exec('crontab -l');
  }

  public static function addJob($code)
  {
    file_put_contents(self::$tempFile, self::getJobs() . self::createJob($code));
    exec('crontab ' . self::$tempFile);
  }

  public static function removeAllJobs()
  {
    exec('crontab -r');
  }

  public static function removeJob($code)
  {
    $job = createJob($code);
    $allJobs = self::getJobs();
    if (strstr($allJobs, $job))
    {
      $newJobs = str_replace($job, '', $allJobs);
      file_put_contents(self::$tempFile, $newJobs . PHP_EOL);
      exec('crontab ' . self::$tempFile);
    }
  }

  private static function createJob($code)
  {
    return '* * * * * ' . self::$command . ' ' . self::$page . $code . PHP_EOL;
  }
}
?>
