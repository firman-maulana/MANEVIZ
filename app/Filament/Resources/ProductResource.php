<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $navigationGroup = 'Catalog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Textarea::make('deskripsi')
                    ->required(),

                Forms\Components\Textarea::make('deskripsi_singkat'),

                Forms\Components\TextInput::make('harga')
                    ->numeric()
                    ->required(),

                // 🔥 Tambahkan Section ini di ProductResource form() setelah harga_jual

                Forms\Components\Section::make('Discount Settings')
                    ->schema([
                        Forms\Components\TextInput::make('discount_percentage')
                            ->label('Discount Percentage (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(0)
                            ->suffix('%')
                            ->helperText('Enter discount percentage (0-100). Leave 0 for no discount.')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $basePrice = $get('harga_jual') ?: $get('harga');
                                if ($basePrice && $state > 0) {
                                    $discountAmount = ($basePrice * $state) / 100;
                                    $finalPrice = $basePrice - $discountAmount;

                                    // Show preview (optional, using placeholder)
                                    $set('discount_preview', 'Final Price: IDR ' . number_format($finalPrice, 0, ',', '.'));
                                }
                            }),

                        Forms\Components\Placeholder::make('discount_preview')
                            ->label('Price After Discount')
                            ->content(function (callable $get) {
                                $basePrice = $get('harga_jual') ?: $get('harga');
                                $discountPercentage = $get('discount_percentage') ?: 0;

                                if ($basePrice && $discountPercentage > 0) {
                                    $discountAmount = ($basePrice * $discountPercentage) / 100;
                                    $finalPrice = $basePrice - $discountAmount;

                                    return 'IDR ' . number_format($finalPrice, 0, ',', '.') .
                                        ' (Save IDR ' . number_format($discountAmount, 0, ',', '.') . ')';
                                }

                                return 'No discount applied';
                            }),

                        Forms\Components\DateTimePicker::make('discount_start_date')
                            ->label('Discount Start Date (Optional)')
                            ->helperText('Leave empty for immediate discount')
                            ->native(false),

                        Forms\Components\DateTimePicker::make('discount_end_date')
                            ->label('Discount End Date (Optional)')
                            ->helperText('Leave empty for unlimited discount')
                            ->native(false)
                            ->after('discount_start_date'),
                    ])
                    ->columns(2)
                    ->collapsed()
                    ->description('Set discount percentage and optional date range for the discount period'),

                Forms\Components\TextInput::make('harga_jual')
                    ->numeric(),

                Forms\Components\TextInput::make('sku')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('stock_kuantitas')
                    ->numeric()
                    ->default(0),

                Forms\Components\TextInput::make('berat')
                    ->numeric(),

                Forms\Components\KeyValue::make('dimensi'),

                Forms\Components\Select::make('ukuran')
                    ->options([
                        's' => 'S',
                        'm' => 'M',
                        'l' => 'L',
                        'xl' => 'XL',
                    ]),

                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'out_of_stock' => 'Out of Stock',
                    ])
                    ->default('active'),

                Forms\Components\Toggle::make('is_featured'),

                // 🔒 READONLY FIELDS - Auto-calculated, tidak bisa diinput manual
                Forms\Components\Section::make('Statistik Produk (Auto-generated)')
                    ->schema([
                        Forms\Components\TextInput::make('rating_rata')
                            ->label('Rating Rata-rata')
                            ->numeric()
                            ->default(0.00)
                            ->disabled()
                            ->dehydrated(true)
                            ->helperText('Rating ini di-update otomatis dari review pelanggan'),

                        Forms\Components\TextInput::make('total_reviews')
                            ->label('Total Review')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(true)
                            ->helperText('Jumlah review dari pelanggan'),

                        Forms\Components\TextInput::make('total_penjualan')
                            ->label('Total Penjualan')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(true)
                            ->helperText('Total produk yang terjual'),
                    ])
                    ->columns(3)
                    ->collapsed()
                    ->description('Data ini di-update otomatis oleh sistem berdasarkan aktivitas user'),

                Forms\Components\KeyValue::make('meta_data'),

                // 📸 Upload multiple images via product_images table
                Forms\Components\Repeater::make('images')
                    ->relationship('images')
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->image()
                            ->directory('products/images')
                            ->required(),

                        Forms\Components\TextInput::make('alt_text')
                            ->label('Alt Text'),

                        Forms\Components\Toggle::make('is_primary')
                            ->label('Primary Thumbnail'),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->orderable('sort_order')
                    ->columns(2)
                    ->createItemButtonLabel('Tambah Gambar'),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Detail Produk')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')->label('Nama Produk'),
                        Infolists\Components\TextEntry::make('category.name')->label('Kategori'),
                        Infolists\Components\TextEntry::make('harga')->money('idr'),
                        Infolists\Components\TextEntry::make('harga_jual')->money('idr'),
                        Infolists\Components\TextEntry::make('stock_kuantitas')->label('Stok'),
                        Infolists\Components\TextEntry::make('status')->badge(),
                        Infolists\Components\TextEntry::make('sku'),
                        Infolists\Components\TextEntry::make('ukuran'),
                        Infolists\Components\TextEntry::make('rating_rata')->label('Rating'),
                        Infolists\Components\TextEntry::make('total_reviews')->label('Review'),
                        Infolists\Components\TextEntry::make('total_penjualan')->label('Terjual'),
                        Infolists\Components\TextEntry::make('deskripsi')
                            ->columnSpanFull()
                            ->markdown()
                            ->label('Deskripsi Lengkap'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Gallery Gambar Produk')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('images')
                            ->schema([
                                Infolists\Components\Group::make([
                                    Infolists\Components\ImageEntry::make('image_path')
                                        ->label('')
                                        ->height(200)
                                        ->width(200)
                                        ->square()
                                        ->extraAttributes([
                                            'class' => 'rounded-xl shadow-md relative',
                                        ]),

                                    Infolists\Components\TextEntry::make('alt_text')
                                        ->label('Alt Text')
                                        ->default('-')
                                        ->extraAttributes([
                                            'class' => 'text-sm text-gray-500',
                                        ]),

                                    // Badge overlay untuk "Primary"
                                    Infolists\Components\TextEntry::make('is_primary')
                                        ->label('')
                                        ->formatStateUsing(fn($state) => $state ? 'Primary' : '')
                                        ->extraAttributes([
                                            'class' => 'absolute top-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded-md shadow-md',
                                        ]),
                                ])->columnSpan(1),
                            ])
                            ->columns(3), // tampil 3 card per baris
                    ]),

            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('primaryImage.image_path')
                    ->label('Thumbnail')
                    ->square(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('harga')
                    ->money('idr'),

                // 🔥 Tambahkan kolom ini di ProductResource table() setelah kolom harga

                Tables\Columns\TextColumn::make('discount_percentage')
                    ->label('Discount')
                    ->formatStateUsing(function ($state, $record) {
                        if (!$state || $state <= 0) {
                            return '-';
                        }

                        $badge = '<span style="background: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 11px;">'
                            . number_format($state, 0) . '% OFF</span>';

                        if ($record->hasActiveDiscount()) {
                            return new \Illuminate\Support\HtmlString($badge);
                        }

                        return new \Illuminate\Support\HtmlString(
                            '<span style="background: #6c757d; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Scheduled</span>'
                        );
                    })
                    ->html()
                    ->sortable(),

                Tables\Columns\TextColumn::make('final_price')
                    ->label('Final Price')
                    ->formatStateUsing(function ($record) {
                        $finalPrice = $record->final_price;
                        $originalPrice = $record->getOriginalPrice();

                        if ($record->hasActiveDiscount()) {
                            return new \Illuminate\Support\HtmlString(
                                '<div style="display: flex; flex-direction: column; gap: 4px;">' .
                                    '<span style="font-weight: 600; color: #dc3545;">IDR ' . number_format($finalPrice, 0, ',', '.') . '</span>' .
                                    '<span style="font-size: 11px; color: #999; text-decoration: line-through;">IDR ' . number_format($originalPrice, 0, ',', '.') . '</span>' .
                                    '</div>'
                            );
                        }

                        return 'IDR ' . number_format($finalPrice, 0, ',', '.');
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('stock_kuantitas'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                        'warning' => 'out_of_stock',
                    ]),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),

                Tables\Columns\TextColumn::make('rating_rata'),

                Tables\Columns\TextColumn::make('total_reviews'),

                Tables\Columns\TextColumn::make('total_penjualan'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'out_of_stock' => 'Out of Stock',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'view' => Pages\ViewProduct::route('/{record}'),
        ];
    }
}
