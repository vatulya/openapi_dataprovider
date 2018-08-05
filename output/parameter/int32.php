<?php

namespace OpenApiDataProvider;

class Int32ParameterExample {

    protected $positiveCases = [
        'MinValue',
        'MaxValue',
        'AlmostMinValue',
        'AlmostMaxValue',
        'RandomValue',
    ];
    protected $negativeCases = [];


    public function MinValueCase() {
        return 1;
    }
    public function MaxValueCase() {
        return 1000;
    }
    public function AlmostMinValueCase() {
        return 2;
    }
    public function AlmostMaxValueCase() {
        return 999;
    }
    public function RandomValueCase() {
        return 234;
    }

    public function NullValueCase() {
        return null;
    }
    public function ArrayValueCase() {
        return [];
    }
    public function LessMinValueCase() {
        return 0;
    }
    public function MoreMaxValueCase() {
        return 1001;
    }
    public function NegativeValueCase() {
        return -1;
    }
    public function HugeValueCase() {
        return 10000000000;
    }

    public function getPositiveCases(): array {
        return $this->positiveCases;
    }

    public function getPositiveCasesValues(): array {
        $values = [];
        foreach ($this->positiveCases as $case) {
            $values[$case] = $this->{$case . 'Case'}();
        }
        return $values;
    }

    public function getNegativeCases(): array {
        return $this->negativeCases;
    }

    public function getNegativeCasesValues(): array {
        $values = [];
        foreach ($this->negativeCases as $case) {
            $values[$case] = $this->{$case . 'Case'}();
        }
        return $values;
    }

}