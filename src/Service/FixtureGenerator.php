<?php

declare(strict_types=1);

/*
 * this file is part of the json translatable POC.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\Db57\Translatable;
use App\Entity\Db57\TranslatableJson;
use App\Entity\Db57\TranslatableJsonFiltered;
use App\Entity\Db57\Translations;
use Doctrine\ORM\EntityManagerInterface;
use joshtronic\LoremIpsum;

class FixtureGenerator
{
    private const PROPERTIES = ['title', 'name', 'description'];
    private const LOCALES = ['en', 'en_GB', 'es_ES', 'es_MX', 'de', 'de_AT', 'fr', 'pt', 'pt_BR', 'it', 'nl', 'cs', 'zh_CN', 'ru', 'tr', 'pl', 'ro', 'hu', 'sr', 'sv', 'bg', 'hr', 'sk', 'fi', 'da', 'no', 'uk', 'lt', 'sl', 'et', 'id_ID', 'hi_IN', 'th_TH', 'ja_JP', 'ko', 'el', 'vi_VN', 'zh_TW'];
    private readonly LoremIpsum $ipsum;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
        $this->ipsum = new LoremIpsum();
    }

    public function generate(int $size): void
    {
        $connection = $this->entityManager->getConnection();

        $cmdJson = $this->entityManager->getClassMetadata(TranslatableJson::class);
        $truncateJson = $connection->getDatabasePlatform()->getTruncateTableSQL($cmdJson->getTableName());
        $connection->executeStatement($truncateJson);

        $cmdJsonFiltered = $this->entityManager->getClassMetadata(TranslatableJsonFiltered::class);
        $truncateJsonFiltered = $connection->getDatabasePlatform()->getTruncateTableSQL($cmdJsonFiltered->getTableName());
        $connection->executeStatement($truncateJsonFiltered);

        $cmd = $this->entityManager->getClassMetadata(Translatable::class);
        $truncate = $connection->getDatabasePlatform()->getTruncateTableSQL($cmd->getTableName());
        $connection->executeStatement($truncate);

        $values = [];
        $batchSize = 100;

        for ($i = 0; $i < $size; ++$i) {
            $values[] = '(\''.implode('\', \'', ['original '.$this->ipsum->words(2), 'original '.$this->ipsum->words(3), null, json_encode($this->translations())]).'\')';

            if (($i % $batchSize) === 0) {
                $connection->prepare(\sprintf('INSERT INTO TranslatableJson (title, name, description, translations) VALUES %s', implode(', ', $values)))->executeQuery();
                $connection->prepare(\sprintf('INSERT INTO TranslatableJsonFiltered (title, name, description, translations) VALUES %s', implode(', ', $values)))->executeQuery();
                $values = [];
            }
        }

        $connection->prepare(\sprintf('INSERT INTO TranslatableJson (title, name, description, translations) VALUES %s', implode(', ', $values)))->executeQuery();
        $connection->prepare(\sprintf('INSERT INTO TranslatableJsonFiltered (title, name, description, translations) VALUES %s', implode(', ', $values)))->executeQuery();

        $this->classic();
    }

    private function classic(): void
    {
        $tableName = $this->entityManager->getClassMetadata(Translations::class)->getTableName();
        $query = $this->entityManager->createQuery('SELECT t FROM App\Entity\Db57\TranslatableJson t');
        $connection = $this->entityManager->getConnection();

        foreach ($query->toIterable() as $row) {
            \assert($row instanceof TranslatableJson);
            $this->entityManager->remove($row);

            $connection->prepare(\sprintf('INSERT INTO Translatable (id, title, name, description) VALUES (%d, \'%s\', \'%s\', \'%s\')', $row->getId(), $row->getTitle(), $row->getName(), $row->getDescription()))->executeQuery();
            $values = [];

            foreach ($row->getTranslations() as $translation) {
                foreach ($translation['properties'] as $property => $value) {
                    $values[] = '(\''.$tableName.'\','.$row->getId().', \''.$property.'\',\''.$value.'\',\''.$translation['locale'].'\')';
                }
            }

            $connection->prepare(\sprintf('INSERT INTO Translations (tableName, recordId, field, value, locale) VALUES %s', implode(', ', $values)))->executeQuery();
        }
    }

    private function translations(): array
    {
        $translations = [];

        foreach ($this->locales() as $locale) {
            $generated = ['locale' => $locale, 'properties' => []];

            foreach ($this->properties() as $property) {
                $generated['properties'][$property] = $this->propertyValue($property);
            }
            $translations[] = $generated;
        }

        return $translations;
    }

    private function properties(): array
    {
        return array_intersect_key(self::PROPERTIES, (array) array_rand(self::PROPERTIES, random_int(1, \count(self::PROPERTIES))));
    }

    private function locales(): array
    {
        return array_intersect_key(self::LOCALES, (array) array_rand(self::LOCALES, random_int(1, \count(self::LOCALES))));
    }

    private function propertyValue(string $property): string
    {
        return match ($property) {
            'description' => str_replace("\n", ' ', substr($this->ipsum->paragraphs(3), 0, random_int(0, 2000))),
            default => str_replace("\n", ' ', substr($this->ipsum->paragraph(), 0, random_int(0, 255))),
        };
    }
}
