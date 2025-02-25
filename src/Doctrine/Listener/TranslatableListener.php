<?php

declare(strict_types=1);

/*
 * this file is part of the json translatable POC.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Doctrine\Listener;

use App\Contract\TranslatableInterface;
use App\Repository\TranslationsRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Translation\LocaleSwitcher;

#[AsEntityListener]
class TranslatableListener
{
    private readonly string $locale;

    public function __construct(
        private readonly TranslationsRepository $repository,
        private readonly PropertyAccessorInterface $propertyAccessor,
        LocaleSwitcher $switcher,
    ) {
        $this->locale = $switcher->getLocale();
    }

    public function postLoad(TranslatableInterface $entity, PostLoadEventArgs $args): void
    {
        $result = $this->repository->findTranslations($entity);
        $translations = $result[$this->locale] ?? [];

        foreach ($translations as $field => $value) {
            $this->propertyAccessor->setValue($entity, $field, $value);
        }
    }
}
