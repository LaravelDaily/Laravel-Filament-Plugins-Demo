<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Password;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\ClassifiedsRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Filament Shield';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->rules(['email'])
                                    ->unique(ignorable: fn(?Model $record): ?Model => $record),
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->maxLength(255)
                                    ->rule(Password::default())
                                    ->dehydrated(fn($state) => filled($state))
                                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
                                    ->required(fn(string $context): bool => $context === 'create'),
                                Forms\Components\Select::make('roles')
                                    ->preload()
                                    ->required()
                                    ->multiple()
                                    ->default('user')
                                    ->relationship('roles', 'name'),
                            ]),
                    ])->columnSpan(['lg' => fn(?User $record) => $record === null ? 'full' : 2]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->content(fn(User $record): string => $record->created_at->diffForHumans()),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->content(fn(User $record): string => $record->updated_at->diffForHumans()),
                            ])
                            ->hidden(fn(?User $record): bool => $record === null)
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('roles.name')
                    ->label('Role')
                    ->colors([
                        'success' => static fn($state): bool => $state === 'Super Admin',
                        'warning' => static fn($state): bool => $state === 'Filament User',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }
}