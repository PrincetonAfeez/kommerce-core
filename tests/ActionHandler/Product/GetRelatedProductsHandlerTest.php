<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetRelatedProductsQuery;
use inklabs\kommerce\Action\Product\Query\GetRelatedProductsRequest;
use inklabs\kommerce\Action\Product\Query\GetRelatedProductsResponse;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetRelatedProductsHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $product1 = $this->dummyData->getProduct();
        $product2 = $this->dummyData->getProduct();
        $product3 = $this->dummyData->getProduct();
        $product4 = $this->dummyData->getProduct();
        $tag = $this->dummyData->getTag();
        $tag->addProduct($product1);
        $tag->addProduct($product2);
        $tag->addProduct($product3);
        $this->persistEntityAndFlushClear([
            $tag,
            $product1,
            $product2,
            $product3,
            $product4,
        ]);
        $limit = 4;
        $request = new GetRelatedProductsRequest(
            [$product1->getId()->getHex()],
            $limit
        );
        $response = new GetRelatedProductsResponse($this->getPricing());
        $query = new GetRelatedProductsQuery($request, $response);

        $this->dispatchQuery($query);

        $this->assertEntitiesInDTOList([$product2, $product3], $response->getProductDTOs());
    }
}
