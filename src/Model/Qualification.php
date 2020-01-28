<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds\Model;

class Qualification
{
    const TYPE_LICENSE = 'license';
    const TYPE_EQUIPMENT = 'equipment';

    const EXPERIENCE_NOT_REQUIRED = 'no_required';
    const EXPERIENCE_REQUIRED = 'required';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $category;

    /**
     * @var string
     */
    private $experience;

    /**
     * @param string $type
     * @param string $category
     * @param string $experience
     */
    public function __construct(string $type, string $category, string $experience)
    {
        $this->type = $type;
        $this->category = $category;
        $this->experience = $experience;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getExperience(): string
    {
        return $this->experience;
    }
}
