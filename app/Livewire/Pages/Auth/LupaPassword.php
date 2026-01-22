<?php

namespace App\Livewire\Pages\Auth;

use App\Models\Akun;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class LupaPassword extends Component
{
    public $step = 1;
    public $email = '';
    public $otp = '';
    public $newPassword = '';
    public $confirmPassword = '';
    public $errorMessage = '';
    public $successMessage = '';
    public $akun_id = null;

    public function requestOtp()
    {
        $this->validate([
            'email' => 'required|email|max:30',
        ]);

        $this->errorMessage = '';
        $this->successMessage = '';

        $akun = Akun::where('email', $this->email)->first();

        if (!$akun) {
            $this->errorMessage = 'Email tidak terdaftar di sistem';
            return;
        }

        $otpCode = random_int(100000, 999999);

        session([
            'otp_code_' . $akun->id => $otpCode,
            'otp_email_' . $akun->id => $this->email,
            'otp_time_' . $akun->id => now()->timestamp,
        ]);

        $this->akun_id = $akun->id;

        Mail::raw("Kode OTP Anda: {$otpCode}\n\nKode ini berlaku selama 10 menit.", function ($message) {
            $message->to($this->email)->subject('Kode OTP Reset Password');
        });

        $this->successMessage = 'Kode OTP telah dikirim ke email Anda';
        $this->step = 2;
    }

    public function verifyOtp()
    {
        $this->validate([
            'otp' => 'required|digits:6',
        ]);

        $this->errorMessage = '';

        $sessionOtp = session('otp_code_' . $this->akun_id);
        $sessionTime = session('otp_time_' . $this->akun_id);

        if (!$sessionOtp) {
            $this->errorMessage = 'OTP tidak ditemukan, silakan minta OTP baru';
            return;
        }

        if (now()->timestamp - $sessionTime > 600) {
            session()->forget(['otp_code_' . $this->akun_id, 'otp_email_' . $this->akun_id, 'otp_time_' . $this->akun_id]);
            $this->errorMessage = 'OTP telah expired, silakan minta OTP baru';
            $this->step = 1;
            return;
        }

        if ($this->otp != $sessionOtp) {
            $this->errorMessage = 'Kode OTP salah';
            return;
        }

        $this->step = 3;
        $this->successMessage = 'OTP terverifikasi, silakan buat password baru';
    }

    public function resetPassword()
    {
        $this->validate([
            'newPassword' => 'required|min:6|max:100',
            'confirmPassword' => 'required|same:newPassword',
        ]);

        $this->errorMessage = '';

        $akun = Akun::find($this->akun_id);

        if (!$akun) {
            $this->errorMessage = 'Akun tidak ditemukan';
            return;
        }

        $akun->password = bcrypt($this->newPassword);
        $akun->save();

        session()->forget(['otp_code_' . $this->akun_id, 'otp_email_' . $this->akun_id, 'otp_time_' . $this->akun_id]);

        $this->successMessage = 'Password berhasil direset, silakan login dengan password baru';
        $this->step = 4;
    }

    public function kembaliKeLogin()
    {
        session()->forget(['otp_code_' . $this->akun_id, 'otp_email_' . $this->akun_id, 'otp_time_' . $this->akun_id]);
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.pages.auth.lupa-password')->layout('layouts.auth');
    }
}
