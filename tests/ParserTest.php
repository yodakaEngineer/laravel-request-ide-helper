<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Yodaka\LaravelRequestIdeHelper\Parser;

class ParserTest extends TestCase
{
    public function testGeneratePhpDoc()
    {
        $actual = Parser::generatePhpDoc([
            'name' => 'required|string|max:255',
            'hotel_id' => 'required|integer|exists:hotels,id',
            'products.*.name' => 'required|string|max:255',
            'products.*.room_type_ids.*' => 'required|integer|exists:room_types,id',
            'products.*.prices.*.unit_amount' => 'required|numeric|min:1',
            'products.*.prices.*.interval' => 'required|string|in:day,week,month,year',
            'products.*.prices.*.interval_count' => 'required|integer|min:1',
        ]);
        $expected = [
            '@property-read string $name',
            '@property-read int $hotel_id',
            '@property-read array{"name": string, "room_type_ids": int[], "prices": array{"unit_amount": mixed, "interval": string, "interval_count": int}[]}[] $products',
        ];
        $this->assertEquals($expected, $actual);
    }
}
