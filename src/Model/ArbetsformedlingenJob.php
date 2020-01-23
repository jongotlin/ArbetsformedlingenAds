<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds\Model;

class ArbetsformedlingenJob
{
    const SALARY_TYPE_FIXED = 1;
    const SALARY_TYPE_FIXED_AND_COMMISSION = 2;
    const SALARY_TYPE_COMMISSION = 3;

    const TERM_LENGTH_TEMPORARY_EMPLOYMENT_6_MONTHS_OR_LONGER = 2;
    const TERM_LENGTH_TEMPORARY_EMPLOYMENT_3_TO_6_MONTHS = 3;
    const TERM_LENGTH_TEMPORARY_EMPLOYMENT_DURING_THE_SUMMER_MONTHS = 4;
    const TERM_LENGTH_TEMPORARY_EMPLOYMENT_11_DAYS_TO_3_MONTHS = 7;
    const TERM_LENGTH_TEMPORARY_EMPLOYMENT_MAX_10_DAYS = 8;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var string
     */
    private $postingId;

    /**
     * @var string
     */
    private $organisationName;

    /**
     * @var string
     */
    private $organisationId;

    /**
     * @var \DateTimeInterface
     */
    private $endDate;

    /**
     * @var string
     */
    private $contactEmail;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $municipalityCode;

    /**
     * @var boolean
     */
    private $fullTime;

    /**
     * @var string
     */
    private $scheduleDescription;

    /**
     * @var bool
     */
    private $indefinitePeriod;

    /**
     * @var int|null
     */
    private $termLength;

    /**
     * @var string
     */
    private $durationDescription;

    /**
     * @var int
     */
    private $salaryType;

    /**
     * @var string
     */
    private $salaryDescription;

    /**
     * @var string|null
     */
    private $applyUrl;

    /**
     * @var string|null
     */
    private $applyEmail;

    /**
     * @var string
     */
    private $occupationGroupCode;

    /**
     * @var Contact[]
     */
    private $contacts;

    /**
     * @param bool $active
     * @param string $postingId
     * @param string $organisationName
     * @param string $organisationId
     * @param \DateTimeInterface $endDate
     * @param string $contactEmail
     * @param string $title
     * @param string $description
     * @param string $street
     * @param string $postalCode
     * @param string $city
     * @param string $countryCode
     * @param string $municipalityCode
     * @param bool $fullTime
     * @param string $scheduleDescription
     * @param bool $indefinitePeriod
     * @param int $termLength
     * @param string $durationDescription
     * @param string $salaryType
     * @param string $salaryDescription
     * @param string|null $applyUrl
     * @param string|null $applyEmail
     * @param string $occupationGroupCode
     * @param Contact[] $contacts
     */
    public function __construct(
        bool $active,
        string $postingId,
        string $organisationName,
        string $organisationId,
        \DateTimeInterface $endDate,
        string $contactEmail,
        string $title,
        string $description,
        string $street,
        string $postalCode,
        string $city,
        string $countryCode,
        string $municipalityCode,
        bool $fullTime,
        string $scheduleDescription,
        bool $indefinitePeriod,
        ?int $termLength,
        string $durationDescription,
        int $salaryType,
        string $salaryDescription,
        ?string $applyUrl,
        ?string $applyEmail,
        string $occupationGroupCode,
        array $contacts
    )
    {
        $this->active = $active;
        $this->postingId = $postingId;
        $this->organisationName = $organisationName;
        $this->organisationId = $organisationId;
        $this->endDate = $endDate;
        $this->contactEmail = $contactEmail;
        $this->title = $title;
        $this->description = $description;
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->countryCode = $countryCode;
        $this->municipalityCode = $municipalityCode;
        $this->fullTime = $fullTime;
        $this->scheduleDescription = $scheduleDescription;
        $this->indefinitePeriod = $indefinitePeriod;
        $this->termLength = $termLength;
        $this->durationDescription = $durationDescription;
        $this->salaryType = $salaryType;
        $this->salaryDescription = $salaryDescription;
        $this->applyUrl = $applyUrl;
        $this->applyEmail = $applyEmail;
        $this->occupationGroupCode = $occupationGroupCode;
        $this->contacts = $contacts;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getPostingId(): string
    {
        return $this->postingId;
    }

    /**
     * @return string
     */
    public function getOrganisationName(): string
    {
        return $this->organisationName;
    }

    /**
     * @return string
     */
    public function getOrganisationId(): string
    {
        return $this->organisationId;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @return string
     */
    public function getContactEmail(): string
    {
        return $this->contactEmail;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getMunicipalityCode(): string
    {
        return $this->municipalityCode;
    }

    /**
     * @return bool
     */
    public function isFullTime(): bool
    {
        return $this->fullTime;
    }

    /**
     * @return string
     */
    public function getScheduleDescription(): string
    {
        return $this->scheduleDescription;
    }

    /**
     * @return bool
     */
    public function isIndefinitePeriod(): bool
    {
        return $this->indefinitePeriod;
    }

    /**
     * @return int|null
     */
    public function getTermLength(): ?int
    {
        return $this->termLength;
    }

    /**
     * @return string
     */
    public function getDurationDescription(): string
    {
        return $this->durationDescription;
    }

    /**
     * @return int
     */
    public function getSalaryType(): int
    {
        return $this->salaryType;
    }

    /**
     * @return string
     */
    public function getSalaryDescription(): string
    {
        return $this->salaryDescription;
    }

    /**
     * @return string|null
     */
    public function getApplyUrl(): ?string
    {
        return $this->applyUrl;
    }

    /**
     * @return string|null
     */
    public function getApplyEmail(): ?string
    {
        return $this->applyEmail;
    }

    /**
     * @return string
     */
    public function getOccupationGroupCode(): string
    {
        return $this->occupationGroupCode;
    }

    /**
     * @return Contact[]
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }
}
