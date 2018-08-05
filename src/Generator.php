<?php

namespace OpenApiDataProvider;

class Generator
{

    public function generate(array $options): void
    {
        $schema = $options['schema'];
        $output = $options['output'];

        $schema = json_decode(file_get_contents($schema), true);

        $parameters = [];
        $parameters['boolean'] = [
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
        $parameters['int32'] = [
            'namespace' => 'OpenApiDataProvider',
            'className' => 'Int32ParameterExample',
            'positiveCases' => [
                [
                    'caseName' => 'MinValue',
                    'caseValue' => '1',
                ],
                [
                    'caseName' => 'MaxValue',
                    'caseValue' => '1000',
                ],
                [
                    'caseName' => 'AlmostMinValue',
                    'caseValue' => '2',
                ],
                [
                    'caseName' => 'AlmostMaxValue',
                    'caseValue' => '999',
                ],
                [
                    'caseName' => 'RandomValue',
                    'caseValue' => '234',
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
                [
                    'caseName' => 'LessMinValue',
                    'caseValue' => '0',
                ],
                [
                    'caseName' => 'MoreMaxValue',
                    'caseValue' => '1001',
                ],
                [
                    'caseName' => 'NegativeValue',
                    'caseValue' => '-1',
                ],
                [
                    'caseName' => 'HugeValue',
                    'caseValue' => '10000000000',
                ],
            ],
            'testPositive' => <<<TEST
\$v = v::between(1, 1000, true);
foreach (\$this->object->getPositiveCasesValues() as \$caseName => \$positiveCaseValue) {
    if (!\$v->validate(\$positiveCaseValue)) {
        throw new \Exception('Wrong Positive case: "' . \$caseName . '"');
    }
}
TEST
            ,
            'testNegative' => <<<TEST
\$v = v::between(1, 1000, true);
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

        foreach ($parameters as $parameterName => $parameter) {
            $result = $mustache->render('parameter', $parameter);

            $destination = $output . 'parameter/' . $parameterName . '.php';
            if (!file_exists(dirname($destination))) {
                mkdir(dirname($destination), 0777, true);
            }
            file_put_contents($destination, $result);

            $result = $mustache->render('parameterTest', $parameter);

            $destination = $output . 'parameter/' . $parameterName . '.test.php';
            if (!file_exists(dirname($destination))) {
                mkdir(dirname($destination), 0777, true);
            }
            file_put_contents($destination, $result);
        }

    }

}