<?php

declare(strict_types=1);

/*
 * this file is part of the json translatable POC.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Doctrine\Extension\Query\Criteria\JsonFilterCriteria;
use App\Entity\TranslatableJsonFiltered;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Translation\LocaleSwitcher;

/**
 * @extends AbstractJsonFilteredRepository<TranslatableJsonFiltered>
 */
class TranslatableJsonFilteredRepository extends AbstractJsonFilteredRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly LocaleSwitcher $switcher,
    ) {
        parent::__construct($registry, TranslatableJsonFiltered::class);
    }

    /**
     * @return TranslatableJsonFiltered[]
     */
    public function findAllFiltered(string $alias = 'r'): array
    {
        return $this->findFiltered(
            Criteria::create(),
            [
                'translations' => new JsonFilterCriteria('translations', $this->switcher->getLocale(), '$[*].locale'),
            ],
            $alias
        );
    }
}
