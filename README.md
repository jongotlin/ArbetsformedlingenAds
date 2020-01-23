# ArbetsformedlingenAds
Api wrapper for publishing ads on Arbetsförmedlingen (Swedish public employment service)


## Install with composer
`composer require jongotlin/arbetsformedlingen-ads`

## Example
```php
$client = new \JGI\ArbetsformedlingenAds\Client();
$client->setHttpClient($httpClient); // $httpClient is a \Http\Client\HttpClient

$arbetsformedlingenJob = new ArbetsformedlingenJob(...);
$transaction = new Transaction($senderId, 'some@email.com', $transactionID, [$arbetsformedlingenJob]);

$result = $client->publish($transaction); 

```
