<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleProductItemCommand;
use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateCartPriceRuleProductItemHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        CartPriceRule::class,
        AbstractCartPriceRuleItem::class,
        Product::class,
    ];

    public function testHandle()
    {
        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $product = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear([
            $cartPriceRule,
            $product,
        ]);
        $quantity = 1;
        $command = new CreateCartPriceRuleProductItemCommand(
            $cartPriceRule->getId()->getHex(),
            $product->getId()->getHex(),
            $quantity
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $cartPriceRuleProductItem = $this->getRepositoryFactory()->getCartPriceRuleItemRepository()->findOneById(
            $command->getCartPriceRuleProductItemId()
        );
        $this->assertEntitiesEqual($product, $cartPriceRuleProductItem->getProduct());
        $this->assertSame($quantity, $cartPriceRuleProductItem->getQuantity());
    }
}
