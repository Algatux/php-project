<?php

namespace App\Model\Formatter;

use App\Constant\DateTime;

class Date implements \JsonSerializable
{
    public function __construct(private readonly \DateTimeInterface $dateTime) {}

    public function jsonSerialize(): string
    {
        return $this->dateTime->format(DateTime::DEFAULT_FORMAT);
    }
}
