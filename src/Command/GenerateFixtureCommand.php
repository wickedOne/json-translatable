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

use App\Service\FixtureGenerator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('fixtures:generate')]
class GenerateFixtureCommand extends Command
{
    public function __construct(
        private readonly FixtureGenerator $generator,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('generate translatable json fixtures')
            ->addArgument('amount', InputArgument::OPTIONAL, 'the number of fixtures to create', 10);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $amount = $input->getArgument('amount');

        \assert(is_numeric($amount));

        $this->generator->generate((int) $amount);

        return Command::SUCCESS;
    }
}
