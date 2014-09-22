<?php
class CronController
{
  private static $php = '/opt/lampp/bin/php';

  private static $script = '/opt/lampp/htdocs/scripts/newGeneration.php';

  private static $tempFile = '/tmp/crontab.txt';

  public static function getJobs()
  {
    return shell_exec('crontab -l');
  }

  public static function addJob()
  {
    file_put_contents(self::$tempFile, self::getJobs() . '* * * * * ' . self::$php . ' ' . self::$script . PHP_EOL);
    exec('crontab ' . self::$tempFile);
  }

  public static function removeAllJobs()
  {
    exec('crontab -r');
  }

  public static function removeJob($job)
  {
    $allJobs = self::getJobs();
    if (strstr($allJobs, $job))
    {
      $newJobs = str_replace($job, '', $allJobs);
      file_put_contents(self::$tempFile, $newJobs . PHP_EOL);
      exec('crontab ' . self::$tempFile);
    }
  }
}
?>
