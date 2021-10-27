<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableMaxDuration;

trait TRule
{
    /**
     * @param array 
     * @return bool
     */
    public function overlaps(DateTimeInterface[] $t1, DateTimeInterface[] $t2): bool
    {
        if ($t2['start_time'] < $t2['start_time']  ) {
            
        }

        return false;
    }
}
