<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BerandaImageResource\Pages;
use App\Models\BerandaImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class BerandaImageResource extends Resource
{
    protected static ?string $model = BerandaImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Beranda';

    protected static ?string $navigationGroup = 'User Interface';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Gambar')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Tipe Gambar')
                            ->options([
                                'carousel' => 'Carousel Slide',
                                'banner' => 'Banner (Most Culture)',
                            ])
                            ->required()
                            ->reactive()
                            ->helperText('Pilih apakah gambar untuk carousel atau banner'),

                        Forms\Components\FileUpload::make('image_path')
                            ->label('Gambar')
                            ->image()
                            ->directory('beranda')
                            ->required()
                            ->maxSize(2048)
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->helperText('Ukuran maksimal 2MB. Format: JPG, PNG, JPEG')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->maxLength(255)
                            ->helperText('Opsional: Judul untuk gambar'),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->helperText('Opsional: Deskripsi singkat untuk gambar'),

                        Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->helperText('Angka lebih kecil akan tampil lebih dulu'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Hanya gambar aktif yang akan ditampilkan'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Gambar')
                    ->disk('public')
                    ->square()
                    ->size(80),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'carousel' => 'info',
                        'banner' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'carousel' => 'Carousel',
                        'banner' => 'Banner',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(30)
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'carousel' => 'Carousel',
                        'banner' => 'Banner',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Hanya Aktif')
                    ->falseLabel('Hanya Tidak Aktif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (BerandaImage $record) {
                        // Hapus file dari storage
                        if (Storage::disk('public')->exists($record->image_path)) {
                            Storage::disk('public')->delete($record->image_path);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if (Storage::disk('public')->exists($record->image_path)) {
                                    Storage::disk('public')->delete($record->image_path);
                                }
                            }
                        }),
                ]),
            ])
            ->defaultSort('order', 'asc');
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
            'index' => Pages\ListBerandaImages::route('/'),
            'create' => Pages\CreateBerandaImage::route('/create'),
            'edit' => Pages\EditBerandaImage::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
