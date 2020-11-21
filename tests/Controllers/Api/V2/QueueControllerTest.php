<?php

/*
 * This file is part of Chevereto.
 *
 * (c) Rodolfo Berrios <rodolfo@chevereto.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Chevereto\Tests\Controllers\Api\V2;

use Chevere\Components\Response\ResponseSuccess;
use Chevere\Components\Workflow\Workflow;
use Chevere\Exceptions\Core\LogicException;
use Chevere\Exceptions\Core\OutOfBoundsException;
use Chevere\Exceptions\Service\ServiceException;
use Chevere\Interfaces\Parameter\ArgumentsInterface;
use Chevere\Interfaces\Response\ResponseInterface;
use Chevere\Interfaces\Workflow\WorkflowInterface;
use Chevereto\Components\Enqueue;
use Chevereto\Components\Settings;
use Chevereto\Controllers\Api\V2\QueueController;
use PHPUnit\Framework\TestCase;

final class QueueControllerTest extends TestCase
{
    public function testConstruct(): void
    {
        $controller = new TestQueueControllerTest;
        $serviceProviders = $controller->getServiceProviders();
        $this->assertSame(['withEnqueue', 'withWorkflow', 'withSettings'], $serviceProviders->keys());
    }

    public function testWithoutEnqueue(): void
    {
        $controller = new TestQueueControllerTest;
        $this->expectException(ServiceException::class);
        $controller->enqueue();
    }

    public function testWithEnqueue(): void
    {
        $enqueue = new Enqueue;
        $controller = (new TestQueueControllerTest)->withEnqueue($enqueue);
        $this->assertSame($enqueue, $controller->enqueue());
    }

    public function testWithoutWorkflow(): void
    {
        $controller = new TestQueueControllerTest;
        $this->expectException(ServiceException::class);
        $controller->workflow();
    }

    public function testWithWorkflow(): void
    {
        $controller = new TestQueueControllerTest;
        $workflow = $controller->getWorkflow();
        $controller = $controller->withWorkflow($workflow);
        $this->assertSame($workflow, $controller->workflow());
    }

    public function testWithoutSettings(): void
    {
        $controller = new TestQueueControllerTest;
        $this->expectException(ServiceException::class);
        $controller->settings();
    }

    public function testWithSettings(): void
    {
        $controller = new TestQueueControllerTest;
        $settings = new Settings(['test' => '123']);
        $controller = $controller->withSettings($settings);
        $this->assertSame($settings, $controller->settings());
        $this->expectException(OutOfBoundsException::class);
        $controller->withSettings(new Settings([]));
    }
}

final class TestQueueControllerTest extends QueueController
{
    public function getSettingsKeys(): array
    {
        return ['test'];
    }

    public function getWorkflow(): WorkflowInterface
    {
        return new Workflow('test');
    }

    public function run(ArgumentsInterface $arguments): ResponseInterface
    {
        return new ResponseSuccess([]);
    }
}