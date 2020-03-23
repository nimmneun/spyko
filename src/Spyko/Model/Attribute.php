<?php

namespace Spyko\Model;

class Attribute implements \JsonSerializable
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return $this->value;
    }
}