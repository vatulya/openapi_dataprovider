<?php

namespace OpenApiDataProvider;

class PathResolver
{

    public function get(\stdClass $schema, string $path)
    {
        $pathParts = $this->explodePathParts($path);

        $container = $schema;
        while ($key = array_shift($pathParts)) {
            $container = $container->{$key};
        }

        return $container;
    }

    public function getParent(\stdClass $schema, string $path)
    {
        $pathParts = $this->explodePathParts($path);
        array_pop($pathParts); // get parent
        $pathParent = $this->implodePathParts($pathParts);

        $container = $this->get($schema, $pathParent);
        return $container;
    }

    public function escapeKey(string $key): string
    {
        return str_replace('/', '\\/', $key);
    }

    public function escapeKeys(array $keys): array
    {
        foreach ($keys as &$key) {
            $key = $this->escapeKey($key);
        }
        return $keys;
    }

    public function unescapeKey(string $key): string
    {
        return str_replace('\\/', '/', $key);
    }

    public function unescapeKeys(array $keys): array
    {
        foreach ($keys as &$key) {
            $key = $this->unescapeKey($key);
        }
        return $keys;
    }

    public function isRefKey(string $key): bool
    {
        return preg_match('~\$ref~', $key);
    }

    public function getRefValue(\stdClass $schema, string $link): \stdClass
    {
        $link = ltrim($link, '#/');
        $pathParts = explode('/', $link);

        $value = $schema;
        while ($key = array_shift($pathParts)) {
            $value = $value->{$key};
        }

        return $value;
    }

    public function explodePathParts(string $path): array
    {
        $pathParts = preg_split('#(?<!\\\)\/#', $path);
        $pathParts = array_filter($pathParts);
        $pathParts = $this->unescapeKeys($pathParts);
        return $pathParts;
    }

    public function implodePathParts(array $pathParts): string
    {
        $pathParts = $this->escapeKeys($pathParts);
        $path = implode('/', $pathParts);
        return $path;
    }

}