<?php

namespace OpenApiDataProvider;

class BooleanParameterExample {

    protected $positiveCases = [
        'TrueValue',
        'FalseValue',
    ];
    protected $negativeCases = [];


    public function TrueValueCase() {
        return true;
    }
    public function FalseValueCase() {
        return false;
    }

    public function NullValueCase() {
        return null;
    }
    public function ArrayValueCase() {
        return [];
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