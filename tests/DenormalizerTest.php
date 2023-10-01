<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds\Tests;

use JGI\ArbetsformedlingenAds\Denormalizer;
use PHPUnit\Framework\TestCase;

class DenormalizerTest extends TestCase
{
    /**
     * @test
     */
    public function it_denormalizes_a_successful_response()
    {
        $json = '{"Message":"Inskickade platsannonser har hanterats."}';

        $result = (new Denormalizer())->denormalizeResult(json_decode($json, true));

        $this->assertTrue($result->isSuccess());
        $this->assertCount(0, $result->getErrors());
    }

    /**
     * @test
     */
    public function it_denormalizes_a_response_with_one_message()
    {
        $json = '[{"Message":"Ett ogiltigt kundnummer har angivits.","ErrorCode":1005}]';

        $result = (new Denormalizer())->denormalizeResult(json_decode($json, true));

        $this->assertFalse($result->isSuccess());
        $this->assertCount(1, $result->getErrors());
        $this->assertEquals('Ett ogiltigt kundnummer har angivits.', $result->getErrors()[0]->getMessage());
        $this->assertEquals('1005', $result->getErrors()[0]->getErrorCode());
    }

    /**
     * @test
     */
    public function it_denormalizes_a_unauthorized_response()
    {
        $json = '{"Message":"Unauthorized"}';

        $result = (new Denormalizer())->denormalizeResult(json_decode($json, true));

        $this->assertFalse($result->isSuccess());
        $this->assertCount(1, $result->getErrors());
        $this->assertEquals('Unauthorized', $result->getErrors()[0]->getMessage());
        $this->assertNull($result->getErrors()[0]->getErrorCode());
    }
}
