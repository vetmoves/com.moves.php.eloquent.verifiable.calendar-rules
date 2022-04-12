<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Support;

use DateInterval;
use Illuminate\Support\Str;

class Formatter
{
    public static function formatInterval(DateInterval $interval): string
    {
        $parts = [];

        if ($interval->y) { $parts[] = $interval->y . Str::plural(' year', $interval->y); }
        if ($interval->m) { $parts[] = $interval->m . Str::plural(' month', $interval->m); }
        if ($interval->d) { $parts[] = $interval->y . Str::plural(' day', $interval->d); }
        if ($interval->h) { $parts[] = $interval->h . Str::plural(' hour', $interval->h); }
        if ($interval->i) { $parts[] = $interval->i . Str::plural(' minute', $interval->i); }

        $result = '';

        if (count($parts) == 0) {
            $result = '0 minutes';
        } else if (count($parts) == 1) {
            $result = $parts[0];
        } else {
            foreach ($parts as $i => $part) {
                if ($i == count($parts) - 1) {
                    $result .= 'and ' . $part;
                } else {
                    $result .= $part . ', ';
                }
            }
        }

        $result = $interval->format('%r') . $result;

        return $result;
    }
}
