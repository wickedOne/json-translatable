<?php

declare(strict_types=1);

/*
 * this file is part of the json translatable POC.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Doctrine\Extension\Query\Criteria;

readonly class JsonFilterCriteria
{
    public function __construct(
        public string $field,
        public string $needle,
        public string $path,
        public string $amount = 'one',
    ) {
    }

    public function expression(string $alias): string
    {
        return \sprintf('JSON_FILTER(%1$s.%2$s, \'%3$s\', \'%4$s\', \'%5$s\') AS %2$s_filtered', $alias, $this->field, $this->needle, $this->path, $this->amount);
    }
}
