<?php

namespace Tests\TestCases\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Tests\Models\Rules\TestRuleMaxAttendees;
use Tests\Models\Verifiables\TestVerifiableEvent;
use Tests\Models\Verifiables\TestVerifiableEventAttendee;
use Tests\TestCases\TestCase;

class TRuleMaxAttendeesTest extends TestCase
{
    public function testLessThanMaxAttendeesPasses()
    {
        $rule = new TestRuleMaxAttendees(3);

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 08:15:00'),
            [
                new TestVerifiableEventAttendee,
                new TestVerifiableEventAttendee
            ]
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testUpToMaxAttendeesPasses()
    {
        $rule = new TestRuleMaxAttendees(3);

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 09:00:00'),
            [
                new TestVerifiableEventAttendee,
                new TestVerifiableEventAttendee,
                new TestVerifiableEventAttendee,
            ]
        );
        $this->assertTrue($rule->verify($event));
    }

    public function testGreaterThanMaxAttendeesFails()
    {
        $rule = new TestRuleMaxAttendees(3);

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 09:01:00'),
            [
                new TestVerifiableEventAttendee,
                new TestVerifiableEventAttendee,
                new TestVerifiableEventAttendee,
                new TestVerifiableEventAttendee
            ]
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage(
            'This event cannot have more than '
        );

        $rule->verify($event);
    }
}
