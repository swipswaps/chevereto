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

namespace Chevereto\Components;

final class Users
{
    public function __construct()
    {
    }

    public function get(int $id): User
    {
        // DB

        return new User($id);
    }
}
