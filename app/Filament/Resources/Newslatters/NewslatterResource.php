<?php

namespace App\Filament\Resources\Newslatters;

use App\Filament\Resources\Newslatters\Pages\CreateNewslatter;
use App\Filament\Resources\Newslatters\Pages\EditNewslatter;
use App\Filament\Resources\Newslatters\Pages\ListNewslatters;
use App\Filament\Resources\Newslatters\Schemas\NewslatterForm;
use App\Filament\Resources\Newslatters\Tables\NewslattersTable;
use App\Models\Newslatter;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NewslatterResource extends Resource
{
    protected static ?string $model = Newslatter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'NewsLatter';

    public static function form(Schema $schema): Schema
    {
        return NewslatterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewslattersTable::configure($table);
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
            'index' => ListNewslatters::route('/'),
            'create' => CreateNewslatter::route('/create'),
            'edit' => EditNewslatter::route('/{record}/edit'),
        ];
    }
}
