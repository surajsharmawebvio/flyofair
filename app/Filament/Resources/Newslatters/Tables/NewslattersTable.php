<?php

namespace App\Filament\Resources\Newslatters\Tables;

use App\Models\Newslatter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Action as FilamentAction;
// use fully-qualified names for table actions below to avoid analyzer issues
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class NewslattersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_subscribed')
                    ->label('Subscribed')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Subscribed At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Keep a quick date filter for convenience (pre-built filter UI is optional)
                Filter::make('created_between')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('to'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['from'])) {
                            $query->whereDate('created_at', '>=', $data['from']);
                        }
                        if (!empty($data['to'])) {
                            $query->whereDate('created_at', '<=', $data['to']);
                        }
                    }),
            ])
            ->recordActions([])
            ->bulkActions([
                // Keep delete bulk action
                DeleteBulkAction::make(),
            ])
            ->toolbarActions([
                // Export filtered (date range) via action form
                FilamentAction::make('export_filtered')
                    ->label('Export CSV (filtered)')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('to')->label('To'),
                    ])
                    ->action(function (array $data) {
                        $query = Newslatter::query();
                        if (!empty($data['from'])) {
                            $query->whereDate('created_at', '>=', $data['from']);
                        }
                        if (!empty($data['to'])) {
                            $query->whereDate('created_at', '<=', $data['to']);
                        }

                        $rows = $query->orderBy('created_at', 'desc')->get(['email', 'is_subscribed', 'created_at']);

                        $filename = 'newsletter-' . now()->format('Ymd_His') . '.csv';

                        return response()->streamDownload(function () use ($rows) {
                            $handle = fopen('php://output', 'w');
                            fputcsv($handle, ['email', 'is_subscribed', 'created_at']);
                            foreach ($rows as $r) {
                                fputcsv($handle, [
                                    $r->email,
                                    $r->is_subscribed ? 'yes' : 'no',
                                    $r->created_at->toDateTimeString(),
                                ]);
                            }
                            fclose($handle);
                        }, $filename, [
                            'Content-Type' => 'text/csv',
                        ]);
                    }),
            ]);
    }
}
