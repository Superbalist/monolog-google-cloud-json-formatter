<?php

use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Superbalist\Monolog\Formatter\GoogleCloudJsonFormatter;

class GoogleCloudJsonFormatterTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_format_records_into_json()
    {
        $googleCloudJsonFormatter = new GoogleCloudJsonFormatter();
        $record = $this->getRecord();

        $expectedFormat = $this->getFormattedRecord($record);

        $this->assertEquals(
            json_encode($expectedFormat) . "\n",
            $googleCloudJsonFormatter->format($record)
        );
    }

    /**
     * @test
     */
    public function it_should_format_records_into_json_with_added_context()
    {
        $googleCloudJsonFormatter = new GoogleCloudJsonFormatter();
        $record = $this->getRecord(
            Logger::WARNING,
            'test',
            ['context' => 'some_data'],
            ['extra' => true]
        );

        $expectedFormat = $this->getFormattedRecord($record);

        $this->assertEquals(
            json_encode($expectedFormat) . "\n",
            $googleCloudJsonFormatter->format($record)
        );
    }

    /**
     * @param int $level
     * @param string $message
     * @param array $context
     * @param array $extra
     *
     * @return array
     */
    protected function getRecord($level = Logger::WARNING, $message = 'test', $context = [], $extra = [])
    {
        return [
            'message' => $message,
            'context' => $context,
            'level' => $level,
            'level_name' => Logger::getLevelName($level),
            'channel' => 'test',
            'datetime' => \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true))),
            'extra' => $extra,
        ];
    }

    /**
     * @param array $record
     *
     * @return array
     */
    protected function getFormattedRecord(array $record)
    {
        return array_merge($record['context'], $record['extra'], [
            'message' => 'test',
            'severity' => Logger::getLevelName(Logger::WARNING),
            'timestamp' => [
                'seconds' => $record['datetime']->getTimestamp(),
                'nanos' => 0,
            ],
            'channel' => 'test',
        ]);
    }
}
