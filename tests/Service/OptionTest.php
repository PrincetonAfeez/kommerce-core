<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOptionRepository;

class OptionTest extends Helper\DoctrineTestCase
{
    /** @var FakeOptionRepository */
    protected $optionRepository;

    /** @var Option */
    protected $optionService;

    public function setUp()
    {
        $this->optionRepository = new FakeOptionRepository;
        $this->optionService = new Option($this->optionRepository);
    }

    public function testCreate()
    {
        $option = $this->getDummyOption();
        $this->optionService->create($option);
        $this->assertTrue($option instanceof Entity\Option);
    }

    public function testEdit()
    {
        $newName = 'New Name';
        $option = $this->getDummyOption();
        $this->assertNotSame($newName, $option->getName());

        $option->setName($newName);
        $this->optionService->edit($option);
        $this->assertSame($newName, $option->getName());
    }

    public function testFind()
    {
        $option = $this->optionService->find(1);
        $this->assertTrue($option instanceof Entity\Option);
    }

    public function testGetAllOptions()
    {
        $options = $this->optionService->getAllOptions();
        $this->assertTrue($options[0] instanceof Entity\Option);
    }
}