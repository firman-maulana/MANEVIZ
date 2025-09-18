<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewProductNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $product;
    public $userName;

    /**
     * Create a new message instance.
     */
    public function __construct(Product $product, string $userName)
    {
        $this->product = $product;
        $this->userName = $userName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 Produk Baru Telah Tersedia: ' . $this->product->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new-product-notification',
            with: [
                'product' => $this->product,
                'userName' => $this->userName,
                'productUrl' => route('products.show', $this->product->slug),
                'allProductsUrl' => route('products.index'),
                'primaryImage' => $this->product->primaryImage?->image_path 
                    ? asset('storage/' . $this->product->primaryImage->image_path) 
                    : null,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}