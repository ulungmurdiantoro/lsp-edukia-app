<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Blog';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Konten Artikel')->schema([
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('ringkasan')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('konten')
                    ->required()
                    ->rows(12)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Meta')->schema([
                Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->directory('blog')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('kategori')->default('Umum'),
                Forms\Components\TextInput::make('penulis')->default('Admin LSP Edukia'),
                Forms\Components\Toggle::make('published')
                    ->live()
                    ->afterStateUpdated(fn ($state, callable $set) =>
                        $state ? $set('published_at', now()) : null
                    ),
                Forms\Components\DateTimePicker::make('published_at'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('thumbnail')->disk('public'),
            Tables\Columns\TextColumn::make('judul')->searchable()->limit(50),
            Tables\Columns\TextColumn::make('kategori')->badge(),
            Tables\Columns\IconColumn::make('published')->boolean(),
            Tables\Columns\TextColumn::make('published_at')->dateTime('d M Y')->sortable(),
        ])
        ->defaultSort('created_at', 'desc')
        ->filters([
            Tables\Filters\TernaryFilter::make('published'),
        ])
        ->actions([Tables\Actions\EditAction::make()])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
