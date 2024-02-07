<?php
namespace App\Helper;

use App\Exceptions\PositiveValueException;
use Ramsey\Uuid\Type\Decimal;

class Helper
{

    public static function validateDecimal(float $value,string $msg): float
    {
        $val = new Decimal($value);
        if ($val->isNegative()) {
            throw new PositiveValueException(__("exceptions.$msg"."_should_be_positive"));
        }
        return (float) $val->toString();
    }

    public static function validateInt(int $value,string $msg): int
    {
        if ($value < 0) {
            throw new PositiveValueException(__("exceptions.$msg"."_should_be_positive"));
        }
        return intval($value);
    }


}
