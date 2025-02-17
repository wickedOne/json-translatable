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

use App\Contract\TranslatableInterface;
use App\Entity\Db57\Translations;
use Doctrine\ORM\EntityManagerInterface;

class TranslationsRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function findTranslations(TranslatableInterface $object): array
    {
        $tableName = $this->entityManager->getClassMetadata($object::class)->getTableName();
        $return = [];
        $result = $this->entityManager->createQueryBuilder()
            ->select('translations')
            ->from(Translations::class, 'translations')
            ->where('translations.recordId = :recordId')
            ->andWhere('translations.tableName = :tableName')
            ->orderBy('translations.locale')
            ->setParameter('recordId', $object->getId())
            ->setParameter('tableName', $tableName)
            ->getQuery()
            ->getArrayResult();

        foreach ($result as $row) {
            $return[$row['locale']][$row['field']] = $row['value'];
        }

        return $return;
    }
}
