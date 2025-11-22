<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RefundPolicyResource\Pages;
use App\Models\RefundPolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RefundPolicyResource extends Resource
{
    protected static ?string $model = RefundPolicy::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Refund Policy';

    protected static ?string $navigationGroup = 'User Interface';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Section Information')
                    ->schema([
                        Forms\Components\Select::make('section_key')
                            ->label('Section Type')
                            ->options([
                                'refund_policy' => 'Refund Policy',
                                'exchange_policy' => 'Exchange Policy',
                            ])
                            ->required()
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Indonesian Content')
                    ->schema([
                        Forms\Components\TextInput::make('title_id')
                            ->label('Title (Indonesian)')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\RichEditor::make('content_id')
                            ->label('Content (Indonesian)')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'blockquote',
                                'codeBlock',
                            ]),
                    ]),

                Forms\Components\Section::make('English Content')
                    ->schema([
                        Forms\Components\TextInput::make('title_en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\RichEditor::make('content_en')
                            ->label('Content (English)')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'blockquote',
                                'codeBlock',
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('section_key')
                    ->label('Section')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'refund_policy' => 'Refund Policy',
                        'exchange_policy' => 'Exchange Policy',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'refund_policy' => 'info',
                        'exchange_policy' => 'success',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title_id')
                    ->label('Title (ID)')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('order')
                    ->label('Order')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\SelectFilter::make('section_key')
                    ->label('Section')
                    ->options([
                        'refund_policy' => 'Refund Policy',
                        'exchange_policy' => 'Exchange Policy',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->boolean()
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListRefundPolicies::route('/'),
            'create' => Pages\CreateRefundPolicy::route('/create'),
            'view' => Pages\ViewRefundPolicy::route('/{record}'),
            'edit' => Pages\EditRefundPolicy::route('/{record}/edit'),
        ];
    }
}
