<?php

namespace App\Filament\Resources\Blogs;

use App\Filament\Resources\Blogs\Pages\CreateBlog;
use App\Filament\Resources\Blogs\Pages\EditBlog;
use App\Filament\Resources\Blogs\Pages\ListBlogs;
use App\Filament\Resources\Blogs\Schemas\BlogForm;
use App\Filament\Resources\Blogs\Tables\BlogsTable;
use App\Models\Blog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, FileUpload, Toggle, RichEditor, Textarea, Repeater};
use Filament\Tables\Columns\{TextColumn, ImageColumn, IconColumn};
use Filament\Resources\Pages\{ListRecords, CreateRecord, EditRecord};
use Illuminate\Support\Str;
use Filament\Schemas\Components\Section;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Blog';

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
                        Toggle::make('robots_index')
                            ->label('Allow search engines to index this page')
                            ->default(true)
                            ->helperText('Uncheck to add "noindex" meta tag'),
                        Toggle::make('robots_follow')
                            ->label('Allow search engines to follow links on this page')
                            ->default(true)
                            ->helperText('Uncheck to add "nofollow" meta tag'),
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
            'index' => ListBlogs::route('/'),
            'create' => CreateBlog::route('/create'),
            'edit' => EditBlog::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    /**
     * Apply a default filter so the resource only lists Blog records with lang = 'en'.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('lang', 'en');
    }
}
