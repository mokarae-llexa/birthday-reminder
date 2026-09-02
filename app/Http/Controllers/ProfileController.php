<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile-edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = User::findOrFail(Auth::id());


        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'birth_date' => $request->birth_date,
        ];


        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }


        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
}
