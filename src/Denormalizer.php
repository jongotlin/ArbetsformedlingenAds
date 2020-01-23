<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds;

use JGI\ArbetsformedlingenAds\Exception\InvalidJsonException;
use JGI\ArbetsformedlingenAds\Model\Error;
use JGI\ArbetsformedlingenAds\Model\Result;

class Denormalizer
{
    /**
     * @param array|null $data
     * 
     * @return Result
     */
    public function denormalizeResult(?array $data): Result
    {
        if ($data === null) {
            throw new InvalidJsonException();
        }
        
        if (array_key_exists('Message', $data)) {
            return new Result();
        }

        $errors = [];
        foreach ($data as $row) {
            if (!array_key_exists('Message', $row)) {
                throw new InvalidJsonException('Message key is missing');
            }
            if (!array_key_exists('ErrorCode', $row)) {
                throw new InvalidJsonException('ErrorCode key is missing');
            }

            $errors[] = new Error($row['Message'], $row['ErrorCode']);
        }

        return new Result($errors);
    }
}
