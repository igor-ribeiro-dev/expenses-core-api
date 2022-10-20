<?php

namespace App\Services\Internal\Expenses;

use App\Services\Internal\Utils\AttributeUnchanged;
use App\Services\Internal\Utils\SelfFillableTrait;

class UpdateExpenseParam {

    use DateStringConverter, SelfFillableTrait;

    protected $id;
    protected $description;
    protected $value;
    protected $barcode_slip;
    protected $expiration;
    protected $recurrent;

    protected array $attributesExcluded = ['id'];

    public function __construct() {
        $this->description = new AttributeUnchanged();
        $this->value = new AttributeUnchanged();
        $this->barcode_slip = new AttributeUnchanged();
        $this->expiration = new AttributeUnchanged();
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
    public function getValue() {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return UpdateExpenseParam
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBarcodeSlip() {
        return $this->barcode_slip;
    }

    /**
     * @param mixed $barcode_slip
     * @return UpdateExpenseParam
     */
    public function setBarcodeSlip($barcode_slip) {
        $this->barcode_slip = $barcode_slip;
        return $this;
    }

    /**
     * @return \DateTime|AttributeUnchanged|string
     */
    public function getExpiration($asDate = false) {

        if($this->expiration instanceof AttributeUnchanged) {
            return $this->expiration;
        }

        if($asDate) {
            return $this->dateStringToDate($this->expiration);
        }
        return $this->expiration;
    }

    /**
     * @param mixed $expiration
     * @return UpdateExpenseParam
     */
    public function setExpiration($expiration) {
        $this->expiration = $expiration;
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