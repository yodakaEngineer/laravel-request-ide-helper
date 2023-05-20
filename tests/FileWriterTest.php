<?php

namespace Yodaka\LaravelRequestIdeHelper;

use PHPUnit\Framework\TestCase;

class FileWriterTest extends TestCase
{
    public function testWrite()
    {
        $path = __DIR__ . '/Examples/TestRequest.php';
        $rulePhpDocs = [
            '@property-read string $name',
            '@property-read int $hotel_id',
            '@property-read array{"name": string, "room_type_ids": int[], "prices": array{"unit_amount": mixed, "interval": string, "interval_count": int}[]}[] $products',
        ];
        FileWriter::write($path, $rulePhpDocs);
        $this->assertFileEquals(__DIR__ . '/Examples/ChangedTestRequest.php', $path);
    }
}
