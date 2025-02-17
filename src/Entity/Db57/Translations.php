<?php

declare(strict_types=1);

/*
 * this file is part of the json translatable POC.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Db57;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Index(name: 'IDX_record_id_table_name_field', columns: ['recordId', 'tableName', 'field'])]
#[ORM\Index(name: 'IDX_table_name_field', columns: ['tableName', 'field'])]
#[ORM\Index(name: 'IDX_table_name_locale_code_record_id', columns: ['tableName', 'locale', 'recordId'])]
class Translations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255, nullable: false)]
    private string $tableName;

    #[ORM\Column(type: 'integer', nullable: false, options: ['unsigned' => true])]
    private string $recordId;

    #[ORM\Column(length: 64, nullable: false)]
    private string $field;

    #[ORM\Column(length: 2000, nullable: false)]
    private string $value;

    #[ORM\Column(length: 5, nullable: false)]
    private string $locale;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function setTableName(string $tableName): self
    {
        $this->tableName = $tableName;

        return $this;
    }

    public function getRecordId(): string
    {
        return $this->recordId;
    }

    public function setRecordId(string $recordId): self
    {
        $this->recordId = $recordId;

        return $this;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }
}
