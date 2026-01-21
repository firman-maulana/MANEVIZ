<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\ViewEntry;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Order Information')
                    ->schema([
                        TextEntry::make('order_number')
                            ->label('Order Number')
                            ->copyable(),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'processing' => 'primary',
                                'shipped' => 'info',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                                default => 'secondary',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                                default => $state,
                            }),
                        TextEntry::make('payment_status')
                            ->label('Payment Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'paid' => 'success',
                                'failed' => 'danger',
                                default => 'secondary',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                                default => $state,
                            }),
                        TextEntry::make('order_date')
                            ->label('Order Date')
                            ->dateTime(),
                        TextEntry::make('shipped_date')
                            ->label('Shipped Date')
                            ->dateTime()
                            ->placeholder('Not shipped yet'),
                        TextEntry::make('delivered_date')
                            ->label('Delivered Date')
                            ->dateTime()
                            ->placeholder('Not delivered yet'),
                    ])
                    ->columns(2),

                Section::make('Shipping & Tracking')
                    ->schema([
                        TextEntry::make('courier_code')
                            ->label('Courier')
                            ->formatStateUsing(fn ($record) => $record->courier_label),
                        TextEntry::make('courier_service')
                            ->label('Service Type'),
                        TextEntry::make('waybill_number')
                            ->label('Waybill/Resi Number')
                            ->copyable()
                            ->placeholder('Not available yet')
                            ->columnSpanFull(),
                        TextEntry::make('last_tracking_update')
                            ->label('Last Tracking Update')
                            ->dateTime()
                            ->placeholder('Not synced yet')
                            ->visible(fn ($record) => !empty($record->waybill_number)),

                        ViewEntry::make('tracking_timeline')
                            ->label('Tracking History')
                            ->view('filament.infolists.tracking-timeline')
                            ->visible(fn ($record) => !empty($record->tracking_history))
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn ($record) => !empty($record->waybill_number))
                    ->collapsible(),

                Section::make('Customer Information')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Customer Name'),
                        TextEntry::make('user.email')
                            ->label('Customer Email'),
                        TextEntry::make('shipping_name')
                            ->label('Shipping Name'),
                        TextEntry::make('shipping_phone')
                            ->label('Shipping Phone'),
                        TextEntry::make('shipping_email')
                            ->label('Shipping Email'),
                        TextEntry::make('shipping_address')
                            ->label('Shipping Address')
                            ->columnSpanFull(),
                        TextEntry::make('shipping_city')
                            ->label('City'),
                        TextEntry::make('shipping_province')
                            ->label('Province'),
                        TextEntry::make('shipping_postal_code')
                            ->label('Postal Code'),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Section::make('Payment Information')
                    ->schema([
                        TextEntry::make('payment_method')
                            ->label('Payment Method')
                            ->formatStateUsing(function ($state) {
                                $methods = [
                                    'bank_transfer' => 'Bank Transfer',
                                    'credit_card' => 'Credit Card',
                                    'ewallet' => 'E-Wallet',
                                    'cod' => 'Cash on Delivery',
                                ];
                                return $methods[$state] ?? $state;
                            }),
                        TextEntry::make('transaction_id')
                            ->label('Transaction ID')
                            ->copyable()
                            ->placeholder('No transaction ID'),
                        TextEntry::make('total_amount')
                            ->label('Subtotal')
                            ->money('IDR'),
                        TextEntry::make('shipping_cost')
                            ->label('Shipping Cost')
                            ->money('IDR'),
                        TextEntry::make('grand_total')
                            ->label('Grand Total')
                            ->money('IDR')
                            ->weight('bold'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Order Items')
                    ->schema([
                        RepeatableEntry::make('orderItems')
                            ->label('')
                            ->schema([
                                TextEntry::make('product_name')
                                    ->label('Product'),
                                TextEntry::make('kuantitas')
                                    ->label('Quantity'),
                                TextEntry::make('product_price')
                                    ->label('Unit Price')
                                    ->money('IDR'),
                                TextEntry::make('subtotal')
                                    ->label('Subtotal')
                                    ->money('IDR'),
                                TextEntry::make('size')
                                    ->label('Size')
                                    ->placeholder('No size'),
                            ])
                            ->columns(5),
                    ]),

                Section::make('Notes')
                    ->schema([
                        TextEntry::make('notes')
                            ->label('Order Notes')
                            ->placeholder('No notes')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
