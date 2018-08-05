<?php

namespace OpenApiDataProvider;

use Respect\Validation\Validator as v;

class Int32ParameterExampleTest {

    protected $object;

    public function __construct() {
        $this->object = new Int32ParameterExample();
    }

    public function testPositiveCases() {
        $v = v::between(1, 1000, true);
foreach ($this->object->getPositiveCasesValues() as $caseName => $positiveCaseValue) {
    if (!$v->validate($positiveCaseValue)) {
        throw new \Exception('Wrong Positive case: "' . $caseName . '"');
    }
}
    }

    public function testNegativeCases() {
        $v = v::between(1, 1000, true);
foreach ($this->object->getNegativeCasesValues() as $caseName => $negativeCaseValue) {
    if ($v->validate($negativeCaseValue)) {
        throw new \Exception('Wrong Negative case: "' . $caseName . '"');
    }
}
    }

}