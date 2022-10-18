<?php

namespace App\Services\Internal\Budgets;

class StoreBudgetParam {

    protected $description;
    protected $owner;

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return StoreBudgetParam
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOwner() {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     * @return StoreBudgetParam
     */
    public function setOwner($owner) {
        $this->owner = $owner;
        return $this;
    }
}