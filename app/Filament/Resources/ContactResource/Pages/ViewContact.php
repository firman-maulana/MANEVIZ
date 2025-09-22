<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use App\Models\Contact;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Support\Enums\FontWeight;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('markAsRead')
                ->label('Mark as Read')
                ->icon('heroicon-o-envelope-open')
                ->color('success')
                ->action(function (Contact $record) {
                    $record->markAsRead();
                    $this->refreshFormData(['read_at']);
                })
                ->visible(fn (Contact $record) => $record->isUnread()),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Contact Information')
                    ->schema([
                        TextEntry::make('name')
                            ->weight(FontWeight::Bold)
                            ->icon('heroicon-o-user'),
                        
                        TextEntry::make('phone')
                            ->icon('heroicon-o-phone')
                            ->copyable(),
                        
                        TextEntry::make('subject')
                            ->formatStateUsing(fn (string $state) => Contact::getSubjectOptions()[$state] ?? $state)
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'general' => 'gray',
                                'support' => 'warning',
                                'sales' => 'success',
                                'partnership' => 'info',
                                'other' => 'secondary',
                                default => 'gray',
                            }),
                        
                        TextEntry::make('status')
                            ->formatStateUsing(fn (string $state) => Contact::getStatusOptions()[$state] ?? $state)
                            ->badge()
                            ->color(fn (Contact $record) => $record->status_color),
                    ])
                    ->columns(2),
                
                Section::make('Message')
                    ->schema([
                        TextEntry::make('message')
                            ->prose()
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime('d M Y, H:i')
                            ->icon('heroicon-o-calendar'),
                        
                        TextEntry::make('read_at')
                            ->dateTime('d M Y, H:i')
                            ->placeholder('Not read yet')
                            ->icon('heroicon-o-envelope-open'),
                        
                        TextEntry::make('updated_at')
                            ->dateTime('d M Y, H:i')
                            ->icon('heroicon-o-arrow-path'),
                    ])
                    ->columns(3),
            ]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Mark as read when viewing
        if ($this->record->isUnread()) {
            $this->record->markAsRead();
        }

        return $data;
    }
}