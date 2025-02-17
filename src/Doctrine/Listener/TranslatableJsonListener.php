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

use App\Contract\RecordTranslationsInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Translation\LocaleSwitcher;

#[AsEntityListener]
class TranslatableJsonListener
{
    private readonly string $locale;

    public function __construct(
        private readonly PropertyAccessorInterface $propertyAccessor,
        LocaleSwitcher $switcher,
    ) {
        $this->locale = $switcher->getLocale();
    }

    public function postLoad(RecordTranslationsInterface $entity, PostLoadEventArgs $args): void
    {
        $translations = array_filter($entity->getTranslations(), fn (array $translation): bool => isset($translation['locale']) && $translation['locale'] === $this->locale);
        $properties = array_merge(...array_map(static fn (array $translation): array => $translation['properties'], $translations));

        foreach ($properties as $property => $value) {
            try {
                $this->propertyAccessor->setValue($entity, $property, $value);
            } catch (\Exception) {
            }
        }
    }
}
