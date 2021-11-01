<?php

namespace Tests\TestCases\Support;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Rules\Calendar\Support\Formatter;
use Tests\TestCases\TestCase;

class FormatterTest extends TestCase
{
    public function testFormatIntervalSingular()
    {
        $a = Carbon::create('2021-01-01');
        $b = $a->copy()
            ->addYear()
            ->addMonth()
            ->addDay()
            ->addHour()
            ->addMinute();

        $interval = $a->diff($b);

        $format = Formatter::formatInterval($interval);

        $this->assertEquals(
            '1 year, 1 month, 1 day, 1 hour, and 1 minute',
            $format
        );
    }

    public function testFormatIntervalPlural()
    {
        $a = Carbon::create('2021-01-01');
        $b = $a->copy()
            ->addYears(2)
            ->addMonths(2)
            ->addDays(2)
            ->addHours(2)
            ->addMinutes(2);

        $interval = $a->diff($b);

        $format = Formatter::formatInterval($interval);

        $this->assertEquals(
            '2 years, 2 months, 2 days, 2 hours, and 2 minutes',
            $format
        );
    }

    public function testFormatIntervalOnlyOnePart()
    {
        $a = Carbon::create('2021-01-01');
        $b = $a->copy()
            ->addMinutes(5);

        $interval = $a->diff($b);

        $format = Formatter::formatInterval($interval);

        $this->assertEquals(
            '5 minutes',
            $format
        );
    }
}
