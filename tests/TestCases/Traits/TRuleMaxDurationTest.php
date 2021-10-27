<?php

namespace Tests\TestCases\Traits;

use Tests\Models\Rules\TestRuleMaxDuration;
use Tests\Models\Verifiables\TestVerifiableMaxDuration;
use Tests\TestCases\TestCase;

class TRuleMaxDurationTest extends TestCase
{
    public function testLessThanMaxDurationPasses()
    {
        $rule = new TestRuleMaxDuration(60);

        $event = new TestVerifiableMaxDuration(15);

        $this->assertTrue($rule->verify($event));
    }

    public function testUpToMaxDurationPasses()
    {
        $rule = new TestRuleMaxDuration(60);

        $event = new TestVerifiableMaxDuration(60);

        $this->assertTrue($rule->verify($event));
    }

    public function testNegativeDurationFails()
    {
        $rule = new TestRuleMaxDuration(60);

        $event = new TestVerifiableMaxDuration(-15);

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testGreaterThanMaxDurationFails()
    {
        $rule = new TestRuleMaxDuration(60);

        $event = new TestVerifiableMaxDuration(61);

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }
}
