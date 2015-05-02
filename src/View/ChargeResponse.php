<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class ChargeResponse implements ViewInterface
{
    public $id;
    public $created;
    public $amount;
    public $last4;
    public $brand;
    public $currency;
    public $fee;
    public $description;

    public function __construct(Lib\PaymentGateway\ChargeResponse $chargeResponse)
    {
        $this->id          = $chargeResponse->getId();
        $this->created     = $chargeResponse->getCreated();
        $this->amount      = $chargeResponse->getAmount();
        $this->last4       = $chargeResponse->getLast4();
        $this->brand       = $chargeResponse->getBrand();
        $this->currency    = $chargeResponse->getCurrency();
        $this->fee         = $chargeResponse->getFee();
        $this->description = $chargeResponse->getDescription();
    }

    public function export()
    {
        return $this;
    }
}