<?php

namespace Tests\Infrastructure\PHPUnit;

use PHPUnit_Framework_TestFailure;

class ResultPrinter extends \NyanCat\PHPUnit\ResultPrinter
{
    /**
     * ResultPrinter constructor.
     * @param null $out
     * @param bool $verbose
     * @param bool $colors
     * @param bool $debug
     */
    public function __construct($out, $verbose, $colors, $debug)
    {
        $debug = false; # Force set debug, set to true for normal phpunit output
        parent::__construct($out, $verbose, $colors, $debug);
    }

    /**
     * @param PHPUnit_Framework_TestFailure $defect
     * @param int $count
     */
    protected function printDefect(PHPUnit_Framework_TestFailure $defect, $count)
    {
        $this->printDefectHeader($defect, $count);
        $this->printDefectTrace($defect);
    }

    /**
     * @param PHPUnit_Framework_TestFailure $defect
     * @param int                           $count
     */
    protected function printDefectHeader(PHPUnit_Framework_TestFailure $defect, $count)
    {
        $this->write(
            sprintf(
                "\n%d) %s\n",
                $count,
                "\033[0;33m" . $defect->getTestName() . "\033[0m"
            )
        );
    }

    /**
     * @param PHPUnit_Framework_TestFailure $defect
     */
    protected function printDefectTrace(PHPUnit_Framework_TestFailure $defect)
    {
        $e = $defect->thrownException();
        $this->writeNewLine();
        $this->write($e);
        $this->writeNewLine();

        while ($e = $e->getPrevious()) {
            $this->write("\n\033[0;37mCaused by\033[0m\n"
                . "\033[1;31m" . $e->getMessage() . "\033[0m"
                . "\033[2;31m\n" . $e->getFile() .  " ({$e->getLine()})" . "\033[0m"
            );
            $this->writeNewLine();
        }
    }
}
