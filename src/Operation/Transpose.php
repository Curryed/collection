<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\IterableIteratorAggregate;
use MultipleIterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Transpose extends AbstractOperation
{
    /**
     * @psalm-suppress ImpureMethodCall - using MultipleIterator as an internal tool which is not returned
     *
     * @return Closure(iterable<TKey, T>): Generator<TKey, list<T>>
     */
    public function __invoke(): Closure
    {
        $callbackForKeys =
            /**
             * @param non-empty-array<int, TKey> $key
             *
             * @return TKey
             */
            static fn (array $key) => reset($key);

        $callbackForValues =
            /**
             * @param array<int, T> $value
             *
             * @return array<int, T>
             */
            static fn (array $value): array => $value;

        /** @var Closure(iterable<TKey, T>): Generator<TKey, list<T>> $pipe */
        $pipe = (new Pipe())()(
            (new Reduce())()(
                static function (MultipleIterator $acc, iterable $iterable): MultipleIterator {
                    $acc->attachIterator((new IterableIteratorAggregate($iterable))->getIterator());

                    return $acc;
                }
            )(new MultipleIterator(MultipleIterator::MIT_NEED_ANY)),
            (new Flatten())()(1),
            (new Associate())()($callbackForKeys)($callbackForValues)
        );

        // Point free style.
        return $pipe;
    }
}
