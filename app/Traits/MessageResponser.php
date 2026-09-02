<?php

namespace App\Traits;

trait MessageResponser
{
    protected function loginErrorMessage(): string
    {
        return 'Email dan/atau Password salah, silahkan coba lagi';
    }

    protected function successMessage(string $action = 'disimpan', string $subject = 'Data'): string
    {
        return trim("{$subject} berhasil {$action}") . '.';
    }

    protected function errorMessage(): string
    {
        return 'Terjadi kesalahan, mohon coba beberapa saat lagi.';
    }

    protected function flashSuccess(string $action = 'disimpan', string $subject = 'Data'): void
    {
        session()->flash('success', $this->successMessage($action, $subject));
    }

    protected function flashError(): void
    {
        session()->flash('error', $this->errorMessage());
    }
}
