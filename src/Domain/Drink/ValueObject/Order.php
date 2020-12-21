<?php

namespace App\Domain\Drink\ValueObject;

class Order
{

    private Type $type;

    private Money $money;

    private Sugar $sugar;

    private bool $extraHot;

    public function __construct(Type $type, Money $money, Sugar $sugar, bool $extraHot)
    {
        $this->type = $type;
        $this->money = $money;
        $this->sugar = $sugar;
        $this->extraHot = $extraHot;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getMoney(): Money
    {
        return $this->money;
    }

    public function getSugar(): Sugar
    {
        return $this->sugar;
    }

    public function getExtraHot(): bool
    {
        return $this->extraHot;
    }
}
