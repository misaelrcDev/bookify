<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Service;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ServiceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ServiceResource\RelationManagers;
use Illuminate\Support\Collection;


class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }


    public static function getModelLabel(): string
    {
        return __('Service');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome do Serviço')
                    ->required(),
                    // ->unique(Service::class, 'name', ignorable: fn ($record) => $record) // Verifica duplicação
                    // ->rule('unique:services,name,NULL,id,user_id,' . Auth::id()), // Garantir unicidade por usuário
                Forms\Components\TextInput::make('price')
                    ->label('Preço')
                    ->numeric()
                    ->required(),
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::id())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Serviço'),
                Tables\Columns\TextColumn::make('price')->label('Preço')->formatStateUsing(fn ($state) => 'R$ ' . number_format($state, 2, ',', '.')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array { 
                    $data['user_id'] = Auth::user()->id;
                    return $data;
                }),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                    // Remove permanentemente o registro ao deletar
                    $record->forceDelete();
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function (Collection $records) {
                        // Remove permanentemente os registros selecionados
                        $records->each->forceDelete();
                    }),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }

}
