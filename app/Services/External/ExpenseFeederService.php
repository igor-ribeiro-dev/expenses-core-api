<?php

namespace App\Services\External;

use Illuminate\Support\Arr;
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

        if( ! Arr::has($config, ['host', 'port', 'user', 'password'])) {
            throw new \RuntimeException('Invalid configuration for ExpenseFeeder');
        }

        $this->config = $config;
    }

    public function request($payload): void {

        $payload = $this->parsePayload($payload);

        $this->connect();

        $this->sendMessage($payload);

        $this->disconnect();
    }

    public function receive() {
        $this->connect();
        // Implementation goes here...
        $this->disconnect();
    }

    private function connect(): void {
        $this->connection = new AMQPStreamConnection(
            $this->config['host'],
            $this->config['port'],
            $this->config['user'],
            $this->config['password']
        );
    }

    private function disconnect(): void {
        $this->connection->close();
    }

    public function __destruct() {
        if(isset($this->connection) && $this->connection->isConnected()) {
            $this->disconnect();
        }
    }

    private function sendMessage(string $message): void {

        $channel = $this->connection->channel();

        $channel->queue_declare(self::REQUEST_CHANNEL_NAME, false, true, false, false);

        $msg = new AMQPMessage($message);

        $channel->basic_publish($msg, '', self::REQUEST_CHANNEL_NAME);
    }

    private function parsePayload($payload): string {
        $payload = is_string($payload) ? $payload : json_encode($payload);

        if( ! is_string($payload)) {
            throw new \RuntimeException('Invalid request message');
        }

        return $payload;
    }
}