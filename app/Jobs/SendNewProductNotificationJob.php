<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\Users;
use App\Mail\NewProductNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendNewProductNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;
    public $timeout = 120; // 2 minutes timeout
    public $tries = 3; // retry 3 times if failed

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Ambil semua user aktif dengan role customer
            $users = Users::active()
                ->where('role', 'customer')
                ->whereNotNull('email')
                ->chunk(50, function ($userChunk) {
                    foreach ($userChunk as $user) {
                        try {
                            Mail::to($user->email)->send(
                                new NewProductNotification($this->product, $user->name)
                            );
                            
                            // Log successful email
                            Log::info("New product email sent to: {$user->email} for product: {$this->product->name}");
                            
                            // Small delay to prevent overwhelming mail server
                            usleep(100000); // 0.1 second delay
                            
                        } catch (\Exception $e) {
                            // Log individual email failures but continue with others
                            Log::error("Failed to send new product email to {$user->email}: " . $e->getMessage());
                        }
                    }
                });
                
            Log::info("New product notification job completed for product: {$this->product->name}");
            
        } catch (\Exception $e) {
            Log::error("New product notification job failed: " . $e->getMessage());
            throw $e; // Re-throw to trigger retry mechanism
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("New product notification job permanently failed for product {$this->product->name}: " . $exception->getMessage());
    }
}