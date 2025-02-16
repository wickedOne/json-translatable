<?php

declare(strict_types=1);

/*
 * this file is part of the json translatable POC.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Contract;

/**
 * @phpstan-type TranslationsType array{locale: string, properties: array<string, string>}
 */
interface RecordTranslationsInterface
{
    /**
     * @return array<array-key, TranslationsType>
     */
    public function getTranslations(): array;

    /**
     * @param array<array-key, TranslationsType> $translations
     */
    public function setTranslations(array $translations): RecordTranslationsInterface;
}
