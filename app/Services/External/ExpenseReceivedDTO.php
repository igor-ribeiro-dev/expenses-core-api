<?php

namespace App\Services\External;

class ExpenseReceivedDTO
{
    protected int $expense_id;
    protected int $recurrence_id;
    protected float $value;
    protected string $barcode_slip;

    /**
     * @return int
     */
    public function getExpenseId(): int {
        return $this->expense_id;
    }

    /**
     * @param int $expense_id
     * @return ExpenseReceivedDTO
     */
    public function setExpenseId(int $expense_id): ExpenseReceivedDTO {
        $this->expense_id = $expense_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getRecurrenceId(): int {
        return $this->recurrence_id;
    }

    /**
     * @param int $recurrence_id
     * @return ExpenseReceivedDTO
     */
    public function setRecurrenceId(int $recurrence_id): ExpenseReceivedDTO {
        $this->recurrence_id = $recurrence_id;
        return $this;
    }

    /**
     * @return float
     */
    public function getValue(): float {
        return $this->value;
    }

    /**
     * @param float $value
     * @return ExpenseReceivedDTO
     */
    public function setValue(float $value): ExpenseReceivedDTO {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getBarcodeSlip(): string {
        return $this->barcode_slip;
    }

    /**
     * @param string $barcode_slip
     * @return ExpenseReceivedDTO
     */
    public function setBarcodeSlip(string $barcode_slip): ExpenseReceivedDTO {
        $this->barcode_slip = $barcode_slip;
        return $this;
    }
}