<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds;

use JGI\ArbetsformedlingenAds\Event\ResultEvent;
use JGI\ArbetsformedlingenAds\Model\ArbetsformedlingenJob;
use JGI\ArbetsformedlingenAds\Model\Result;
use JGI\ArbetsformedlingenAds\Model\Transaction;
use Http\Client\HttpClient;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Client
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var RequestFactory
     */
    protected $messageFactory;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var Denormalizer
     */
    protected $denormalizer;

    /**
     * @var EventDispatcherInterface|null
     */
    protected $eventDispatcher;

    /**
     * @var HRXMLDocumentCreator|null
     */
    protected $hrxmlDocumentCreator;

    /**
     * @var bool
     */
    protected $testEnvironment = false;

    /**
     * @var array
     */
    private static $defaultOptions = [
        'url' => 'https://api.arbetsformedlingen.se/ledigtarbete/',
    ];

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }

    /**
     * @param HttpClient $httpClient
     */
    public function setHttpClient(HttpClient $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param bool $testEnvironment
     */
    public function setTestEnvironment(bool $testEnvironment): void
    {
        $this->testEnvironment = $testEnvironment;
    }

    /**
     * @param null|EventDispatcherInterface $eventDispatcher
     */
    public function setEventDispatcher(?EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return HRXMLDocumentCreator|null
     */
    public function getHrxmlDocumentCreator(): HRXMLDocumentCreator
    {
        if (!$this->hrxmlDocumentCreator) {
            $this->hrxmlDocumentCreator = new HRXMLDocumentCreator();
        }

        return $this->hrxmlDocumentCreator;
    }

    /**
     * @param HRXMLDocumentCreator $hrxmlDocumentCreator
     */
    public function setHrxmlDocumentCreator(HRXMLDocumentCreator $hrxmlDocumentCreator): void
    {
        $this->hrxmlDocumentCreator = $hrxmlDocumentCreator;
    }

    /**
     * @param array $options
     */
    private function setOptions(array $options)
    {
        $this->options = self::$defaultOptions;
        $this->options = array_merge($this->options, $options);
    }

    /**
     * @return RequestFactory
     */
    private function getMessageFactory()
    {
        if (!$this->messageFactory) {
            $this->messageFactory = MessageFactoryDiscovery::find();
        }

        return $this->messageFactory;
    }

    /**
     * @return Denormalizer
     */
    private function getDenormalizer()
    {
        if (!$this->denormalizer) {
            $this->denormalizer = new Denormalizer();
        }

        return $this->denormalizer;
    }

    /**
     * @param string $method
     * @param string $package
     * @param array $parameters
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     * @throws \Http\Client\Exception
     */
    private function request(string $path, string $method = 'GET', array $parameters = [], $body)
    {
        $request = call_user_func_array(
            [$this, 'buildRequestInstance'],
            [$path, $method, $parameters, $body]
        );

        return $this->httpClient->sendRequest($request);
    }

    public function buildRequestInstance(string $path, string $method = 'GET', array $parameters = [], ?string $body = null): RequestInterface
    {
        $uri = $this->options['url'] . $path . '?' . http_build_query($parameters);

        return $this->getMessageFactory()->createRequest($method, $uri, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ], $body);
    }

    /**
     * @param Transaction $transaction
     * @param ArbetsformedlingenJob[] $arbetsformedlingenJobs
     *
     * @return Result
     *
     * @throws \Http\Client\Exception
     */
    public function publish(Transaction $transaction)
    {
        $hrxml = $this->getHrxmlDocumentCreator()->createFromTransaction($transaction);

        $url = 'apiledigtarbete/hrxml';
        if ($this->testEnvironment === true) {
            $url = 'apiledigtarbete/test/hrxml';
        }

        $json = $this->request($url, 'POST', [], $hrxml->saveXML())->getBody()->getContents();

        $result = $this->getDenormalizer()->denormalizeResult(json_decode($json, true));

        if ($this->eventDispatcher) {
            $this->eventDispatcher->dispatch(
                ResultEvent::NAME, new ResultEvent($transaction, $result, $hrxml, $json)
            );
        }

        return $result;
    }
}
