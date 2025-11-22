<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HowToOrderStepResource\Pages;
use App\Models\HowToOrderStep;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HowToOrderStepResource extends Resource
{
    protected static ?string $model = HowToOrderStep::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'How To Order';

    protected static ?string $navigationGroup = 'User Interface';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Settings')
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->label('Step Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->helperText('Urutan tampilan step (semakin kecil muncul lebih dulu)')
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Aktifkan atau nonaktifkan step ini')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\Textarea::make('content_id')
                            ->label('Konten Indonesia')
                            ->required()
                            ->rows(4)
                            ->helperText('Tulis konten dalam Bahasa Indonesia')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('content_en')
                            ->label('English Content')
                            ->required()
                            ->rows(4)
                            ->helperText('Write content in English')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('Order')
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('content_id')
                    ->label('Konten Indonesia')
                    ->limit(80)
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('content_en')
                    ->label('English Content')
                    ->limit(80)
                    ->searchable()
                    ->wrap(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order');
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
            'index' => Pages\ListHowToOrderSteps::route('/'),
            'create' => Pages\CreateHowToOrderStep::route('/create'),
            'edit' => Pages\EditHowToOrderStep::route('/{record}/edit'),
        ];
    }
}
