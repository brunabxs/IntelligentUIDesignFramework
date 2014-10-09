<?php
class CronController
{
  private static $php = 'php';

  private static $script = '/opt/lampp/htdocs/newGeneration.php';

  private static $tempFile = '/tmp/crontab.txt';

  public static function getJobs()
  {
    return shell_exec('crontab -l');
  }

  public static function addJob($code)
  {
    file_put_contents(self::$tempFile, self::getJobs() . createJob($code));
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
    return '* * * * * ' . self::$php . ' ' . self::$script . '?code=' . $code . PHP_EOL;
  }
}
?>
