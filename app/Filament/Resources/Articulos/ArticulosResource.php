<?php

namespace App\Filament\Resources\Articulos;

use App\Filament\Resources\Articulos\Pages\CreateArticulos;
use App\Filament\Resources\Articulos\Pages\EditArticulos;
use App\Filament\Resources\Articulos\Pages\ListArticulos;
use App\Filament\Resources\Articulos\Schemas\ArticulosForm;
use App\Filament\Resources\Articulos\Tables\ArticulosTable;
use App\Models\Blog;
use App\Models\Articulo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\{TextInput, FileUpload, Toggle, RichEditor, Textarea, Repeater, Hidden};
use Illuminate\Support\Str;
use Filament\Tables\Columns\{TextColumn, ImageColumn, IconColumn};

class ArticulosResource extends Resource
{
    protected static ?string $model = Articulo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Articulos';
    
    // Label shown in the Filament navigation
    protected static ?string $navigationLabel = 'Articulos';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                Section::make('Content')
                    ->schema([
                        TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => 
                        $set('slug', Str::slug($state))
                        ),
                        TextInput::make('slug')->required()->unique(ignoreRecord: true),
                        Hidden::make('lang')->default('es'),
                        RichEditor::make('content')->required(),
                        FileUpload::make('image')->disk('public')->directory('blogs')->image()->nullable(),
                        Toggle::make('published')
                            ->label('Published')
                            ->default(true),
                            ])->collapsed(),
                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_title')->maxLength(255),
                        Textarea::make('meta_description')->rows(3),
                        Textarea::make('meta_keywords')->rows(2)->placeholder('keyword1, keyword2, keyword3'),
                        TextInput::make('canonical_url')->placeholder('https://example.com/blog/...'),
                        // FAQs can be managed as a JSON array in a custom way
                    ])->collapsed(),
                Section::make('FAQs')
                    ->schema([
                        Repeater::make('faqs')
                        ->schema([
                            TextInput::make('question')->required(),
                            Textarea::make('answer')->required()->rows(2),
                        ])
                        ->label('Frequently Asked Questions')
                        ->collapsible()
                        ->defaultItems(1)
                        ->addActionLabel('Add FAQ'),
                    ])->collapsed(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->square()->disk('public'),
                TextColumn::make('title')->searchable()->sortable()->limit(25),
                IconColumn::make('published')->boolean(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
                \Filament\Actions\Action::make('togglePublish')
                    ->icon(fn (Blog $record): string => $record->published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->label(fn (Blog $record): string => $record->published ? 'Unpublish' : 'Publish')
                    ->action(function (Blog $record): void {
                        $record->published = !$record->published;
                        $record->save();
                    })
                    ->color(fn (Blog $record): string => $record->published ? 'danger' : 'success')
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
            'index' => ListArticulos::route('/'),
            'create' => CreateArticulos::route('/create'),
            'edit' => EditArticulos::route('/{record}/edit'),
        ];
    }

    /**
     * Limit the Articulos resource to records where lang = 'en'.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('lang', 'es');
    }
}
