<?php
namespace App\Helper;

use App\Exceptions\PositiveValueException;
use Ramsey\Uuid\Type\Decimal;

class PositiveFloatValue
{
    private Decimal $value;

    public function __construct(float $value,string $msg)
    {
        $this->set($value,$msg);
    }

    public function set(float $value,string $msg): void
    {
        $val = new Decimal($value);
        if ($val->isNegative()) {
            throw new PositiveValueException(__("exceptions.$msg\_should_be_positive"));
        }

        $this->value = $val;
    }

    public function value(): float
    {
        return (float) $this->value->toString();
    }

    public function toString(): string
    {
        return $this->value->toString();
    }

    public function __toString(): string
    {
        return $this->toString();
    }

}
