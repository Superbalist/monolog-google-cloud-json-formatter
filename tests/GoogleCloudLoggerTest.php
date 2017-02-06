<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Superbalist\Monolog\Formatter\GoogleCloudJsonFormatter;

class GoogleCloudLoggerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Logger
     */
    private $log;
    private static $logfileOutput = 'tests/log/test.log';

    /**
     * Setup before test runs
     */
    public static function setUpBeforeClass()
    {
        touch(static::$logfileOutput);
    }

    /**
     * Test setup
     */
    public function setUp()
    {
        $handler = new StreamHandler(static::$logfileOutput, Logger::DEBUG);
        $handler->setFormatter(new GoogleCloudJsonFormatter());
        $this->log = new Logger('test-channel');
        $this->log->pushHandler($handler);
    }

    /**
     * Cleanup
     */
    public function tearDown()
    {
        file_put_contents(static::$logfileOutput, '');
        unset($this->log);
    }

    /**
     * Cleanup after all tests ran
     */
    public static function tearDownAfterClass()
    {
        unlink(static::$logfileOutput);
    }

    /**
     * @test
     */
    public function it_should_log_a_debug_in_the_expected_format()
    {
        $dt = $this->getDateTimeforTest();

        $this->log->addDebug('Test Debug Occurred');

        $expected = '{"message":"Test Debug Occurred","severity":"DEBUG","timestamp":{"seconds":'
            . $dt->getTimestamp() . ',"nanos":0},"channel":"test-channel"}' . "\n";

        $this->assertLogfileContents($expected);
    }

    /**
     * @test
     */
    public function it_should_log_an_info_in_the_expected_format()
    {
        $dt = $this->getDateTimeforTest();

        $this->log->addInfo('Test Info Occurred');

        $expected = '{"message":"Test Info Occurred","severity":"INFO","timestamp":{"seconds":'
            . $dt->getTimestamp() . ',"nanos":0},"channel":"test-channel"}' . "\n";

        $this->assertLogfileContents($expected);
    }

    /**
     * @test
     */
    public function it_should_log_a_notice_in_the_expected_format()
    {
        $dt = $this->getDateTimeforTest();

        $this->log->addNotice('Test Notice Occurred');

        $expected = '{"message":"Test Notice Occurred","severity":"NOTICE","timestamp":{"seconds":'
            . $dt->getTimestamp() . ',"nanos":0},"channel":"test-channel"}' . "\n";

        $this->assertLogfileContents($expected);
    }

    /**
     * @test
     */
    public function it_should_log_a_warning_in_the_expected_format()
    {
        $dt = $this->getDateTimeforTest();

        $this->log->addWarning('Test Warning Occurred');

        $expected = '{"message":"Test Warning Occurred","severity":"WARNING","timestamp":{"seconds":'
            . $dt->getTimestamp() . ',"nanos":0},"channel":"test-channel"}' . "\n";

        $this->assertLogfileContents($expected);
    }

    /**
     * @test
     */
    public function it_should_log_an_error_in_the_expected_format()
    {
        $dt = $this->getDateTimeforTest();

        $this->log->addError('Test Error Occurred');

        $expected = '{"message":"Test Error Occurred","severity":"ERROR","timestamp":{"seconds":' . $dt->getTimestamp()
            . ',"nanos":0},"channel":"test-channel"}' . "\n";

        $this->assertLogfileContents($expected);
    }

    /**
     * @test
     */
    public function it_should_log_a_critical_in_the_expected_format()
    {
        $dt = $this->getDateTimeforTest();

        $this->log->addCritical('Test Critical Occurred');

        $expected = '{"message":"Test Critical Occurred","severity":"CRITICAL","timestamp":{"seconds":'
            . $dt->getTimestamp() . ',"nanos":0},"channel":"test-channel"}' . "\n";

        $this->assertLogfileContents($expected);
    }

    /**
     * @test
     */
    public function it_should_log_an_alert_in_the_expected_format()
    {
        $dt = $this->getDateTimeforTest();

        $this->log->addAlert('Test Alert Occurred');

        $expected = '{"message":"Test Alert Occurred","severity":"ALERT","timestamp":{"seconds":'
            . $dt->getTimestamp() . ',"nanos":0},"channel":"test-channel"}' . "\n";

        $this->assertLogfileContents($expected);
    }

    /**
     * @test
     */
    public function it_should_log_an_emergency_in_the_expected_format()
    {
        $dt = $this->getDateTimeforTest();

        $this->log->addEmergency('Test Emergency Occurred');

        $expected = '{"message":"Test Emergency Occurred","severity":"EMERGENCY","timestamp":{"seconds":'
            . $dt->getTimestamp() . ',"nanos":0},"channel":"test-channel"}' . "\n";

        $this->assertLogfileContents($expected);
    }

    /**
     * @param $expected
     */
    protected function assertLogfileContents($expected)
    {
        $this->assertEquals($expected, file_get_contents(static::$logfileOutput));
    }

    /**
     * @return DateTime
     */
    protected function getDateTimeforTest()
    {
        $dt = \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true)));
        return $dt;
    }
}
