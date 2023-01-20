<?php

namespace App\Services\Internal\Expenses;

class StoreExpensesParam {

    use DateStringConverter;

    protected $description;
    protected $value;
    protected $barcode_slip;
    protected $expiration;
    protected $recurrent;
    protected $created_by;
    protected $budget_id;
    protected $paid;

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return StoreExpensesParam
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
     * @return StoreExpensesParam
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
     * @return StoreExpensesParam
     */
    public function setBarcodeSlip($barcode_slip) {
        $this->barcode_slip = $barcode_slip;
        return $this;
    }

    /**
     * @return \DateTime|false|string
     */
    public function getExpiration($asDate = false) {
        if($asDate) {
            return $this->dateStringToDate($this->expiration);
        }
        return $this->expiration;
    }

    /**
     * @param mixed $expiration
     * @return StoreExpensesParam
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
     * @return StoreExpensesParam
     */
    public function setRecurrent($recurrent) {
        $this->recurrent = $recurrent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy() {
        return $this->created_by;
    }

    /**
     * @param mixed $created_by
     * @return StoreExpensesParam
     */
    public function setCreatedBy($created_by) {
        $this->created_by = $created_by;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBudgetId() {
        return $this->budget_id;
    }

    /**
     * @param mixed $budget_id
     * @return StoreExpensesParam
     */
    public function setBudgetId($budget_id) {
        $this->budget_id = $budget_id;
        return $this;
    }

    /**
     * @return bool
     */
    public function getPaid(): bool {
        return $this->paid ?? false;
    }

    /**
     * @param mixed $paid
     * @return StoreExpensesParam
     */
    public function setPaid(bool $paid) {
        $this->paid = $paid;
        return $this;
    }

}