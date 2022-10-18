<?php

namespace App\Services\Internal\Budgets;

class UpdateBudgetParam {
    protected $description;

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return UpdateBudgetParam
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }
}