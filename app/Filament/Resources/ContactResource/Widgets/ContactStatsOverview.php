<?php

// app/Filament/Resources/ContactResource/Widgets/ContactStatsOverview.php

namespace App\Filament\Resources\ContactResource\Widgets;

use App\Models\Contact;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContactStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalContacts = Contact::count();
        $unreadContacts = Contact::unread()->count();
        $todayContacts = Contact::whereDate('created_at', today())->count();
        $newContacts = Contact::byStatus('new')->count();
        $inProgressContacts = Contact::byStatus('in_progress')->count();
        $resolvedContacts = Contact::byStatus('resolved')->count();

        // Calculate percentage changes (comparing with previous day/week)
        $yesterdayContacts = Contact::whereDate('created_at', today()->subDay())->count();
        $weeklyChange = $todayContacts - $yesterdayContacts;
        
        return [
            Stat::make('Total Messages', $totalContacts)
                ->description('All contact messages')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('primary'),

            Stat::make('Unread Messages', $unreadContacts)
                ->description('Requires attention')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($unreadContacts > 0 ? 'warning' : 'success'),

            Stat::make('Today\'s Messages', $todayContacts)
                ->description($weeklyChange >= 0 ? "+{$weeklyChange} from yesterday" : "{$weeklyChange} from yesterday")
                ->descriptionIcon($weeklyChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($weeklyChange >= 0 ? 'success' : 'danger'),

            Stat::make('New Status', $newContacts)
                ->description('Awaiting first response')
                ->descriptionIcon('heroicon-m-plus-circle')
                ->color('info'),

            Stat::make('In Progress', $inProgressContacts)
                ->description('Being handled')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Resolved', $resolvedContacts)
                ->description('Successfully handled')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }

    protected function getPollingInterval(): ?string
    {
        return '15s'; // Refresh every 15 seconds
    }
}