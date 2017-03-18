<?php
namespace inklabs\kommerce\ActionResponse\Shipment;

use inklabs\kommerce\EntityDTO\Builder\ShipmentRateDTOBuilder;
use inklabs\kommerce\EntityDTO\ShipmentRateDTO;

class GetLowestShipmentRatesByDeliveryMethodResponse
{
    /** @var ShipmentRateDTOBuilder[] */
    private $shipmentRateDTOBuilders = [];

    public function addShipmentRateDTOBuilder(ShipmentRateDTOBuilder $shipmentRateDTOBuilder)
    {
        $this->shipmentRateDTOBuilders[] = $shipmentRateDTOBuilder;
    }

    /**
     * @return ShipmentRateDTO[]
     */
    public function getShipmentRateDTOs()
    {
        $shipmentRateDTOs = [];
        foreach ($this->shipmentRateDTOBuilders as $shipmentRateDTOBuilder) {
            $shipmentRateDTOs[] = $shipmentRateDTOBuilder->build();
        }
        return $shipmentRateDTOs;
    }
}