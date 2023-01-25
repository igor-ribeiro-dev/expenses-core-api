<?php

namespace App\Services\External;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ExpenseFeederService
{
    private const REQUEST_CHANNEL_NAME = 'expenses.request';
    private const RECEIVE_CHANNEL_NAME = 'expenses.receive';
    /**
     * @var array{host: string, port: int, user: string, password: string}
     */
    private mixed $config;
    private AMQPStreamConnection $connection;

    public function __construct($config = []) {

        if (!Arr::has($config, ['host', 'port', 'user', 'password'])) {
            throw new \RuntimeException('Invalid configuration for ExpenseFeeder');
        }

        $this->config = $config;
    }

    public function request($payload): void {

        $payload = $this->parsePayload($payload);

        $this->connect();

        $channel = $this->sendMessage($payload);

        $this->disconnect($channel);
    }

    public function receive(callable $callback): void {
        $this->connect();

        $channel = $this->connection->channel();

        $channel->basic_consume(self::RECEIVE_CHANNEL_NAME, '', false, true, false, false, function ($message) use ($callback) {
            $body = json_decode($message->body, true);

                if (!is_array($body)) {
                    return;
                }

                if(! Arr::has($body, [ 'expense_id', 'recurrence_id', 'value', 'barcode_slip',])) {
                    Log::error('Invalide message for queue {queue}', [
                        'queue' => self::RECEIVE_CHANNEL_NAME,
                        'body' => $message->body
                    ]);
                    return;
                }

                $expenseReceived = (new ExpenseReceivedDTO())
                    ->setExpenseId($body['expense_id'])
                    ->setRecurrenceId($body['recurrence_id'])
                    ->setValue($body['value'])
                    ->setBarcodeSlip($body['barcode_slip']);

                call_user_func($callback, $expenseReceived);
            }
        );

        while ($channel->is_open()) {
            $channel->wait();
            //Todo Implement some logic here to stop waiting forever...
        }

        // Technically never hits here...
        $this->disconnect($channel);
    }

    private function connect(): void {
        $this->connection = new AMQPStreamConnection(
            $this->config['host'],
            $this->config['port'],
            $this->config['user'],
            $this->config['password']
        );
    }

    private function disconnect(AMQPChannel $channel = null): void {
        $channel?->close();
        $this->connection->close();
    }

    public function __destruct() {
        if (isset($this->connection) && $this->connection->isConnected()) {
            $this->disconnect();
        }
    }

    private function sendMessage(string $message): AMQPChannel {

        $channel = $this->connection->channel();

        $channel->queue_declare(self::REQUEST_CHANNEL_NAME, false, false, false, false);

        $msg = new AMQPMessage($message);

        $channel->basic_publish($msg, '', self::REQUEST_CHANNEL_NAME);

        return $channel;
    }

    private function parsePayload($payload): string {
        $payload = is_string($payload) ? $payload : json_encode($payload);

        if (!is_string($payload)) {
            throw new \RuntimeException('Invalid request message');
        }

        return $payload;
    }
}