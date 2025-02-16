<?php

declare(strict_types=1);

/*
 * this file is part of the json translatable POC.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command;

use App\Entity\Db57\TranslatableJson;
use App\Entity\Db57\TranslatableJsonFiltered;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('fixtures:generate')]
class GenerateFixtureCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $translations = [
            [
                'locale' => 'nl_NL',
                'properties' => [
                    'title' => 'dutch title',
                    'name' => 'dutch name',
                    'description' => 'dutch description',
                ],
            ],
            [
                'locale' => 'de_DE',
                'properties' => [
                    'title' => 'german title',
                    'description' => 'german description',
                ],
            ],
        ];

        $entity = (new TranslatableJson())
            ->setName('name')
            ->setTitle('title')
            ->setDescription('description')
            ->setTranslations($translations)
        ;

        $this->entityManager->persist($entity);

        $entity = (new TranslatableJsonFiltered())
            ->setName('name')
            ->setTitle('title')
            ->setDescription('description')
            ->setTranslations($translations)
        ;

        $this->entityManager->persist($entity);

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
