<?php

namespace App\Console\Commands;

use App\Models\ExpenseRecurrence;
use App\Services\External\ExpenseFeederService;
use App\Services\External\ExpenseReceivedDTO;
use Illuminate\Console\Command;

class ReceiveRecurringExpensesFromFeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expense:receive-feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Receives expense data from Expense Feeder service.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ExpenseFeederService $service)
    {
        $service->receive(function (ExpenseReceivedDTO $expenseReceived) {

            $recurrence = ExpenseRecurrence::query()->find($expenseReceived->getRecurrenceId());
            $recurrence->fill([
                'value' => $expenseReceived->getValue(),
                'barcode_slip' => $expenseReceived->getBarcodeSlip(),
            ])->save();
        });

        return Command::SUCCESS;
    }
}
