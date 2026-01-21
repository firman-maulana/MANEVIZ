<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Services\WaybillTrackingService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Orders Management';

    protected static ?string $modelLabel = 'Order';

    protected static ?string $pluralModelLabel = 'Orders';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Information')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('Order Number')
                            ->disabled()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('status')
                            ->label('Order Status')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'shipped') {
                                    $set('shipped_date', now());
                                } elseif ($state === 'delivered') {
                                    $set('delivered_date', now());
                                    $set('shipped_date', now());
                                }
                            }),

                        Forms\Components\Select::make('payment_status')
                            ->label('Payment Status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                            ])
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Shipping & Tracking')
                    ->schema([
                        Forms\Components\TextInput::make('courier_code')
                            ->label('Courier Code')
                            ->disabled(),

                        Forms\Components\TextInput::make('courier_service')
                            ->label('Courier Service')
                            ->disabled(),

                        Forms\Components\TextInput::make('waybill_number')
                            ->label('Waybill/Resi Number')
                            ->helperText('Enter tracking number when order is shipped')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Placeholder::make('tracking_info')
                            ->label('Tracking Status')
                            ->content(function ($record) {
                                if (!$record || !$record->waybill_number) {
                                    return 'No tracking information available';
                                }

                                if ($record->last_tracking_update) {
                                    $latest = $record->latest_tracking_status;
                                    if ($latest) {
                                        return sprintf(
                                            "%s - %s\nLast updated: %s",
                                            $latest['location'] ?? 'Unknown',
                                            $latest['description'] ?? 'No description',
                                            $record->last_tracking_update->format('d M Y H:i')
                                        );
                                    }
                                }

                                return 'Tracking information not yet synced';
                            })
                            ->visible(fn($record) => $record && $record->waybill_number)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Customer Information')
                    ->schema([
                        Forms\Components\TextInput::make('user.name')
                            ->label('Customer Name')
                            ->disabled(),

                        Forms\Components\TextInput::make('user.email')
                            ->label('Customer Email')
                            ->disabled(),

                        Forms\Components\TextInput::make('shipping_name')
                            ->label('Shipping Name')
                            ->disabled(),

                        Forms\Components\Textarea::make('shipping_address')
                            ->label('Shipping Address')
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Order Details')
                    ->schema([
                        Forms\Components\TextInput::make('total_amount')
                            ->label('Subtotal')
                            ->disabled()
                            ->prefix('IDR')
                            ->formatStateUsing(fn($state) => number_format($state, 0, ',', '.')),

                        Forms\Components\TextInput::make('shipping_cost')
                            ->label('Shipping Cost')
                            ->disabled()
                            ->prefix('IDR')
                            ->formatStateUsing(fn($state) => number_format($state, 0, ',', '.')),

                        Forms\Components\TextInput::make('grand_total')
                            ->label('Grand Total')
                            ->disabled()
                            ->prefix('IDR')
                            ->formatStateUsing(fn($state) => number_format($state, 0, ',', '.')),

                        Forms\Components\TextInput::make('payment_method')
                            ->label('Payment Method')
                            ->disabled()
                            ->formatStateUsing(function ($state) {
                                $methods = [
                                    'bank_transfer' => 'Bank Transfer',
                                    'credit_card' => 'Credit Card',
                                    'ewallet' => 'E-Wallet',
                                    'cod' => 'Cash on Delivery (COD)',
                                ];
                                return $methods[$state] ?? $state;
                            }),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Tracking Information')
                    ->schema([
                        Forms\Components\DateTimePicker::make('order_date')
                            ->label('Order Date')
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('shipped_date')
                            ->label('Shipped Date')
                            ->helperText('Automatically filled when status is set to shipped'),

                        Forms\Components\DateTimePicker::make('delivered_date')
                            ->label('Delivered Date')
                            ->helperText('Automatically filled when status is set to delivered'),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Forms\Components\Section::make('Notes')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Order Notes')
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Order Number')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Order number copied')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'processing',
                        'info' => 'shipped',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                        default => $state,
                    }),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('Payment')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('waybill_number')
                    ->label('Resi')
                    ->searchable()
                    ->copyable()
                    ->placeholder('No resi')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('order_date')
                    ->label('Order Date')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('orderItems_count')
                    ->label('Items')
                    ->counts('orderItems')
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('has_tracking')
                    ->label('Tracking')
                    ->boolean()
                    ->getStateUsing(fn($record) => !empty($record->waybill_number))
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Order Status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ]),

                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Payment Status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                    ]),

                Tables\Filters\Filter::make('has_waybill')
                    ->label('Has Tracking')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('waybill_number')),

                Tables\Filters\Filter::make('no_waybill')
                    ->label('No Tracking')
                    ->query(fn(Builder $query): Builder => $query->whereNull('waybill_number')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('addWaybill')
                    ->label('Add Resi')
                    ->icon('heroicon-o-truck')
                    ->color('success')
                    ->visible(fn(Order $record): bool => empty($record->waybill_number) && $record->status === 'processing')
                    ->form([
                        Forms\Components\TextInput::make('waybill_number')
                            ->label('Waybill/Resi Number')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Toggle::make('mark_as_shipped')
                            ->label('Mark order as shipped')
                            ->default(true)
                            ->helperText('Automatically change order status to shipped'),
                    ])
                    ->action(function (array $data, Order $record): void {
                        $updates = ['waybill_number' => $data['waybill_number']];

                        if ($data['mark_as_shipped']) {
                            $updates['status'] = 'shipped';
                            $updates['shipped_date'] = now();
                        }

                        $record->update($updates);

                        Notification::make()
                            ->title('Waybill Added')
                            ->body("Tracking number {$data['waybill_number']} has been added to order {$record->order_number}")
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('trackWaybill')
                    ->label('Track')
                    ->icon('heroicon-o-map-pin')
                    ->color('info')
                    ->visible(fn(Order $record): bool => !empty($record->waybill_number))
                    ->action(function (Order $record): void {
                        // Untuk demo/tugas: Generate dummy tracking jika belum ada
                        if (!$record->tracking_history) {
                            $dummyTracking = $this->generateDummyTrackingData($record);

                            $record->update([
                                'tracking_history' => $dummyTracking,
                                'last_tracking_update' => now(),
                            ]);

                            Notification::make()
                                ->title('Tracking Generated')
                                ->body('Dummy tracking data has been created for demo purposes')
                                ->success()
                                ->send();

                            return;
                        }

                        // Jika sudah ada tracking, update timestamp saja
                        $record->update([
                            'last_tracking_update' => now(),
                        ]);

                        Notification::make()
                            ->title('Tracking Updated')
                            ->body('Latest tracking information has been refreshed')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('viewTracking')
                    ->label('View Tracking')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->visible(fn(Order $record): bool => !empty($record->waybill_number) && !empty($record->tracking_history))
                    ->modalHeading(fn(Order $record): string => "Tracking: {$record->waybill_number}")
                    ->modalContent(fn(Order $record) => view('filament.tracking-modal', ['order' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('syncTracking')
                        ->label('Sync Tracking')
                        ->icon('heroicon-o-arrow-path')
                        ->color('info')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $trackingService = app(WaybillTrackingService::class);
                            $success = 0;
                            $failed = 0;

                            foreach ($records as $record) {
                                if (empty($record->waybill_number)) {
                                    $failed++;
                                    continue;
                                }

                                $result = $trackingService->trackWaybill($record->waybill_number, $record->courier_code);

                                if ($result['success']) {
                                    $record->update([
                                        'tracking_history' => $result['data']['history'],
                                        'last_tracking_update' => now(),
                                    ]);

                                    if ($trackingService->isDelivered($result['data']) && $record->status !== 'delivered') {
                                        $record->update([
                                            'status' => 'delivered',
                                            'delivered_date' => now(),
                                        ]);
                                    }

                                    $success++;
                                } else {
                                    $failed++;
                                }
                            }

                            Notification::make()
                                ->title('Bulk Tracking Sync Complete')
                                ->body("Success: {$success}, Failed: {$failed}")
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('order_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user', 'orderItems.product'])
            ->withCount('orderItems');
    }

    /**
     * Generate dummy tracking data for demo purposes
     */
    protected static function generateDummyTrackingData($order): array
    {
        $baseDate = $order->shipped_date ?? $order->order_date ?? now();
        $status = $order->status;

        $tracking = [];

        // Jika delivered
        if ($status === 'delivered') {
            $tracking[] = [
                'date' => $order->delivered_date ? $order->delivered_date->format('Y-m-d') : now()->format('Y-m-d'),
                'time' => $order->delivered_date ? $order->delivered_date->format('H:i') : now()->format('H:i'),
                'description' => 'Paket telah diterima oleh ' . strtoupper($order->shipping_name ?? 'CUSTOMER'),
                'location' => strtoupper($order->shipping_city ?? 'MALANG')
            ];

            $tracking[] = [
                'date' => now()->subHours(2)->format('Y-m-d'),
                'time' => now()->subHours(2)->format('H:i'),
                'description' => 'Paket sedang dalam proses pengiriman ke alamat tujuan',
                'location' => strtoupper($order->shipping_city ?? 'MALANG')
            ];
        } elseif ($status === 'shipped') {
            $tracking[] = [
                'date' => now()->format('Y-m-d'),
                'time' => now()->format('H:i'),
                'description' => 'Paket sedang dalam proses pengiriman ke alamat tujuan',
                'location' => strtoupper($order->shipping_city ?? 'MALANG')
            ];
        }

        $tracking[] = [
            'date' => $baseDate->copy()->addHours(12)->format('Y-m-d'),
            'time' => '08:00',
            'description' => 'Paket telah berangkat dari sorting center menuju kota tujuan',
            'location' => 'SURABAYA'
        ];

        $tracking[] = [
            'date' => $baseDate->copy()->addHours(8)->format('Y-m-d'),
            'time' => '20:00',
            'description' => 'Paket telah tiba di sorting center dan sedang dalam proses sortir',
            'location' => 'SURABAYA'
        ];

        $tracking[] = [
            'date' => $baseDate->copy()->addHours(3)->format('Y-m-d'),
            'time' => $baseDate->copy()->addHours(3)->format('H:i'),
            'description' => 'Paket dalam perjalanan menuju sorting center',
            'location' => 'MALANG'
        ];

        $tracking[] = [
            'date' => $baseDate->format('Y-m-d'),
            'time' => $baseDate->format('H:i'),
            'description' => 'Paket telah diterima oleh kurir dan siap dikirim',
            'location' => 'MALANG'
        ];

        return $tracking;
    }
}
