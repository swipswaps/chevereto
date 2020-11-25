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

namespace Tests\Actions\Image;

use Chevere\Components\Parameter\Arguments;
use Chevereto\Actions\Image\ValidateMediaAction;
use Intervention\Image\Image;
use PHPUnit\Framework\TestCase;
use Tests\Actions\Traits\ExpectInvalidArgumentExceptionCodeTrait;

final class ValidateMediaActionTest extends TestCase
{
    use ExpectInvalidArgumentExceptionCodeTrait;

    private function getTestArguments(array $arguments): array
    {
        return array_replace([
            'filename' => __DIR__ . '/assets/favicon.png',
            'maxWidth' => 1000,
            'maxHeight' => 1000,
            'minWidth' => 100,
            'minHeight' => 100,
        ], $arguments);
    }

    public function testConstruct(): void
    {
        $action = new ValidateMediaAction;
        $arguments = new Arguments(
            $action->parameters(),
            $this->getTestArguments([])
        );
        $response = $action->run($arguments);
        $this->assertInstanceOf(Image::class, $response->data()['image']);
    }

    public function testInvalidImage(): void
    {
        $action = new ValidateMediaAction;
        $arguments = new Arguments(
            $action->parameters(),
            $this->getTestArguments([
                'filename' => __FILE__
            ])
        );
        $this->expectInvalidArgumentException(1000);
        $action->run($arguments);
    }

    public function testMaxWidth(): void
    {
        $action = new ValidateMediaAction;
        $arguments = new Arguments(
            $action->parameters(),
            $this->getTestArguments([
                'maxWidth' => 299,
            ])
        );
        $this->expectInvalidArgumentException(1001);
        $action->run($arguments);
    }

    public function testMaxHeight(): void
    {
        $action = new ValidateMediaAction;
        $arguments = new Arguments(
            $action->parameters(),
            $this->getTestArguments([
                'maxHeight' => 299,
            ])
        );
        $this->expectInvalidArgumentException(1002);
        $action->run($arguments);
    }

    public function testMinWidth(): void
    {
        $action = new ValidateMediaAction;
        $arguments = new Arguments(
            $action->parameters(),
            $this->getTestArguments([
                'minWidth' => 301,
            ])
        );
        $this->expectInvalidArgumentException(1003);
        $action->run($arguments);
    }

    public function testMinHeight(): void
    {
        $action = new ValidateMediaAction;
        $arguments = new Arguments(
            $action->parameters(),
            $this->getTestArguments([
                'minHeight' => 301,
            ])
        );
        $this->expectInvalidArgumentException(1004);
        $action->run($arguments);
    }
}