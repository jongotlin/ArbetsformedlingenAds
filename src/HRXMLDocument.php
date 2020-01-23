<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds;

class HRXMLDocument extends \DOMDocument
{
    public function __construct()
    {
        parent::__construct('1.0', 'utf-8');
    }
}
