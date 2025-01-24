<?php

namespace App\Repositories\Interfaces;

interface ItemRepositoryInterface
{
    public function completedOrderQuantity(): int;
    public function sum(string $column, array $conditions = []): int|float;
}
