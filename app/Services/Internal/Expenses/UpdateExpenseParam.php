<?php

namespace App\Services\Internal\Expenses;

use App\Services\Internal\Utils\AttributeUnchanged;
use App\Services\Internal\Utils\SelfFillableTrait;

class UpdateExpenseParam {

    use DateStringConverter, SelfFillableTrait;

    protected $id;
    protected $description;
    protected $recurrent;

    protected array $attributesExcluded = ['id'];

    public function __construct() {
        $this->description = new AttributeUnchanged();
        $this->recurrent = new AttributeUnchanged();
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return UpdateExpenseParam
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return UpdateExpenseParam
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRecurrent() {
        return $this->recurrent;
    }

    /**
     * @param mixed $recurrent
     * @return UpdateExpenseParam
     */
    public function setRecurrent($recurrent) {
        $this->recurrent = $recurrent;
        return $this;
    }

    private function isValidAttribute(string $attribute, array $data): bool {

        $shouldBeIgnored = (
            $attribute === 'attributesExcluded' ||
            in_array($attribute, $this->attributesExcluded)
        );

        if($shouldBeIgnored) {
            return false;
        }

        return in_array($attribute, array_keys($data));
    }
}