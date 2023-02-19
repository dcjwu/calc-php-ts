<?php

namespace App\Models;

class CalculationListItemsResponse
{
    /**
     * @param CalculationListItems[] $items
     */
    public function __construct(
        private readonly array $items
    )
    {
    }

    /**
     * @return CalculationListItems[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}