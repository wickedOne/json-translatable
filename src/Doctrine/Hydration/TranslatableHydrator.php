<?php

declare(strict_types=1);

namespace App\Doctrine\Hydration;


use Doctrine\ORM\Internal\Hydration\ObjectHydrator;

class TranslatableHydrator extends ObjectHydrator
{
    protected function hydrateRowData(array $row, array &$result): void
    {
//        $this->metadataCache
        parent::hydrateRowData($row, $result);
    }

}
