<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Onlyable
{
    /**
     * Get items having corresponding given keys.
     *
     * @param mixed ...$keys
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function only(...$keys): Collection;
}
