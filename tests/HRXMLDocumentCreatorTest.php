<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds\Tests;

use JGI\ArbetsformedlingenAds\Client;
use JGI\ArbetsformedlingenAds\HRXMLDocument;
use JGI\ArbetsformedlingenAds\HRXMLDocumentCreator;
use JGI\ArbetsformedlingenAds\Model\ArbetsformedlingenJob;
use JGI\ArbetsformedlingenAds\Model\Contact;
use JGI\ArbetsformedlingenAds\Model\Qualification;
use JGI\ArbetsformedlingenAds\Model\Transaction;
use PHPUnit\Framework\TestCase;

class HRXMLDocumentCreatorTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_a_document_from_models()
    {
        $HRXMLDocumentCreator = new HRXMLDocumentCreator();

        $contact = new Contact('Jon', 'Gotlin');
        $contact->setEmail('jon@jon.se');
        $contact->setPhoneNumber('123');
        $contact->setTitle('Facklig företrädare');
        $contact->setUnionRepresentative(true);

        $qualification = new Qualification(Qualification::TYPE_LICENSE, 'B', Qualification::EXPERIENCE_REQUIRED);

        $arbetsformedlingenJob = new ArbetsformedlingenJob(
            true,
            '123',
            'Bemanna AB',
            '555555-5555',
            new \DateTime('2020-01-21'),
            'jon@jon.se',
            'Junior assistant vice president',
            'Work work work',
            'Street 1',
            '71930',
            'Vintrosa',
            'SE',
            '1880',
            false,
            'Halvtid 50%',
            false,
            ArbetsformedlingenJob::TERM_LENGTH_TEMPORARY_EMPLOYMENT_MAX_10_DAYS,
            '1 dagskneg',
            ArbetsformedlingenJob::SALARY_TYPE_FIXED,
            'Daglön',
            'http://example.com',
            'jon@jon.se',
            '456',
            [$contact],
            [$qualification]
        );

        $transaction = new Transaction('123', 'jon@jon.se', '456', [$arbetsformedlingenJob]);

        $class = new \ReflectionClass($transaction);

        $property = $class->getProperty('transactionDate');
        $property->setAccessible(true);
        $property->setValue($transaction, new \DateTimeImmutable('2020-01-22 09:18:30'));

        $document = $HRXMLDocumentCreator->createFromTransaction($transaction);

        $this->assertInstanceOf(HRXMLDocument::class, $document);
        $this->assertXmlStringEqualsXmlFile(__DIR__ . '/document.xml', $document);
    }
}
