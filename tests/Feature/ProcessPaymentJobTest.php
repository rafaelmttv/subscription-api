<?php

namespace Tests\Unit\Jobs;

use Tests\TestCase;
use App\Jobs\ProcessPaymentJob;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcessPaymentJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_is_processed_successfully()
    {
        $order = Order::factory()->create([
            'status' => OrderStatus::PENDING,
        ]);

        $job = $this->partialMock(ProcessPaymentJob::class, function ($mock) {
            $mock->shouldReceive('paymentApproved')
                ->once()
                ->andReturn(true);
        });

        $job->__construct($order);
        $job->handle();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => OrderStatus::PAID,
        ]);
    }


    public function test_payment_fails_and_order_remains_pending()
    {
        $order = Order::factory()->create([
            'status' => OrderStatus::PENDING,
        ]);

        $job = $this->partialMock(ProcessPaymentJob::class, function ($mock) {
            $mock->shouldReceive('paymentApproved')
                ->once()
                ->andReturn(false);
        });

        $job->__construct($order);

        $this->expectException(\RuntimeException::class);

        $job->handle();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => OrderStatus::PENDING,
        ]);
    }


    public function test_job_retry_and_backoff_configuration()
    {
        $job = new ProcessPaymentJob(
            Order::factory()->create()
        );

        $this->assertSame(3, $job->tries);
        $this->assertSame([5, 15, 30], $job->backoff());
    }

}

