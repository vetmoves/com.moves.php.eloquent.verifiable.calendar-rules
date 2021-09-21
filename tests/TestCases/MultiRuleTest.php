<?php

namespace Tests\TestCases;

use Moves\Eloquent\Verifiable\Contracts\IRule;
use PHPUnit\Framework\TestCase;
use Tests\Models\Rules\TestRuleMaxDuration;
use Tests\Models\Rules\TestRuleOpenClose;
use Tests\Models\Verifiables\TestVerifiableAllRules;

class MultiRuleTest extends TestCase
{
    public function testAllRules() {
        /** @var IRule[] $rules */
        $rules = [
            new TestRuleOpenClose,
            new TestRuleMaxDuration,
        ];

        $appointment = new TestVerifiableAllRules;

        $this->expectException(\Exception::class);

        foreach ($rules as $rule) {
            $rule->verify($appointment);
        }

        $appointment->verify();
    }
}