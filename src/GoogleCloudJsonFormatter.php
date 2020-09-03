<?php

namespace Superbalist\Monolog\Formatter;

use Monolog\Formatter\JsonFormatter;

class GoogleCloudJsonFormatter extends JsonFormatter
{
    /**
     * {@inheritdoc}
     */
    public function format(array $record): string
    {
        return json_encode(
            $this->translateRecordForGoogleCloudLoggingFormat($record)
        ) . ($this->appendNewline ? "\n" : '');
    }

    /**
     * Return a JSON-encoded array of records.
     *
     * @param array $records
     *
     * @return string
     */
    protected function formatBatchJson(array $records): string
    {
        $records = array_map(
            function ($record) {
                return $this->translateRecordForGoogleCloudLoggingFormat($record);
            },
            $records
        );
        return json_encode($records);
    }

    /**
     * @param array $record
     *
     * @return array
     */
    protected function translateRecordForGoogleCloudLoggingFormat(array $record)
    {
        // translate the data into a format which google's out_google_cloud.rb plugin can understand
        // see https://github.com/GoogleCloudPlatform/fluent-plugin-google-cloud/blob/master/lib/fluent/plugin/out_google_cloud.rb

        $dt = $record['datetime'];
        /** @var \DateTime $dt */
        $formatted = [
            'message' => $record['message'],
            'severity' => $record['level_name'],
            'timestamp' => [
                'seconds' => $dt->getTimestamp(),
                'nanos' => 0,
            ],
            'channel' => $record['channel'],
        ];

        // merge in anything else from context and extra as structured metadata
        $formatted = array_merge($record['context'], $record['extra'], $formatted);

        return $formatted;
    }
}
