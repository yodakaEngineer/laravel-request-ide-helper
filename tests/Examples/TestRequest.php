<?php

declare(strict_types=1);

namespace Tests\Examples;

/**
 * @property-read string $name
 * @property-read int $hotel_id
 * @property-read array{"name": string, "room_type_ids": int[], "prices": array{"unit_amount": mixed, "interval": string, "interval_count": int}[]}[] $products
 */
class TestRequest
{
    private $rules;

    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    public function rules()
    {
        return $this->rules;
    }
}
