<?php

namespace App\Traits;

trait MessageResponser
{
    /**
     * Template pesan error login.
     */
    protected function loginErrorMessage(): string
    {
        return 'Email dan/atau Password salah, silahkan coba lagi';
    }

    /**
     * Template pesan sukses umum.
     */
    protected function successMessage(string $action = 'disimpan', string $subject = 'Data'): string
    {
        return trim("{$subject} berhasil {$action}") . '.';
    }

    /**
     * Template pesan error umum.
     */
    protected function errorMessage(): string
    {
        return 'Terjadi kesalahan, mohon coba beberapa saat lagi.';
    }

    /**
     * Flash pesan sukses ke session.
     */
    protected function flashSuccess(string $action = 'disimpan', string $subject = 'Data'): void
    {
        session()->flash('success', $this->successMessage($action, $subject));
    }

    /**
     * Flash pesan error ke session.
     */
    protected function flashError(): void
    {
        session()->flash('error', $this->errorMessage());
    }
}
