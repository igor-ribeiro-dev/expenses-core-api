<?php

namespace App\Services\Internal\Utils;

class AttributeUnchanged {

    public function __get(string $name) {
        return null;
    }

    public function __invoke() {
        return null;
    }

    public function __toString(): string {
        return '';
    }

    public static function __callStatic(string $name, array $arguments) {
        return null;
    }

}