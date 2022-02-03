<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Coalesce extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(iterable<TKey, T>): Generator<TKey, T> $pipe */
        $pipe = (new Pipe())()(
            (new Compact())()(),
            (new Head())(),
        );

        // Point free style.
        return $pipe;
    }
}
