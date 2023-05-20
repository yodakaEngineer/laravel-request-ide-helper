<?php

declare(strict_types=1);

namespace Yodaka\LaravelRequestIdeHelper;

class Parser
{
    /**
     * @param array $rules
     * @return array
     */
    public static function generatePhpDoc(array $rules): array
    {
        $rulePhpDocs = [];
        $rules = self::convertRules($rules);
        foreach ($rules as $key => $rule) {
            if (isset($rule["*"])) {
                $type = self::generateArrayShapeType($rule["*"]) . '[]';
            } else {
                $type = self::generateType($rule);
            }
            $rulePhpDocs[] = '@property-read ' . $type . ' $' . $key;
        }
        return $rulePhpDocs;
    }

    private static function generateType($rule): string
    {
        $rules = explode('|', $rule);
        $types = [];
        if (in_array('nullable', $rules, true)) {
            $types[] = 'null';
        }
        if (in_array('string', $rules, true)) {
            $types[] = 'string';
        }
        if (in_array('integer', $rules, true)) {
            $types[] = 'int';
        }
        if (in_array('array', $rules, true)) {
            $types[] = 'array';
        }
        if (in_array('boolean', $rules, true)) {
            $types[] = 'bool';
        }
        $type = implode('|', $types);
        return $type === '' ? 'mixed' : $type;
    }

    /**
     * @param array $array
     * @return array
     */
    private static function convertRules(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $segments = explode('.', $key);

            if (count($segments) === 1) {
                $result[$key] = $value;
            } else {
                $current = &$result;

                foreach ($segments as $segment) {
                    if (!isset($current[$segment])) {
                        $current[$segment] = [];
                    }

                    $current = &$current[$segment];
                }

                $current = $value;
            }
        }

        return $result;
    }

    /**
     * @param $rule
     * @return string
     */
    private static function generateArrayShapeType($rule): string
    {
        $types = [];
        foreach ($rule as $key => $value) {
            if ($key === '*') {
                if (is_array($value)) {
                    return self::generateArrayShapeType($value) . '[]';
                }
                return self::generateType($value) . '[]';
            }

            if (is_array($value)) {
                $type = self::generateArrayShapeType($value);
            } else {
                $type = self::generateType($value);
            }
            $types[] = '"' . $key . '": ' . $type;
        }
        return 'array{' . implode(', ', $types) . '}';
    }
}
