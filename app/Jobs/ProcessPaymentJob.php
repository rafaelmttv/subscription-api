<?php

namespace App\Jobs;

use App\Models\Order;
use App\Enums\OrderStatus;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 30;

    public function __construct(
        protected Order $order
    ) {}

    public function backoff(): array
    {
        return [5, 15, 30];
    }

    public function handle(): void
    {
        Log::info('Processing payment', [
            'order_id' => $this->order->id,
            'amount' => $this->order->amount,
        ]);

        // Aqui estou simulando uma falha aleatória.
        if (! $this->paymentApproved()) {
            throw new \RuntimeException('Falha simulada');
        }

        $this->order->update([
            'status' => OrderStatus::PAID,
        ]);

        Log::info('Payment successful', [
            'order_id' => $this->order->id,
        ]);
    }

    public function failed(Throwable $exception): void
    {
        $this->order->update([
            'status' => OrderStatus::CANCELLED,
        ]);

        Log::error('Payment permanently failed', [
            'order_id' => $this->order->id,
            'error' => $exception->getMessage(),
        ]);
    }

    public function paymentApproved(): bool
    {
        return random_int(1, 10) > 3;
    }

}
