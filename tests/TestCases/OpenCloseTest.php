<?php

namespace Tests\TestCases;

use PHPUnit\Framework\TestCase;
use Tests\Models\TestRuleOpenClose;
use Tests\Models\TestVerifiableOpenClose;

class OpenCloseTest extends TestCase
{
    public function testRulePasses() {
        $appointment = new TestVerifiableOpenClose;
        $rule = new TestRuleOpenClose();

        $this->assertTrue($rule->verify($appointment));
    }
}