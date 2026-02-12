<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Auth\Pages\Register as BaseRegister;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Kullanıcı Adı')
                    ->required()
                    ->maxLength(255),
                $this->getEmailFormComponent()
                    ->label('E-posta Adresi'),
                $this->getPasswordFormComponent()
                    ->label('Parola'),
                $this->getPasswordConfirmationFormComponent()
                    ->label('Parola Tekrar'),
            ]);
    }
}
