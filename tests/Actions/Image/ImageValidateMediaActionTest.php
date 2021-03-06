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

use Chevereto\Actions\Image\ImageValidateMediaAction;
use Intervention\Image\Image;
use PHPUnit\Framework\TestCase;
use Tests\Actions\Traits\ExpectInvalidArgumentExceptionCodeTrait;

final class ImageValidateMediaActionTest extends TestCase
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
        $action = new ImageValidateMediaAction;
        $arguments = $this->getTestArguments([]);
        $response = $action->run($action->getArguments(...$arguments));
        $this->assertInstanceOf(Image::class, $response->data()['image']);
    }

    public function testInvalidImage(): void
    {
        $action = new ImageValidateMediaAction;
        $arguments = $this->getTestArguments(['filename' => __FILE__]);
        $this->expectInvalidArgumentException(1000);
        $action->run($action->getArguments(...$arguments));
    }

    public function testMinHeight(): void
    {
        $action = new ImageValidateMediaAction;
        $arguments = $this->getTestArguments(['minHeight' => 301]);
        $this->expectInvalidArgumentException(1001);
        $action->run($action->getArguments(...$arguments));
    }

    public function testMaxHeight(): void
    {
        $action = new ImageValidateMediaAction;
        $arguments = $this->getTestArguments(['maxHeight' => 299]);
        $this->expectInvalidArgumentException(1002);
        $action->run($action->getArguments(...$arguments));
    }

    public function testMinWidth(): void
    {
        $action = new ImageValidateMediaAction;
        $arguments = $this->getTestArguments(['minWidth' => 301]);
        $this->expectInvalidArgumentException(1003);
        $action->run($action->getArguments(...$arguments));
    }

    public function testMaxWidth(): void
    {
        $action = new ImageValidateMediaAction;
        $arguments = $this->getTestArguments(['maxWidth' => 299]);
        $this->expectInvalidArgumentException(1004);
        $action->run($action->getArguments(...$arguments));
    }
}
