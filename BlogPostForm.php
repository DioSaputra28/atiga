<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->description('Post details and metadata')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Auto-generated from title'),

                        Textarea::make('excerpt')
                            ->label('Excerpt')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Brief summary of the post (max 500 characters)'),

                        FileUpload::make('featured_image')
                            ->label('Featured Image')
                            ->image()
                            ->disk('public')
                            ->directory('blogs/featured')
                            ->maxSize(5120)
                            ->imageEditor()
                            ->helperText('Main post image (max 5MB, recommended: 1200x630px)'),
                    ])
                    ->columns(2),

                Section::make('Content')
                    ->description('Build your post with text, images, and YouTube videos')
                    ->schema([
                        Builder::make('content')
                            ->label('Content Blocks')
                            ->helperText('Add and arrange content blocks. Drag to reorder, click to edit.')
                            ->blocks([
                                Block::make('text')
                                    ->label('Text Block')
                                    ->icon('heroicon-m-document-text')
                                    ->schema([
                                        RichEditor::make('content')
                                            ->label('Content')
                                            ->required()
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'strike',
                                                'link',
                                                'h2',
                                                'h3',
                                                'blockquote',
                                                'bulletList',
                                                'orderedList',
                                            ])
                                            ->helperText('Enter your text content. Use the toolbar for formatting.'),
                                    ])
                                    ->columns(1),

                                Block::make('image')
                                    ->label('Image Block')
                                    ->icon('heroicon-m-photo')
                                    ->schema([
                                        FileUpload::make('file_path')
                                            ->label('Image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('blogs/content')
                                            ->maxSize(10240)
                                            ->imageEditor()
                                            ->required()
                                            ->helperText('Upload an image (max 10MB)'),

                                        TextInput::make('alt_text')
                                            ->label('Alt Text')
                                            ->maxLength(255)
                                            ->helperText('Describe the image for accessibility and SEO'),

                                        TextInput::make('caption')
                                            ->label('Caption')
                                            ->maxLength(255)
                                            ->helperText('Optional caption displayed below the image'),
                                    ])
                                    ->columns(1),

                                Block::make('youtube')
                                    ->label('YouTube Video')
                                    ->icon('heroicon-m-play-circle')
                                    ->schema([
                                        TextInput::make('url')
                                            ->label('YouTube URL')
                                            ->required()
                                            ->url()
                                            ->maxLength(500)
                                            ->placeholder('https://www.youtube.com/watch?v=...')
                                            ->helperText('Paste a YouTube video URL. Supports: youtube.com/watch?v=ID, youtu.be/ID, youtube.com/embed/ID'),
                                    ])
                                    ->columns(1),
                            ])
                            ->collapsible()
                            ->addActionLabel('Add Block')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Section::make('Publishing')
                    ->description('Control post visibility and status')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required()
                            ->helperText('Draft: only visible to admins, Published: visible to public, Archived: hidden'),

                        DateTimePicker::make('published_at')
                            ->label('Publish Date')
                            ->helperText('Schedule publication or leave empty to publish immediately when status is set to Published')
                            ->native(false),
                    ])
                    ->columns(2),
            ]);
    }
}
