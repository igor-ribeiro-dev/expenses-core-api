<?php

namespace App\Console\Commands;

use App\Services\External\ExpenseFeederService;
use App\Services\Internal\Expenses\ListPendingExpensesProviderDataService;
use Illuminate\Console\Command;

class SendRecurringExpensesToFeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expense:request-feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send recurring expenses to feeder service.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ExpenseFeederService $expenseFeeder, ListPendingExpensesProviderDataService $service)
    {

        foreach ($service->run() as $item) {
            $expenseFeeder->request($item);
        }

        return Command::SUCCESS;
    }
}
