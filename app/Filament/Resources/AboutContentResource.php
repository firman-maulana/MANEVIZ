<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutContentResource\Pages;
use App\Models\AboutContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AboutContentResource extends Resource
{
    protected static ?string $model = AboutContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationLabel = 'About';

    protected static ?string $navigationGroup = 'User Interface';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('About Image')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('About Image')
                            ->image()
                            ->directory('about-images')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(5120)
                            ->helperText('Upload gambar untuk halaman About. Max: 5MB')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('About Content')
                    ->schema([
                        Forms\Components\Textarea::make('paragraph_1')
                            ->label('Paragraph 1 (Introduction)')
                            ->required()
                            ->rows(5)
                            ->maxLength(2000)
                            ->helperText('Paragraf pembuka tentang MANEVIZ')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('paragraph_2')
                            ->label('Paragraph 2 (Anime Inspiration)')
                            ->required()
                            ->rows(5)
                            ->maxLength(2000)
                            ->helperText('Paragraf tentang inspirasi anime')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('paragraph_3')
                            ->label('Paragraph 3 (Expression)')
                            ->required()
                            ->rows(5)
                            ->maxLength(2000)
                            ->helperText('Paragraf tentang ekspresi dan Gen-Z')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('paragraph_4')
                            ->label('Paragraph 4 (Movement)')
                            ->required()
                            ->rows(5)
                            ->maxLength(2000)
                            ->helperText('Paragraf tentang gerakan dari Malang')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('paragraph_5')
                            ->label('Paragraph 5 (Tagline)')
                            ->required()
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('Tagline penutup MANEVIZ')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Hanya satu konten yang dapat aktif pada satu waktu')
                            ->default(true)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->size(60),

                Tables\Columns\TextColumn::make('paragraph_1')
                    ->label('Introduction')
                    ->limit(50)
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only'),
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
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListAboutContents::route('/'),
            'create' => Pages\CreateAboutContent::route('/create'),
            'edit' => Pages\EditAboutContent::route('/{record}/edit'),
        ];
    }
}
