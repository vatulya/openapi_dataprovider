<?php

namespace OpenApiDataProvider;

class Generator
{

    public function generate(array $options): void
    {
        $schema = $options['schema'];
        $output = $options['output'];

        $schema = json_decode(file_get_contents($schema), true);


        $parameter = [
            'namespace' => 'OpenApiDataProvider',
            'className' => 'BooleanParameterExample',
            'positiveCases' => [
                [
                    'caseName' => 'TrueValue',
                    'caseValue' => 'true',
                ],
                [
                    'caseName' => 'FalseValue',
                    'caseValue' => 'false',
                ],
            ],
            'negativeCases' => [
                [
                    'caseName' => 'NullValue',
                    'caseValue' => 'null',
                ],
                [
                    'caseName' => 'ArrayValue',
                    'caseValue' => '[]',
                ],
            ],
            'testPositive' => <<<TEST
\$v = v::boolType();
foreach (\$this->object->getPositiveCasesValues() as \$caseName => \$positiveCaseValue) {
    if (!\$v->validate(\$positiveCaseValue)) {
        throw new \Exception('Wrong Positive case: "' . \$caseName . '"');
    }
}
TEST
            ,
            'testNegative' => <<<TEST
\$v = v::boolType();
foreach (\$this->object->getNegativeCasesValues() as \$caseName => \$negativeCaseValue) {
    if (\$v->validate(\$negativeCaseValue)) {
        throw new \Exception('Wrong Negative case: "' . \$caseName . '"');
    }
}
TEST
            ,

        ];



        $mustache = new \Mustache_Engine([
            'loader' => new \Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/../templates'),
        ]);

        $result = $mustache->render('parameter', $parameter);

        $destination = $output . 'parameter.php';
        if (!file_exists(dirname($destination))) {
            mkdir(dirname($destination), 0777, true);
        }
        file_put_contents($destination, $result);

        $result = $mustache->render('parameterTest', $parameter);

        $destination = $output . 'parameterTest.php';
        if (!file_exists(dirname($destination))) {
            mkdir(dirname($destination), 0777, true);
        }
        file_put_contents($destination, $result);

    }

}