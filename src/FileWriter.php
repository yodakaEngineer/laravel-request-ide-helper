<?php

namespace Yodaka\LaravelRequestIdeHelper;

class FileWriter
{
    public static function write(string $path, array $rulePhpDocs): void
    {
        $content = file_get_contents($path);
        $convertedString = "/**\n";
        foreach ($rulePhpDocs as $item) {
            $convertedString .= " * $item\n";
        }
        $convertedString .= " */";
        $modifiedContent = preg_replace('/^class\s+\w+/m', "{$convertedString}\n$0", $content);

        file_put_contents($path, $modifiedContent);
    }
}
