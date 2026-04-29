<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login;

class CustomLogin extends Login
{
    public function mount(): void
    {
        parent::mount();

        if (app()->isLocal() || config('app.debug')) {
            $this->form->fill([
                'email' => 'admin@admin.com',
                'password' => 'admin',
                'remember' => true,
            ]);
        }
    }
}
