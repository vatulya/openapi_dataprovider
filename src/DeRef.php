<?php

namespace OpenApiDataProvider;

class DeRef
{

    private $refs = [];

    private $pathResolver;

    public function __construct()
    {
        $this->pathResolver = new PathResolver();
    }

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

        return json_decode(json_encode($schemaObject), true);
    }

    private function findRefs(array $schema, string $path = '')
    {
        foreach ($schema as $key => $value) {
            if (is_array($value)) {
                $this->findRefs($value, $path . '/' . $this->pathResolver->escapeKey($key));
            } elseif ($this->pathResolver->isRefKey($key)) {
                $this->refs[$path] = $value;
            }
        }
    }

    private function replaceRef(\stdClass $schema, string $path, string $link): void
    {
        $newValue = $this->pathResolver->getRefValue($schema, $link);

        $pathParts = $this->pathResolver->explodePathParts($path);
        $refKey = array_pop($pathParts);
        $parentPath = $this->pathResolver->implodePathParts($pathParts);

        $container = $this->pathResolver->get($schema, $parentPath);
        $container->{$refKey} = $newValue;
    }

}