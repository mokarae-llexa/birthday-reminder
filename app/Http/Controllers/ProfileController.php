<?php

namespace App\Http\Controllers;

use App\Traits\MessageResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    use MessageResponser;

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['avatar'] = $this->handleAvatarUpload($request, $user->avatar);

        $user->update($validated);

        return redirect()
            ->route('profile.edit')
            ->with('success', $this->successMessage('diperbarui', 'Profil Anda'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('success', $this->successMessage('diperbarui', 'Password Anda'));
    }

    private function handleAvatarUpload(Request $request, ?string $oldAvatar = null): ?string
    {
        if ($request->boolean('avatar_remove')) {
            if ($oldAvatar && Storage::disk('public')->exists($oldAvatar)) {
                Storage::disk('public')->delete($oldAvatar);
            }
            return null;
        }

        if ($request->filled('avatar_base64')) {
            $base64Image = $request->input('avatar_base64');
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $data = substr($base64Image, strpos($base64Image, ',') + 1);
                $data = base64_decode($data);

                if ($data === false) {
                    return $oldAvatar;
                }

                if (strlen($data) > 2 * 1024 * 1024) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'avatar' => ['Ukuran file gambar tidak boleh melebihi 2MB.'],
                    ]);
                }

                $extension = strtolower($type[1]);
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $extension = 'png';
                }

                $filename = 'avatars/user_' . time() . '_' . Str::random(10) . '.' . $extension;
                Storage::disk('public')->put($filename, $data);

                if ($oldAvatar && Storage::disk('public')->exists($oldAvatar)) {
                    Storage::disk('public')->delete($oldAvatar);
                }

                return $filename;
            }
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');

            if ($oldAvatar && Storage::disk('public')->exists($oldAvatar)) {
                Storage::disk('public')->delete($oldAvatar);
            }

            return $path;
        }

        return $oldAvatar;
    }
}
