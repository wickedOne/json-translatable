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
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * @template T of object
 *
 * @extends ServiceEntityRepository<T>
 */
abstract class AbstractJsonFilteredRepository extends ServiceEntityRepository
{
    /**
     * @param array<string, JsonFilterCriteria> $filtered
     *
     * @return array<T>
     */
    public function findFiltered(Criteria $criteria, array $filtered = [], string $alias = 'r'): array
    {
        $columns = [];
        $fields = [];
        $key = 0;

        foreach (array_diff($this->getClassMetadata()->getFieldNames(), array_keys($filtered)) as $key => $field) {
            $fields[] = $alias.'.'.$field;
            $columns[$field] = $field.'_'.$key;
        }

        foreach ($filtered as $filterCriteria) {
            $fields[] = $filterCriteria->expression($alias);
            $columns[$filterCriteria->field] = 'sclr_'.++$key;
        }

        $rsm = new ResultSetMappingBuilder($this->getEntityManager(), ResultSetMappingBuilder::COLUMN_RENAMING_INCREMENT);
        $rsm->addRootEntityFromClassMetadata($this->getEntityName(), $alias, $columns);

        return $this
            ->createQueryBuilder($alias)
            ->select($fields)
            ->addCriteria($criteria)
            ->getQuery()
            ->setResultSetMapping($rsm)
            ->getResult()
        ;
    }
}
