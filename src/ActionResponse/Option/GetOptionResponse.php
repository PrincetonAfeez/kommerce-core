<?php
namespace inklabs\kommerce\ActionResponse\Option;

use inklabs\kommerce\EntityDTO\Builder\OptionDTOBuilder;
use inklabs\kommerce\EntityDTO\OptionDTO;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetOptionResponse implements ResponseInterface
{
    /** @var OptionDTOBuilder */
    private $productDTOBuilder;

    /** @var PricingInterface */
    private $pricing;

    public function __construct(PricingInterface $pricing)
    {
        $this->pricing = $pricing;
    }

    public function setOptionDTOBuilder(OptionDTOBuilder $productDTOBuilder): void
    {
        $this->productDTOBuilder = $productDTOBuilder;
    }

    public function getOptionDTO(): OptionDTO
    {
        return $this->productDTOBuilder
            ->build();
    }

    public function getOptionDTOWithAllData(): OptionDTO
    {
        return $this->productDTOBuilder
            ->withAllData($this->pricing)
            ->build();
    }
}
