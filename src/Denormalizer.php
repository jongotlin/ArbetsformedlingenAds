<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds;

use JGI\ArbetsformedlingenAds\Exception\InvalidJsonException;
use JGI\ArbetsformedlingenAds\Exception\InvalidResultException;
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
        elseif (!array_is_list($data) && !array_key_exists('Message', $data)) {
            throw new InvalidResultException("Provided result data is invalid: " . json_encode($data));
        }
        elseif (array_key_exists('Message', $data)) {
            if ($data['Message'] != "Unauthorized") {
                return new Result(null, $data);
            }
            elseif (!isset($data['ErrorCode'])) {
                $data['ErrorCode'] = 401;
            }
            
            $data = [$data];
        }

        $errors = [];

        foreach ($data as $row) {
            if (is_string($row)) {
                $row = ['Message' => $row, 'ErrorCode' => 0];
            }
            elseif (!array_key_exists('Message', $row)) {
                throw new InvalidJsonException('Message key is missing');
            }
            elseif (!array_key_exists('ErrorCode', $row)) {
                throw new InvalidJsonException('ErrorCode key is missing');
            }

            $errors[] = new Error($row['Message'], $row['ErrorCode']);
        }

        return new Result($errors);
    }
}
