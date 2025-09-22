<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentConfirmationResource\Pages;
use App\Models\PaymentConfirmation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;

class PaymentConfirmationResource extends Resource
{
    protected static ?string $model = PaymentConfirmation::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Payment Confirmations';

    protected static ?string $modelLabel = 'Payment Confirmation';

    protected static ?string $pluralModelLabel = 'Payment Confirmations';

    protected static ?string $navigationGroup = 'Communications';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Customer Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Payment Details')
                    ->schema([
                        Forms\Components\TextInput::make('order_id')
                            ->label('Order ID')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('total_transfer')
                            ->label('Total Transfer')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->formatStateUsing(fn ($state) => $state ? number_format($state, 0, ',', '.') : '')
                            ->columnSpan(1),
                        Forms\Components\Select::make('transfer_to')
                            ->label('Transfer To')
                            ->required()
                            ->options([
                                'bca-449-008-1777' => 'BCA 449-008-1777 a/n Anggullo Agrisbo',
                                'mandiri' => 'Bank Mandiri',
                                'bni' => 'Bank BNI',
                                'bri' => 'Bank BRI',
                            ])
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('account_holder')
                            ->label('Bank Account Holder')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        Forms\Components\Textarea::make('notes')
                            ->label('Customer Notes')
                            ->maxLength(1000)
                            ->rows(3)
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Admin Actions')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->required()
                            ->options([
                                'pending' => 'Pending',
                                'verified' => 'Verified',
                                'rejected' => 'Rejected',
                            ])
                            ->default('pending')
                            ->reactive()
                            ->columnSpan(1),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Admin Notes')
                            ->helperText('Internal notes for this payment confirmation')
                            ->maxLength(1000)
                            ->rows(3)
                            ->columnSpan(2),
                    ])
                    ->columns(2)
                    ->visibleOn(['edit', 'view']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->label('Order ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('total_transfer')
                    ->label('Amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bank_name')
                    ->label('Bank')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'verified',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn ($state) => Str::title($state)),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('verified_at')
                    ->label('Verified')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('Not verified'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Submitted from'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Submitted until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('verify')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (PaymentConfirmation $record) => $record->status === 'pending')
                    ->action(function (PaymentConfirmation $record) {
                        $record->update([
                            'status' => 'verified',
                            'verified_at' => now(),
                            'verified_by' => Auth::check() ? Auth::id() : null,
                        ]);
                    }),
                Tables\Actions\Action::make('reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (PaymentConfirmation $record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Rejection Reason')
                            ->required()
                            ->maxLength(1000),
                    ])
                    ->action(function (PaymentConfirmation $record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'admin_notes' => $data['admin_notes'],
                            'verified_at' => now(),
                            'verified_by' => Auth::check() ? Auth::id() : null,
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('verify_selected')
                        ->label('Verify Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                if ($record->status === 'pending') {
                                    $record->update([
                                        'status' => 'verified',
                                        'verified_at' => now(),
                                        'verified_by' => Auth::check() ? Auth::id() : null,
                                    ]);
                                }
                            }
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Customer Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->icon('heroicon-o-user'),
                        Infolists\Components\TextEntry::make('email')
                            ->icon('heroicon-o-envelope')
                            ->copyable(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Payment Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('order_id')
                            ->label('Order ID')
                            ->icon('heroicon-o-hashtag')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('total_transfer')
                            ->label('Total Transfer')
                            ->money('IDR')
                            ->icon('heroicon-o-banknotes'),
                        Infolists\Components\TextEntry::make('bank_name')
                            ->label('Transfer To')
                            ->icon('heroicon-o-building-library'),
                        Infolists\Components\TextEntry::make('account_holder')
                            ->label('Account Holder')
                            ->icon('heroicon-o-identification'),
                        Infolists\Components\TextEntry::make('notes')
                            ->label('Customer Notes')
                            ->columnSpanFull()
                            ->placeholder('No notes provided'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Status & Verification')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn ($record) => $record->status_color),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Submitted At')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('verified_at')
                            ->label('Verified At')
                            ->dateTime()
                            ->placeholder('Not verified yet'),
                        Infolists\Components\TextEntry::make('verifiedBy.name')
                            ->label('Verified By')
                            ->placeholder('Not verified yet'),
                        Infolists\Components\TextEntry::make('admin_notes')
                            ->label('Admin Notes')
                            ->columnSpanFull()
                            ->placeholder('No admin notes'),
                    ])
                    ->columns(2),
            ]);
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
            'index' => Pages\ListPaymentConfirmations::route('/'),
            'create' => Pages\CreatePaymentConfirmation::route('/create'),
            'view' => Pages\ViewPaymentConfirmation::route('/{record}'),
            'edit' => Pages\EditPaymentConfirmation::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        $pendingCount = static::getModel()::where('status', 'pending')->count();
        return $pendingCount > 0 ? 'warning' : null;
    }
}