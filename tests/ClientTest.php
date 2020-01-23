<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds\Tests;

use JGI\ArbetsformedlingenAds\Client;
use JGI\ArbetsformedlingenAds\HRXMLDocumentCreator;
use JGI\ArbetsformedlingenAds\Model\ArbetsformedlingenJob;
use JGI\ArbetsformedlingenAds\Model\Result;
use JGI\ArbetsformedlingenAds\Model\Transaction;
use PHPUnit\Framework\TestCase;
use Http\Client\HttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function it_publish_a_job()
    {
        $client = new Client();
        $client->setHttpClient($this->getHttpClient('{"Message":"Inskickade platsannonser har hanterats."}'));
        $client->setHrxmlDocumentCreator($this->createMock(HRXMLDocumentCreator::class));
        $result = $client->publish(
            $this->createMock(Transaction::class),
        );

        $this->assertInstanceOf(Result::class, $result);
        $this->assertTrue($result->isSuccess());
    }

    /**
     * @test
     */
    public function it_returns_an_error()
    {
        $client = new Client();
        $client->setHttpClient($this->getHttpClient('[{"Message":"Ett ogiltigt kundnummer har angivits.","ErrorCode":1005}]'));
        $client->setHrxmlDocumentCreator($this->createMock(HRXMLDocumentCreator::class));
        $result = $client->publish(
            $this->createMock(Transaction::class),
        );

        $this->assertInstanceOf(Result::class, $result);
        $this->assertFalse($result->isSuccess());
        $this->assertCount(1, $result->getErrors());
        $this->assertEquals('Ett ogiltigt kundnummer har angivits.', $result->getErrors()[0]->getMessage());
        $this->assertEquals('1005', $result->getErrors()[0]->getErrorCode());
    }

    /**
     * @param string|null $json
     *
     * @return \PHPUnit\Framework\MockObject\MockObject|HttpClient
     */
    private function getHttpClient(?string $json)
    {
        $httpClientMock = $this->getMockBuilder(HttpClient::class)->getMock();
        $responseMock = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $streamMock = $this->getMockBuilder(StreamInterface::class)->getMock();
        $streamMock->method('getContents')->willReturn($json);
        $responseMock->method('getBody')->willReturn($streamMock);
        $httpClientMock->method('sendRequest')->willReturn($responseMock);

        return $httpClientMock;
    }
}
