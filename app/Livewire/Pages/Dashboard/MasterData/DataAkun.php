<?php

namespace App\Livewire\Pages\Dashboard\MasterData;

use App\Models\Akun;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class DataAkun extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $isEdit = false;
    public $akun_id = null;

    public $email = '';
    public $password = '';
    public $nama = '';
    public $role = 'kasir';

    protected $rules = [
        'email' => 'required|email|max:30|unique:akun,email',
        'password' => 'required|min:6|max:100',
        'nama' => 'required|max:50',
        'role' => 'required|in:admin,kasir,pemilik,bendahara,gudang',
    ];

    protected $messages = [
        'email.required' => 'Email harus diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah terdaftar',
        'password.required' => 'Password harus diisi',
        'password.min' => 'Password minimal 6 karakter',
        'nama.required' => 'Nama harus diisi',
        'role.required' => 'Role harus dipilih',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->reset('email', 'password', 'nama', 'akun_id', 'isEdit');
        $this->role = 'kasir';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function edit($id)
    {
        $akun = Akun::find($id);

        if (!$akun) {
            return;
        }

        $this->akun_id = $akun->id;
        $this->email = $akun->email;
        $this->nama = $akun->nama;
        $this->role = $akun->role;
        $this->password = '';
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->isEdit) {
            $this->validate([
                'email' => 'required|email|max:30|unique:akun,email,' . $this->akun_id,
                'nama' => 'required|max:50',
                'role' => 'required|in:admin,kasir,pemilik,bendahara,gudang',
            ]);

            $akun = Akun::find($this->akun_id);
            $akun->email = $this->email;
            $akun->nama = $this->nama;
            $akun->role = $this->role;

            if ($this->password) {
                $this->validate(['password' => 'min:3|max:100']);
                $akun->password = Hash::make($this->password);
            }

            $akun->save();
            $message = 'Data akun berhasil diperbarui';
        } else {
            $this->validate();

            Akun::create([
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'nama' => $this->nama,
                'role' => $this->role,
            ]);

            $message = 'Data akun berhasil ditambahkan';
        }

        $this->closeModal();
        session()->flash('success', $message);
    }

    public function delete($id)
    {
        $akun = Akun::find($id);

        if ($akun && $akun->id !== auth('web')->user()->id) {
            $akun->delete();
            session()->flash('success', 'Data akun berhasil dihapus');
        } elseif ($akun->id === auth('web')->user()->id) {
            session()->flash('error', 'Tidak dapat menghapus akun Anda sendiri');
        }
    }

    public function render()
    {
        $akuns = Akun::where('email', 'like', '%' . $this->search . '%')
            ->orWhere('nama', 'like', '%' . $this->search . '%')
            ->orWhere('role', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.pages.dashboard.master-data.data-akun', [
            'akuns' => $akuns,
        ])->layout('layouts.dashboard');
    }
}
