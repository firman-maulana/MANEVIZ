<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeaturedItemResource\Pages;
use App\Models\FeaturedItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FeaturedItemResource extends Resource
{
    protected static ?string $model = FeaturedItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'User Interface';

    protected static ?string $navigationLabel = 'Featured Items';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Featured Item Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->maxLength(255)
                            ->label('Title (Optional)')
                            ->placeholder('e.g., Universe Collection')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('image_path')
                            ->required()
                            ->image()
                            ->directory('featured-items')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(5120)
                            ->label('Featured Image')
                            ->helperText('Upload an image for the featured item. Max size: 5MB')
                            ->columnSpanFull(),

                        Forms\Components\ColorPicker::make('background_color')
                            ->label('Background Color (Optional)')
                            ->helperText('Set a background color if no image is used')
                            ->nullable(),

                        Forms\Components\TextInput::make('order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->label('Display Order')
                            ->helperText('Lower numbers appear first (1-4 for grid layout)'),

                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->label('Active')
                            ->helperText('Only active items will be displayed on the website'),
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
                    ->size(80)
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->label('Title')
                    ->default('No Title'),

                Tables\Columns\ColorColumn::make('background_color')
                    ->label('BG Color')
                    ->default('#ffffff'),

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
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All items')
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
            'index' => Pages\ListFeaturedItems::route('/'),
            'create' => Pages\CreateFeaturedItem::route('/create'),
            'edit' => Pages\EditFeaturedItem::route('/{record}/edit'),
        ];
    }
}
