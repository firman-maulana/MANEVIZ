<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InspirationalOutfitResource\Pages;
use App\Models\InspirationalOutfit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InspirationalOutfitResource extends Resource
{
    protected static ?string $model = InspirationalOutfit::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'User Interface';

    protected static ?string $navigationLabel = 'Inspirational Outfits';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Outfit Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('Title')
                            ->placeholder('e.g., "Dare To Win" For The Dedicated Individuals')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('image_path')
                            ->required()
                            ->image()
                            ->directory('inspirational-outfits')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(5120)
                            ->label('Outfit Image')
                            ->helperText('Upload an image for the outfit. Max size: 5MB')
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('date')
                            ->required()
                            ->label('Display Date')
                            ->default(now())
                            ->displayFormat('F j, Y')
                            ->native(false),

                        Forms\Components\Select::make('position')
                            ->required()
                            ->options([
                                'left' => 'Left (Image on Left, Text on Right)',
                                'right' => 'Right (Text on Left, Image on Right)',
                            ])
                            ->default('left')
                            ->label('Layout Position')
                            ->helperText('Choose the layout direction for this outfit card'),

                        Forms\Components\TextInput::make('order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->label('Display Order')
                            ->helperText('Lower numbers appear first'),

                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->label('Active')
                            ->helperText('Only active outfits will be displayed on the website'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image')
                    ->circular()
                    ->size(60),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->label('Title'),

                Tables\Columns\TextColumn::make('date')
                    ->date('F j, Y')
                    ->sortable()
                    ->label('Date'),

                Tables\Columns\BadgeColumn::make('position')
                    ->colors([
                        'primary' => 'left',
                        'success' => 'right',
                    ])
                    ->label('Position'),

                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->label('Order'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('position')
                    ->options([
                        'left' => 'Left',
                        'right' => 'Right',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All outfits')
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInspirationalOutfits::route('/'),
            'create' => Pages\CreateInspirationalOutfit::route('/create'),
            'edit' => Pages\EditInspirationalOutfit::route('/{record}/edit'),
        ];
    }
}
