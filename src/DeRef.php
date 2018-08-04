<?php

namespace OpenApiDataProvider;

class DeRef
{

    private $refs = [];

    public function deref(array $options): array
    {
        $schema = $options['schema'];

        $schemaJson = file_get_contents($schema);
        $schemaObject = json_decode($schemaJson);
        $schemaArray = json_decode($schemaJson, true);

        $this->findRefs($schemaArray);

        foreach ($this->refs as $path => $link) {
            $this->replaceRef($schemaObject, $path, $link);
        }

        return (array)$schemaObject;
    }

    private function findRefs(array $schema, string $path = '')
    {
        if (is_array($schema)) {
            foreach ($schema as $key => $value) {
                if (is_array($value)) {
                    $this->findRefs($value, $path . '/' . $this->escapeKey($key));
                } elseif (preg_match('~\$ref~', $key)) {
                    $this->refs[$path] = $value;
                }
            }
        }
    }

    private function escapeKey(string $key): string
    {
        return str_replace('/', '\\/', $key);
    }

    private function unescapeKey(string $key): string
    {
        return str_replace('\\/', '/', $key);
    }

    private function unescapeKeys(array $keys): array
    {
        foreach ($keys as &$key) {
            $key = $this->unescapeKey($key);
        }
        return $keys;
    }

    private function replaceRef(\stdClass $schema, string $path, string $link): void
    {
        $newValue = $schema;
        $link = ltrim($link, '#/');
        $pathParts = explode('/', $link);

        while ($key = array_shift($pathParts)) {
            $newValue = $newValue->{$key};
        }

        $container = $schema;
        $pathParts = preg_split('#(?<!\\\)\/#', $path);
        $pathParts = array_filter($pathParts);
        $pathParts = $this->unescapeKeys($pathParts);

        while ($key = array_shift($pathParts)) {
            if (!count($pathParts)) {
                $container->{$key} = $newValue;
                break;
            } else {
                $container = $container->{$key};
            }
        }
    }

}