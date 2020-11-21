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

namespace Chevereto\Controllers\Api\V2\Image\Traits;

use Chevere\Components\Workflow\Task;
use Chevere\Interfaces\Workflow\TaskInterface;
use Chevereto\Actions\Image\StripMetaAction;

trait ImageGetStripMetaTaskTrait
{
    public function getStripMetaTask(): TaskInterface
    {
        return (new Task(StripMetaAction::class))
            ->withArguments(['image' => '${validate:image}']);
    }
}
