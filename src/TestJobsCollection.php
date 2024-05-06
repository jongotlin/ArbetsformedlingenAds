<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds;

use JGI\ArbetsformedlingenAds\Model\ArbetsformedlingenJob;
use JGI\ArbetsformedlingenAds\Model\Qualification;

class TestJobsCollection
{
    /**
     * Create test jobs defined in "Test_Procedure_ Direkt transfer to platsbanken.doc"
     *
     * @param string $organisationNumber
     * @param string $email
     *
     * @return ArbetsformedlingenJob[]
     */
    public static function createTestJobs(string $organisationNumber, string $email): array
    {
        $arbetsformedlingenJob1 = new ArbetsformedlingenJob(
            true,
            sprintf('46-%s-1', $organisationNumber),
            'Bemanna AB',
            '46-' . $organisationNumber,
            new \DateTime('+1 day'),
            $email,
            'Test job - 1',
            <<<DESCRIPTION
Full time
Temporary employment 6 months or longer
In any location in Sweden
Qualification yearsOfExperince 4 = experience is requred
DESCRIPTION,
            'Street 1',
            '71930',
            'Vintrosa',
            'SE',
            '1880',
            true,
            'Heltid',
            false,
            ArbetsformedlingenJob::TERM_LENGTH_TEMPORARY_EMPLOYMENT_6_MONTHS_OR_LONGER,
            '6 månader',
            ArbetsformedlingenJob::SALARY_TYPE_FIXED,
            'Daglön',
            'http://example.com',
            $email,
            '6794',
            [],
            [new Qualification(Qualification::TYPE_LICENSE, 'B', Qualification::EXPERIENCE_REQUIRED)]
        );

        $arbetsformedlingenJob2 = new ArbetsformedlingenJob(
            true,
            sprintf('46-%s-2', $organisationNumber),
            'Bemanna AB',
            '46-' . $organisationNumber,
            new \DateTime('+1 day'),
            $email,
            'Test job - 2',
            <<<DESCRIPTION
Part time
Permanent
In any location in Sweden
Qualification yearsOfExperince 1 = experience not required
DESCRIPTION,
            'Street 1',
            '71930',
            'Vintrosa',
            'SE',
            '1880',
            false,
            'Halvtid',
            true,
            null,
            'Tillsvidare',
            ArbetsformedlingenJob::SALARY_TYPE_FIXED,
            'Daglön',
            'http://example.com',
            $email,
            '6794',
            [],
            [new Qualification(Qualification::TYPE_LICENSE, 'B', Qualification::EXPERIENCE_NOT_REQUIRED)]
        );

        $arbetsformedlingenJob3 = new ArbetsformedlingenJob(
            true,
            sprintf('46-%s-3', $organisationNumber),
            'Bemanna AB',
            '46-' . $organisationNumber,
            new \DateTime('+1 day'),
            $email,
            'Test job - 3',
            <<<DESCRIPTION
Full time
Temporary employment 11 days to 3 months
In any location in Sweden
Qualification yearsOfExperince 1 = experience not required
DESCRIPTION,
            'Street 1',
            '71930',
            'Vintrosa',
            'SE',
            '1880',
            true,
            'Heltid',
            false,
            ArbetsformedlingenJob::TERM_LENGTH_TEMPORARY_EMPLOYMENT_11_DAYS_TO_3_MONTHS,
            '11 dagar',
            ArbetsformedlingenJob::SALARY_TYPE_FIXED,
            'Daglön',
            'http://example.com',
            $email,
            '6794',
            [],
            [new Qualification(Qualification::TYPE_LICENSE, 'B', Qualification::EXPERIENCE_NOT_REQUIRED)]
        );

        $arbetsformedlingenJob4 = new ArbetsformedlingenJob(
            true,
            sprintf('46-%s-4', $organisationNumber),
            'Bemanna AB',
            '46-' . $organisationNumber,
            new \DateTime('+1 day'),
            $email,
            'Test job - 4',
            <<<DESCRIPTION
Part time
Temporary employment 3-6 months
In any location in Sweden
Comission only
Qualification yearsOfExperince 1 = experience not required
DESCRIPTION,
            'Street 1',
            '71930',
            'Vintrosa',
            'SE',
            '1880',
            false,
            'Deltid',
            false,
            ArbetsformedlingenJob::TERM_LENGTH_TEMPORARY_EMPLOYMENT_3_TO_6_MONTHS,
            '3 månader',
            ArbetsformedlingenJob::SALARY_TYPE_COMMISSION,
            'Provisionslön',
            'http://example.com',
            $email,
            '6794',
            [],
            [new Qualification(Qualification::TYPE_LICENSE, 'B', Qualification::EXPERIENCE_NOT_REQUIRED)]
        );

        $arbetsformedlingenJob5 = new ArbetsformedlingenJob(
            true,
            sprintf('46-%s-5', $organisationNumber),
            'Bemanna AB',
            '46-' . $organisationNumber,
            new \DateTime('+1 day'),
            $email,
            'Test job - 5',
            <<<DESCRIPTION
Full time
Temporary employment during the summer months (June to August)
In any location in Sweden
Fixed plus Comission
Qualification yearsOfExperince 1 = experience not required
DESCRIPTION,
            'Street 1',
            '71930',
            'Vintrosa',
            'SE',
            '1880',
            true,
            'Heltid',
            false,
            ArbetsformedlingenJob::TERM_LENGTH_TEMPORARY_EMPLOYMENT_DURING_THE_SUMMER_MONTHS,
            '3 månader',
            ArbetsformedlingenJob::SALARY_TYPE_FIXED_AND_COMMISSION,
            'Provisionslön',
            'http://example.com',
            $email,
            '6794',
            [],
            [new Qualification(Qualification::TYPE_LICENSE, 'B', Qualification::EXPERIENCE_NOT_REQUIRED)]
        );

        $arbetsformedlingenJob6 = new ArbetsformedlingenJob(
            true,
            sprintf('46-%s-6', $organisationNumber),
            'Bemanna AB',
            '46-' . $organisationNumber,
            new \DateTime('+1 day'),
            $email,
            'Test job - 6',
            <<<DESCRIPTION
Full time
Temporary employment
Unspecified workplace within Sweden
Qualification yearsOfExperince 1 = experience not required
DESCRIPTION,
            'Street 1',
            '71930',
            'Vintrosa',
            'SE',
            '',
            true,
            'Heltid',
            false,
            ArbetsformedlingenJob::TERM_LENGTH_TEMPORARY_EMPLOYMENT_DURING_THE_SUMMER_MONTHS,
            'Sommarjobb',
            ArbetsformedlingenJob::SALARY_TYPE_FIXED_AND_COMMISSION,
            'Provisionslön',
            'http://example.com',
            $email,
            '6794',
            [],
            [new Qualification(Qualification::TYPE_LICENSE, 'B', Qualification::EXPERIENCE_NOT_REQUIRED)]
        );

        $arbetsformedlingenJob7 = new ArbetsformedlingenJob(
            true,
            sprintf('46-%s-7', $organisationNumber),
            'Bemanna AB',
            '46-' . $organisationNumber,
            new \DateTime('+1 day'),
            $email,
            'Test job - 7',
            <<<DESCRIPTION
Full time
Permanent
Any country outside of Sweden
Fixed salary
Qualification yearsOfExperince 4 = experience is requred
DESCRIPTION,
            'Street 1',
            '71930',
            'Vintrosa',
            'NO',
            null,
            true,
            'Heltid',
            true,
            null,
            'Tillsvidare',
            ArbetsformedlingenJob::SALARY_TYPE_FIXED,
            'Provisionslön',
            'http://example.com',
            $email,
            '6794',
            [],
            [new Qualification(Qualification::TYPE_LICENSE, 'B', Qualification::EXPERIENCE_REQUIRED)]
        );

        $arbetsformedlingenJob8 = new ArbetsformedlingenJob(
            true,
            sprintf('46-%s-8', $organisationNumber),
            'Bemanna AB',
            '46-' . $organisationNumber,
            new \DateTime('+1 day'),
            $email,
            'Test job - 8',
            <<<DESCRIPTION
Full time
Temporary employment 6 months or longer
In any location in Sweden
Driver license, CEOccupation truck driver
Fixed plus Comission
Qualification yearsOfExperince 4 = experience is requred
DESCRIPTION,
            'Street 1',
            '71930',
            'Vintrosa',
            'SE',
            '1880',
            true,
            'Heltid',
            false,
            ArbetsformedlingenJob::TERM_LENGTH_TEMPORARY_EMPLOYMENT_6_MONTHS_OR_LONGER,
            'Tillsvidare',
            ArbetsformedlingenJob::SALARY_TYPE_FIXED_AND_COMMISSION,
            'Provisionslön',
            'http://example.com',
            $email,
            '5687', // Truckförare
            [],
            [new Qualification(Qualification::TYPE_EXPERIENCE, null, Qualification::EXPERIENCE_REQUIRED)]
        );

        return [
            $arbetsformedlingenJob1,
            $arbetsformedlingenJob2,
            $arbetsformedlingenJob3,
            $arbetsformedlingenJob4,
            $arbetsformedlingenJob5,
            $arbetsformedlingenJob6,
            $arbetsformedlingenJob7,
            $arbetsformedlingenJob8
        ];
    }
}
