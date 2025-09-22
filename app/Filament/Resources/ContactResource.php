<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\ActionGroup;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Contact Messages';

    protected static ?string $modelLabel = 'Contact Message';

    protected static ?string $pluralModelLabel = 'Contact Messages';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Communications';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::unread()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $unreadCount = static::getModel()::unread()->count();
        return $unreadCount > 0 ? 'warning' : null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                    ]),

                Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('subject')
                            ->options(Contact::getSubjectOptions())
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\Select::make('status')
                            ->options(Contact::getStatusOptions())
                            ->default('new')
                            ->required()
                            ->columnSpan(1),
                    ]),

                Forms\Components\Textarea::make('message')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),

                Forms\Components\DateTimePicker::make('read_at')
                    ->label('Read At')
                    ->displayFormat('d/m/Y H:i')
                    ->columnSpan(1)
                    ->disabled(fn ($record) => !$record),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight(fn (Contact $record) => $record->isUnread() ? FontWeight::Bold : FontWeight::Normal)
                    ->description(fn (Contact $record) => $record->phone)
                    ->icon(fn (Contact $record) => $record->isUnread() ? 'heroicon-s-envelope' : 'heroicon-o-envelope-open'),

                Tables\Columns\TextColumn::make('subject')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => Contact::getSubjectOptions()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        'general' => 'gray',
                        'support' => 'warning',
                        'sales' => 'success',
                        'partnership' => 'info',
                        'other' => 'secondary',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => Contact::getStatusOptions()[$state] ?? $state)
                    ->color(fn (Contact $record) => $record->status_color)
                    ->sortable(),

                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->tooltip(function (Contact $record): string {
                        return $record->message;
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('read_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('Not read'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(Contact::getStatusOptions())
                    ->multiple(),

                SelectFilter::make('subject')
                    ->options(Contact::getSubjectOptions())
                    ->multiple(),

                Filter::make('unread')
                    ->query(fn (Builder $query): Builder => $query->unread())
                    ->toggle()
                    ->label('Show only unread'),

                Filter::make('today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today()))
                    ->toggle()
                    ->label('Today only'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('markAsRead')
                        ->icon('heroicon-o-envelope-open')
                        ->color('success')
                        ->action(function (Contact $record) {
                            $record->markAsRead();
                        })
                        ->visible(fn (Contact $record) => $record->isUnread()),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('markAsRead')
                        ->label('Mark as Read')
                        ->icon('heroicon-o-envelope-open')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->markAsRead();
                            });
                        }),
                    Tables\Actions\BulkAction::make('updateStatus')
                        ->label('Update Status')
                        ->icon('heroicon-o-arrow-path')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('New Status')
                                ->options(Contact::getStatusOptions())
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            $records->each(function ($record) use ($data) {
                                $record->update(['status' => $data['status']]);
                            });
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('10s') // Auto refresh every 10 seconds
            ->recordAction('view')
            ->recordUrl(null);
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}