<?php

namespace Tests\TestCases\Traits;

use Carbon\Carbon;
use Tests\Models\Rules\TestRuleAdvance;
use Tests\Models\Verifiables\TestVerifiableEvent;
use Tests\TestCases\TestCase;

class TRuleAdvanceTest extends TestCase
{
    public function testLessThanMaxAdvancePasses()
    {
        $rule = new TestRuleAdvance(-60);

        $event = new TestVerifiableEvent(
            Carbon::now(),
            Carbon::now()->addHour()
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testUpToMaxAdvancePasses()
    {
        $rule = new TestRuleAdvance(-60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addMinutes(60),
            Carbon::now()->addMinutes(120)
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testJustPastMaxAdvanceFails()
    {

        $rule = new TestRuleAdvance(-60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addMinutes(60)->addSeconds(1),
            Carbon::now()->addMinutes(120)
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testGreaterThanMaxFails()
    {
        $rule = new TestRuleAdvance(-60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addMinutes(120),
            Carbon::now()->addMinutes(180)
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testGreaterThanMinAdvancePasses()
    {
        $rule = new TestRuleAdvance(60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addHours(2),
            Carbon::now()->addHours(3)
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testUpToMinAdvancePasses()
    {
        $rule = new TestRuleAdvance(60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addHour()->addSecond(),
            Carbon::now()->addHours(2)
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testJustLessThanMinAdvanceFails()
    {
        $rule = new TestRuleAdvance(60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addHour()->subSecond(),
            Carbon::now()->addHours(2)
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testLessThanMinAdvanceFails()
    {
        $rule = new TestRuleAdvance(60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addMinutes(30),
            Carbon::now()->addMinutes(90)
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }
}
