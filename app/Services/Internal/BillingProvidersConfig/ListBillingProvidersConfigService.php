<?php

namespace App\Services\Internal\BillingProvidersConfig;

use App\Models\BillingProvidersConfig;
use Illuminate\Support\Collection;

class ListBillingProvidersConfigService
{

    public function execute(int $ownerId): Collection
    {
        return BillingProvidersConfig::query()
            ->where('created_by', $ownerId)
            ->with('provider')
            ->get();
    }

}
