<?php

// app/Filament/Resources/ContactResource/Pages/ListContacts.php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use App\Models\Contact;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;


class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Messages')
                ->badge(Contact::count()),
            
            'unread' => Tab::make('Unread')
                ->modifyQueryUsing(fn (Builder $query) => $query->unread())
                ->badge(Contact::unread()->count())
                ->badgeColor('warning'),
            
            'new' => Tab::make('New')
                ->modifyQueryUsing(fn (Builder $query) => $query->byStatus('new'))
                ->badge(Contact::byStatus('new')->count())
                ->badgeColor('primary'),
            
            'in_progress' => Tab::make('In Progress')
                ->modifyQueryUsing(fn (Builder $query) => $query->byStatus('in_progress'))
                ->badge(Contact::byStatus('in_progress')->count())
                ->badgeColor('warning'),
            
            'resolved' => Tab::make('Resolved')
                ->modifyQueryUsing(fn (Builder $query) => $query->byStatus('resolved'))
                ->badge(Contact::byStatus('resolved')->count())
                ->badgeColor('success'),
            
            'closed' => Tab::make('Closed')
                ->modifyQueryUsing(fn (Builder $query) => $query->byStatus('closed'))
                ->badge(Contact::byStatus('closed')->count())
                ->badgeColor('gray'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ContactResource\Widgets\ContactStatsOverview::class,
        ];
    }
}