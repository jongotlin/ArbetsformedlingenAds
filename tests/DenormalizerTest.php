<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds\Tests;

use JGI\ArbetsformedlingenAds\Client;
use JGI\ArbetsformedlingenAds\Denormalizer;
use JGI\ArbetsformedlingenAds\HRXMLDocumentCreator;
use JGI\ArbetsformedlingenAds\Model\ArbetsformedlingenJob;
use JGI\ArbetsformedlingenAds\Model\Result;
use JGI\ArbetsformedlingenAds\Model\Transaction;
use PHPUnit\Framework\TestCase;
use Http\Client\HttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

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
}
