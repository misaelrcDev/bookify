<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Booking;
use App\Models\Service;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Exports\BookingsExport;
use App\Jobs\SendReportEmailJob;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\BookingResource\Pages;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function getModelLabel(): string
    {
        return __('Bookings');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('client_name')
                    ->required(),
                Forms\Components\TextInput::make('client_email')
                    ->email()
                    ->required(),
                Forms\Components\Select::make('service_id')
                    ->relationship('service', 'name')
                    ->options(Service::where('user_id', Auth::id())->pluck('name', 'id'))
                    ->required(),
                Forms\Components\DateTimePicker::make('start_time')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_time')
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
                Tables\Columns\TextColumn::make('client_name'),
                Tables\Columns\TextColumn::make('client_email'),
                Tables\Columns\TextColumn::make('service.name'),
                Tables\Columns\TextColumn::make('start_time'),
                Tables\Columns\TextColumn::make('end_time'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                // Menu dropdown para todas as telas
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('export')
                        ->label('Exportar para Excel')
                        ->action(function (Collection $records) {
                            $bookingsExport = $records->map(function ($booking) {
                                return [
                                    'client_name' => $booking->client_name,
                                    'service' => $booking->service->name,
                                    'start_time' => $booking->start_time,
                                    'end_time' => $booking->end_time,
                                ];
                            });

                            return Excel::download(new BookingsExport($bookingsExport), 'reservas.xlsx');
                        })
                        ->icon('heroicon-o-document-arrow-down'),
                    BulkAction::make('exportPdf')
                        ->label('Exportar para PDF')
                        ->action(function (Collection $records) {
                            $selectedIds = $records->pluck('id')->toArray();

                            return response()->redirectToRoute('report.pdf', ['selected' => $selectedIds]);
                        })
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('danger')
                        ->openUrlInNewTab(),
                    BulkAction::make('sendEmailReport')
                        ->label('Enviar Relatório por E-mail')
                        ->action(function (Collection $records, array $data) {
                            $selectedIds = $records->pluck('id')->toArray();
                            SendReportEmailJob::dispatch($data['email'], $selectedIds);
                        })
                        ->form([
                            Forms\Components\TextInput::make('email')
                                ->label('E-mail do Destinatário')
                                ->email()
                                ->required(),
                        ])
                        ->icon('heroicon-o-envelope')
                        ->color('success'),
                ])
                    ->label('Ações') // Nome do menu no dropdown
                    ->dropdown(), // Sempre exibido como dropdown
            ]);
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        // Verificar se o usuário está inscrito no plano default
        if (!$user->subscribed('default')) {
            return false;
        }

        // Verificar os preços permitidos para a assinatura
        $allowedPrices = [
            'price_1QkP5tKNXZPgsmL1KjyNiRLx',
            'price_1QkPAtKNXZPgsmL1Uqs0b6Hi',
        ];

        return in_array($user->subscription('default')->stripe_price, $allowedPrices);
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
