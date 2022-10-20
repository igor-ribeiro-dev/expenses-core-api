<?php

namespace App\Services\Internal\Utils;

use Illuminate\Support\Str;

trait SelfFillableTrait {

    public function fill(array $data) {

        foreach ($this as $attribute => $value) {

            if( ! $this->isValidAttribute($attribute, $data)) {
                continue;
            }

            $value = $data[$attribute];

            $setter = $this->makeSetterMethodString($attribute);

            call_user_func([$this, $setter], $value);
        }

        return $this;
    }

    private function makeSetterMethodString($attribute) {
        return 'set'.Str::studly($attribute);
    }
}