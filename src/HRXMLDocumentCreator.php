<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds;

use JGI\ArbetsformedlingenAds\Model\ArbetsformedlingenJob;
use JGI\ArbetsformedlingenAds\Model\Transaction;

class HRXMLDocumentCreator
{
    /**
     * @param Transaction $transaction
     *
     * @return HRXMLDocument
     */
    public function createFromTransaction(Transaction $transaction): HRXMLDocument
    {
        $hrxml = new HRXMLDocument();

        $root = $hrxml->createElement('Envelope');
        $root->setAttributeNodeNS(new \DOMAttr('xmlns', 'http://arbetsformedlingen.se/LedigtArbete'));
        $root->setAttributeNodeNS(new \DOMAttr('version', '0.52'));

        $sender = $hrxml->createElement('Sender');
        $sender->setAttributeNodeNS(new \DOMAttr('id', $transaction->getSenderId()));
        $sender->setAttributeNodeNS(new \DOMAttr('email', $transaction->getSenderEmail()));
        $root->appendChild($sender);

        $transactInfo = $hrxml->createElement('TransactInfo');
        if ($transaction->getTransactionDate()) {
            $transactInfo->setAttributeNodeNS(new \DOMAttr('timeStamp', $transaction->getTransactionDate()->format('Y-m-d\TH:i:s')));
        }
        if ($transaction->getTransactionId()) {
            $transactInfo->appendChild($hrxml->createElement('TransactId', $transaction->getTransactionId()));
        }
        $root->appendChild($transactInfo);

        $packetId = 0;
        foreach ($transaction->getArbetsformedlingenJobs() as $arbetsformedlingenJob) {
            $packetId++;
            $packet = $hrxml->createElement('Packet');
            $packetInfo = $hrxml->createElement('PacketInfo');
            $packetInfo->appendChild($hrxml->createElement('PacketId', (string) $packetId));
            $packet->appendChild($packetInfo);
            $payload = $hrxml->createElement('Payload');
            $jobPositionPosting = $hrxml->createElement('JobPositionPosting');
            $jobPositionPosting->setAttributeNodeNS(new \DOMAttr('status', $arbetsformedlingenJob->isActive() ? 'active' : 'inactive'));
            $jobPositionPosting->appendChild($hrxml->createElement('JobPositionPostingId', $arbetsformedlingenJob->getPostingId()));

            $hiringOrg = $hrxml->createElement('HiringOrg');
            $hiringOrg->appendChild($hrxml->createElement('HiringOrgName', $arbetsformedlingenJob->getOrganisationName()));
            $hiringOrg->appendChild($hrxml->createElement('HiringOrgId', $arbetsformedlingenJob->getOrganisationId()));
            //$hiringOrg->appendChild($hrxml->createElement('WebSite', 'https://example.com'));
            $hiringOrg->appendChild($hrxml->createElement('Contact'));
            $jobPositionPosting->appendChild($hiringOrg);

            $postDetail = $hrxml->createElement('PostDetail');
            $endDate = $hrxml->createElement('EndDate');
            $endDate->appendChild($hrxml->createElement('Date', $arbetsformedlingenJob->getEndDate()->format('Y-m-d')));
            $postDetail->appendChild($endDate);

            $postedBy = $hrxml->createElement('PostedBy');
            $contact = $hrxml->createElement('Contact');
            $contact->appendChild($hrxml->createElement('E-mail', $arbetsformedlingenJob->getContactEmail()));
            $postedBy->appendChild($contact);
            $postDetail->appendChild($postedBy);
            $jobPositionPosting->appendChild($postDetail);

            $jobPositionInformation = $hrxml->createElement('JobPositionInformation');
            $jobPositionInformation->appendChild($hrxml->createElement('JobPositionTitle', $arbetsformedlingenJob->getTitle()));
            $jobPositionDescription = $hrxml->createElement('JobPositionDescription');
            $jobPositionDescription->appendChild($hrxml->createElement('JobPositionPurpose', $arbetsformedlingenJob->getDescription()));
            $jobPositionLocation = $hrxml->createElement('JobPositionLocation');
            $postalAddress = $hrxml->createElement('PostalAddress');
            //if ($arbetsformedlingenJob->getCountryCode() != 'SE') {
                $postalAddress->appendChild($hrxml->createElement('CountryCode', $arbetsformedlingenJob->getCountryCode()));
            //}
            $postalAddress->appendChild($hrxml->createElement('PostalCode', $arbetsformedlingenJob->getPostalCode()));
            $postalAddress->appendChild($hrxml->createElement('Municipality', $arbetsformedlingenJob->getCity()));
            $deliveryAddress = $hrxml->createElement('DeliveryAddress');
            $deliveryAddress->appendChild($hrxml->createElement('AddressLine', $arbetsformedlingenJob->getStreet()));
            $deliveryAddress->appendChild($hrxml->createElement('PostOfficeBox', $arbetsformedlingenJob->getStreet()));
            $postalAddress->appendChild($deliveryAddress);
            $jobPositionLocation->appendChild($postalAddress);

            $locationSummary = $hrxml->createElement('LocationSummary');
            $locationSummary->appendChild($hrxml->createElement('Municipality', $arbetsformedlingenJob->getMunicipalityCode()));
            $locationSummary->appendChild($hrxml->createElement('CountryCode', $arbetsformedlingenJob->getCountryCode()));
            $jobPositionLocation->appendChild($locationSummary);

            $jobPositionDescription->appendChild($jobPositionLocation);

            $classification = $hrxml->createElement('Classification');
            $schedule = $hrxml->createElement('Schedule');
            if ($arbetsformedlingenJob->isFullTime()) {
                $schedule->appendChild($hrxml->createElement('FullTime'));
            } else {
                $schedule->appendChild($hrxml->createElement('PartTime'));
            }
            $schedule->appendChild($hrxml->createElement('SummaryText', $arbetsformedlingenJob->getScheduleDescription()));
            $classification->appendChild($schedule);
            $duration = $hrxml->createElement('Duration');
            if ($arbetsformedlingenJob->isIndefinitePeriod()) {
                $duration->appendChild($hrxml->createElement('Regular'));
            } else {
                $temporary = $hrxml->createElement('Temporary');
                $temporary->appendChild($hrxml->createElement('TermLength', (string)$arbetsformedlingenJob->getTermLength()));
                $duration->appendChild($temporary);
            }
            $duration->appendChild($hrxml->createElement('SummaryText', $arbetsformedlingenJob->getDurationDescription()));
            $classification->appendChild($duration);
            $jobPositionDescription->appendChild($classification);
            $jobPositionInformation->appendChild($jobPositionDescription);

            $compensationDescription = $hrxml->createElement('CompensationDescription');
            $pay = $hrxml->createElement('Pay');
            $salaryMonthly = $hrxml->createElement('SalaryMonthly', (string)$arbetsformedlingenJob->getSalaryType());
            $salaryMonthly->setAttributeNodeNS(new \DOMAttr('currency', 'SEK'));
            $pay->appendChild($salaryMonthly);
            $compensationDescription->appendChild($pay);
            $compensationDescription->appendChild($hrxml->createElement('SummaryText', $arbetsformedlingenJob->getSalaryDescription()));
            $jobPositionDescription->appendChild($compensationDescription);

            $jobPositionPosting->appendChild($jobPositionInformation);

            $howToApply = $hrxml->createElement('HowToApply');
            $applicationMethods = $hrxml->createElement('ApplicationMethods');
            if ($arbetsformedlingenJob->getApplyEmail()) {
                $byEmail = $hrxml->createElement('ByEmail');
                $byEmail->appendChild($hrxml->createElement('E-mail', $arbetsformedlingenJob->getApplyEmail()));
                $applicationMethods->appendChild($byEmail);
            }
            if ($arbetsformedlingenJob->getApplyUrl()) {
                $byWeb = $hrxml->createElement('ByWeb');
                $byWeb->appendChild($hrxml->createElement('URL', $arbetsformedlingenJob->getApplyUrl()));
                $applicationMethods->appendChild($byWeb);
            }
            $howToApply->appendChild($applicationMethods);
            $jobPositionPosting->appendChild($howToApply);

            $jobPositionPosting->appendChild($hrxml->createElement('NumberToFill', '1'));

            $jppExtension = $hrxml->createElement('JPPExtension');
            foreach ($arbetsformedlingenJob->getContacts() as $contactModel) {
                $informationContact = $hrxml->createElement('InformationContact');
                $contact = $hrxml->createElement('Contact');
                if ($contactModel->isUnionRepresentative()) {
                    $contact->setAttributeNodeNS(new \DOMAttr('type', 'union'));
                }
                $personName = $hrxml->createElement('PersonName');
                $personName->appendChild($hrxml->createElement('GivenName', $contactModel->getFirstname()));
                $personName->appendChild($hrxml->createElement('FamilyName', $contactModel->getLastname()));
                $contact->appendChild($personName);
                if ($contactModel->getTitle()) {
                    $contact->appendChild($hrxml->createElement('PositionTitle', $contactModel->getTitle()));
                }
                if ($contactModel->getPhoneNumber()) {
                    $telNumber = $hrxml->createElement('TelNumber', $contactModel->getPhoneNumber());
                    $voiceNumber = $hrxml->createElement('VoiceNumber');
                    $voiceNumber->appendChild($telNumber);
                    $contact->appendChild($voiceNumber);
                }
                if ($contactModel->getEmail()) {
                    $contact->appendChild($hrxml->createElement('E-mail', $contactModel->getEmail()));
                }
                $informationContact->appendChild($contact);
                $jppExtension->appendChild($informationContact);
            }

            $occupationGroup = $hrxml->createElement('OccupationGroup');
            $occupationGroup->setAttributeNodeNS(new \DOMAttr('codename', 'OccupationNameID'));
            $occupationGroup->setAttributeNodeNS(new \DOMAttr('code', $arbetsformedlingenJob->getOccupationGroupCode()));
            $jppExtension->appendChild($occupationGroup);

            $jobPositionPosting->appendChild($jppExtension);

            $payload->appendChild($jobPositionPosting);
            $packet->appendChild($payload);
            $root->appendChild($packet);
        }

        $hrxml->appendChild($root);

        return $hrxml;
    }
}
