<?php

declare(strict_types=1);

namespace App\Tests;

use App\Application\Persistence\Order\OrderRepositoryInterface;
use App\Domain\Order;
use App\Domain\ValueObject\OrderId;
use App\Infrastructure\DataFixture\ReferenceFixture;
use App\Infrastructure\Persistence\Order\OrderEntityMapper;
use App\Infrastructure\Persistence\Order\OrderProxy;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class OrderPersistenceTest extends KernelTestCase
{
    private OrderRepositoryInterface $repository;
    private OrderEntityMapper $mapper;


    /**
     * @throws \Exception
     */
    public function test(): void
    {
        self::assertTrue(true);
        return;
        $reflection = new \ReflectionClass(ReferenceFixture::class);
        $props = $reflection->getProperties();

        for ($i = 0; $i < 500; $i++) {
            foreach ($props as $prop) {
                ReferenceFixture::${$prop->getName()} = (string)Uuid::uuid4();
            }

            $application = new Application(self::$kernel);
            $application->setAutoExit(false);

            $output = new BufferedOutput();

            $application->run(
                new ArrayInput(
                    [
                        'command' => 'doctrine:fixtures:load',
                        '--append' => true,
                    ]
                ),
                $output
            );
        }

        // return the output, don't use if you used NullOutput()
        echo $output->fetch();
    }

    public function testGetForId(): void
    {
        $order = $this->repository->getForId($this->orderIdFixture());

        $this->assertOrderProxyHasBeenFetched($order);
    }

    private function orderIdFixture(): OrderId
    {
        return OrderId::fromString(ReferenceFixture::$ORDER_ID);
    }

    private function assertOrderProxyHasBeenFetched(Order $order): void
    {
        self::assertInstanceOf(OrderProxy::class, $order);

        if ($order instanceof OrderProxy) {
            $entity = $order->getEntity($this->mapper);
            self::assertEquals($this->orderIdFixture(), $entity->getId());
        }
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $this->repository = self::$container->get(OrderRepositoryInterface::class);
        $this->mapper = self::$container->get(OrderEntityMapper::class);
    }
}
