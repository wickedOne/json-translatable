<?php

declare(strict_types=1);

/*
 * this file is part of the json translatable POC.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Doctrine\Extension\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * extracts one or more objects from a json array of objects.
 *
 * @example JSON_FILTER(translations, 'nl_NL', '$[*].locale' [, 'all'])
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class JsonFilter extends FunctionNode
{
    private Node $target;
    private Node $needle;
    private Node $path;
    private string|Node $amount = 'one';

    /**
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->target = $parser->StringPrimary();

        $parser->match(TokenType::T_COMMA);

        $this->needle = $parser->StringPrimary();

        $parser->match(TokenType::T_COMMA);

        $this->path = $parser->StringPrimary();

        if ($parser->getLexer()->isNextToken(TokenType::T_COMMA)) {
            $parser->match(TokenType::T_COMMA);

            $this->amount = $parser->StringPrimary();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        $target = $sqlWalker->walkStringPrimary($this->target);
        $needle = $sqlWalker->walkStringPrimary($this->needle);
        $path = $sqlWalker->walkStringPrimary($this->path);
        $amount = $sqlWalker->walkStringPrimary($this->amount);
        $offset = $sqlWalker->walkStringPrimary(substr($path, strpos($path, '.') ?: strlen($path), -1));

        return \sprintf(
            'JSON_ARRAY(JSON_EXTRACT(%1$s, JSON_UNQUOTE(REPLACE(JSON_SEARCH(%1$s, %5$s, %2$s, NULL, %3$s), %4$s, \'\'))))',
            $target, $needle, $path, $offset, $amount
        );
    }
}
