<?php
namespace inklabs\kommerce\Action\User\Handler;

use inklabs\kommerce\Action\User\ResetPasswordCommand;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Event\ResetPasswordEvent;
use inklabs\kommerce\Service\UserService;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserLoginRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserTokenRepository;

class ResetPasswordHandlerTest extends DoctrineTestCase
{
    /** @var FakeUserRepository */
    protected $fakeUserRepository;

    /** @var FakeUserTokenRepository */
    protected $fakeUserTokenRepository;

    /** @var UserService */
    protected $userService;

    /** @var ResetPasswordCommand */
    protected $command;

    /** @var FakeEventDispatcher */
    protected $fakeEventDispatcher;

    public function setUp()
    {
        parent::setUp();

        $this->fakeUserRepository = new FakeUserRepository;
        $this->fakeUserTokenRepository = new FakeUserTokenRepository;
        $this->fakeEventDispatcher = new FakeEventDispatcher;

        $this->userService = new UserService(
            $this->fakeUserRepository,
            new FakeUserLoginRepository,
            $this->fakeUserTokenRepository,
            $this->fakeEventDispatcher
        );

        $this->command = new ResetPasswordCommand(
            'test1@example.com',
            '127.0.0.1',
            'SampleBot/1.1'
        );
    }

    public function testHandle()
    {
        $user = $this->dummyData->getUser();
        $this->fakeUserRepository->create($user);

        $handler = new ResetPasswordHandler($this->userService);
        $handler->handle($this->command);
        $this->assertTrue($this->fakeUserTokenRepository->findOneById(1) instanceof UserToken);
        $this->assertTrue($this->fakeEventDispatcher->wasEventDispatched(ResetPasswordEvent::class));
    }

    public function testHandleThroughCommandBus()
    {
        $this->setupEntityManager([
            'kommerce:User',
            'kommerce:UserRole',
            'kommerce:UserToken',
        ]);
        $user = $this->dummyData->getUser();
        $this->getRepositoryFactory()->getUserRepository()->create($user);

        $this->getCommandBus()->execute($this->command);

        $this->assertTrue($this->getRepositoryFactory()->getUserTokenRepository()->findOneById(1) instanceof UserToken);
    }
}
