<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

/**
 * sampleテストケース
 */
class SampleTest extends TestCase
{

  protected $baseUrl = 'https://www.google.com/';
  protected $outPut;
  public function setUp()
    {
      date_default_timezone_set('Asia/Tokyo');

      $this->arrayUrl = [
          "/@38.4769663,136.9553721,5z",
          "/@48.8245804,6.9380568,5z",
          "/@40.6690567,-98.5637508,5z"
      ];

      $this->outPut = __DIR__ . DIRECTORY_SEPARATOR. 'result' . DIRECTORY_SEPARATOR;
      if (!file_exists($this->outPut)) {
        mkdir($this->outPut);
      }
    }

  public function testFirefoxUI()
  {
    // 事前に「Selenium Standalone Server」を起動しておく
    $host = 'http://localhost:4444/wd/hub';

    // chromedriverを指定する場合（chromedriverをダウンロードして/user/local/bin等に入れておく。)
    // $driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());

    $driver = RemoteWebDriver::create($host, DesiredCapabilities::firefox());

    // ウィンドウサイズを最大限にする
    $driver->manage()->window()->maximize();


    foreach ($this->arrayUrl as $url) {
        // サイト移動
        $driver->get($this->baseUrl . $url);

        $filename = $driver->getTitle();

        // スクリーンショット取得
        $driver->takeScreenshot($this->outPut . $filename . '.png');
    }

    //閉じる
    $driver->quit();
  }
}
