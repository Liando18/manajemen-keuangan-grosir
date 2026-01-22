<?php

namespace App\Livewire\Pages\Auth;

use App\Models\Akun;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\On;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $errorMessage = '';
    public $successMessage = '';

    public function login()
    {
        \Log::info('Login attempt', ['email' => $this->email]);

        $validated = $this->validate([
            'email' => 'required|email|max:30',
            'password' => 'required|min:3',
        ]);

        $akun = Akun::where('email', $this->email)->first();

        if (!$akun) {
            $this->errorMessage = 'Email tidak terdaftar';
            \Log::info('Email not found', ['email' => $this->email]);
            return;
        }

        if (!Hash::check($this->password, $akun->password)) {
            $this->errorMessage = 'Password salah';
            \Log::info('Password incorrect', ['email' => $this->email]);
            return;
        }

        Auth::guard('web')->login($akun);
        session(['role' => $akun->role]);

        $this->successMessage = 'Login berhasil! Selamat datang ' . $akun->nama;
        \Log::info('Login success', ['email' => $this->email]);

        return redirect(route('home'));
    }

    public function render()
    {
        return view('livewire.pages.auth.login')->layout('layouts.auth');
    }
}
