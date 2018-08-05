<?php

namespace OpenApiDataProvider;

use Respect\Validation\Validator as v;

class BooleanParameterExampleTest {

    protected $object;

    public function __construct() {
        $this->object = new BooleanParameterExample();
    }

    public function testPositiveCases() {
        $v = v::boolType();
foreach ($this->object->getPositiveCasesValues() as $caseName => $positiveCaseValue) {
    if (!$v->validate($positiveCaseValue)) {
        throw new \Exception('Wrong Positive case: "' . $caseName . '"');
    }
}
    }

    public function testNegativeCases() {
        $v = v::boolType();
foreach ($this->object->getNegativeCasesValues() as $caseName => $negativeCaseValue) {
    if ($v->validate($negativeCaseValue)) {
        throw new \Exception('Wrong Negative case: "' . $caseName . '"');
    }
}
    }

}