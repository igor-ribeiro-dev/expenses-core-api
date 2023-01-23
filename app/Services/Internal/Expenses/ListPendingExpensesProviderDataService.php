<?php

namespace App\Services\Internal\Expenses;


use Illuminate\Support\Facades\DB;

class ListPendingExpensesProviderDataService {

    public function run() {
       $query = <<<QUERY
                SELECT ex.id      AS expense_id,
                       exr.id     AS recurrence_id,
                       bp.tag     AS provider_tag,
                       bpc.config AS provider_config
                FROM expenses ex
                         INNER JOIN billing_providers_configs bpc ON ex.provider_config_id = bpc.id
                         INNER JOIN billing_providers bp ON bpc.billing_provider_id = bp.id
                         INNER JOIN (SELECT MAX(id) AS id,
                                            er.expense_id
                                     FROM expense_recurrences er
                                     WHERE er.expiration = ?
                                       AND er.barcode_slip IS NULL
                                       AND er.value IS NULL
                                       AND er.paid = 0
                                     GROUP BY er.expense_id) exr ON exr.expense_id = ex.id
                WHERE ex.recurrent = ?
       QUERY;
       $binds = [now()->toDateString(), 1];

        return collect(DB::select($query, $binds))
            ->map(function ($item) {
               $item->provider_config = json_decode($item->provider_config);
               return $item;
            });
    }
}