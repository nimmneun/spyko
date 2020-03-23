<?php

namespace Spyko\Model;

/**
 * @property $valueCode
 */
class AttributeValue implements \JsonSerializable
{
    private $value;
    private $valueCode;

    public function __construct(string $value, string $valueCode = null)
    {
        $this->value = $value;
        $this->valueCode = $valueCode;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return $this->value;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}