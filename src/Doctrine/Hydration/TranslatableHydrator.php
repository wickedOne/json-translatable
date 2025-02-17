<?php

declare(strict_types=1);

/*
 * this file is part of the json translatable POC.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Doctrine\Hydration;

use Doctrine\ORM\Internal\Hydration\ObjectHydrator;

class TranslatableHydrator extends ObjectHydrator
{
    protected function hydrateRowData(array $row, array &$result): void
    {
        parent::hydrateRowData($row, $result);
    }
}
