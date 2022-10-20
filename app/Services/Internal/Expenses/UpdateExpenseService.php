<?php

namespace App\Services\Internal\Expenses;

use App\Models\Expenses;
use App\Services\Internal\Utils\AttributeUnchanged;
use InvalidArgumentException;

class UpdateExpenseService {
    public function run(UpdateExpenseParam $expenseParam) {

        if( ! is_numeric($expenseParam->getId())) {
            throw new InvalidArgumentException('Expense not informed.');
        }

        $dataToUpdate = $this->removeUnchangedValues([
            'description' => $expenseParam->getDescription(),
            'value' => $expenseParam->getValue(),
            'barcode_slip' => $expenseParam->getBarcodeSlip(),
            'expiration' => $expenseParam->getExpiration(true),
            'recurrent' => $expenseParam->getRecurrent(),
        ]);

        Expenses::query()->whereKey($expenseParam->getId())->update($dataToUpdate);
    }

    private function removeUnchangedValues(array $dataToUpdate): array {
        return array_filter($dataToUpdate, fn($value) => ! ($value instanceof AttributeUnchanged));
    }
}