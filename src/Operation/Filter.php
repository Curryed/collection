<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Utils\CallbacksArrayReducer;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Filter extends AbstractOperation
{
    /**
     * @return Closure(callable(T=, TKey=, iterable<TKey, T>=): bool ...): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$callbacks
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<TKey, T>
                 */
                static function (iterable $iterable) use ($callbacks): Generator {
                    $defaultCallback =
                        /**
                         * @param T $value
                         */
                        static fn ($value): bool => (bool) $value;

                    $callbacks = [] === $callbacks ?
                        [$defaultCallback] :
                        $callbacks;

                    foreach ($iterable as $key => $current) {
                        if (CallbacksArrayReducer::or()($callbacks, $current, $key, $iterable)) {
                            yield $key => $current;
                        }
                    }
                };
    }
}
