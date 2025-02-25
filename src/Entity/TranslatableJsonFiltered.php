<?php

declare(strict_types=1);

/*
 * this file is part of the json translatable POC.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Contract\RecordTranslationsInterface;
use App\Doctrine\Listener\TranslatableJsonListener;
use App\Repository\TranslatableJsonFilteredRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @phpstan-import-type TranslationsType from RecordTranslationsInterface
 */
#[ORM\Entity(repositoryClass: TranslatableJsonFilteredRepository::class)]
#[ORM\EntityListeners([TranslatableJsonListener::class])]
class TranslatableJsonFiltered implements RecordTranslationsInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $description = null;

    /**
     * @var array<array-key, TranslationsType>
     */
    #[ORM\Column(type: Types::JSON)]
    private array $translations;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTranslations(): array
    {
        return $this->translations;
    }

    public function setTranslations(array $translations): self
    {
        $this->translations = $translations;

        return $this;
    }
}
