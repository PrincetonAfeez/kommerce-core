<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\GetTagQuery;
use inklabs\kommerce\Action\Tag\Query\GetTagRequest;
use inklabs\kommerce\Action\Tag\Query\GetTagResponse;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetTagHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Image::class,
        Option::class,
        Product::class,
        Tag::class,
        TextOption::class,
    ];

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $this->persistEntityAndFlushClear($tag);
        $pricing = $this->dummyData->getPricing();
        $request = new GetTagRequest($tag->getId()->getHex());
        $response = new GetTagResponse($pricing);
        $query = new GetTagQuery($request, $response);

        $this->dispatchQuery($query);
        $this->assertSame($tag->getId()->getHex(), $response->getTagDTO()->id->getHex());

        $this->dispatchQuery($query);
        $this->assertSame($tag->getId()->getHex(), $response->getTagDTOWithAllData()->id->getHex());
    }
}
