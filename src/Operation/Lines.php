<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

use const PHP_EOL;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Lines extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, string>
     */
    public function __invoke(): Closure
    {
        $mapCallback =
            /**
             * @param list<T> $value
             */
            static fn (array $value): string => implode('', $value);

        /** @var Closure(iterable<TKey, T>): Generator<int, string> $pipe */
        $pipe = (new Pipe())()(
            (new Explode())()(PHP_EOL, "\n", "\r\n"),
            (new Map())()($mapCallback)
        );

        // Point free style.
        return $pipe;
    }
}
