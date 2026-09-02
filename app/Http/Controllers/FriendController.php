<?php
namespace App\Http\Controllers;
use App\Models\Friend;
use App\Traits\MessageResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FriendController extends Controller
{
    use MessageResponser;

    public function index(Request $request)
    {
        $query = Friend::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        $friends = $query->latest()->get();

        return view('friends.index', compact('friends', 'search'));
    }

    public function create()
    {
        return view('friends.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'required|date',
            'notes' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['avatar'] = $this->handleAvatarUpload($request);

        Friend::create($validated);

        return redirect()
            ->route('friends.index')
            ->with('success', $this->successMessage('ditambahkan', 'Data teman'));
    }

    public function edit(Friend $friend)
    {
        return view('friends.edit', compact('friend'));
    }

    public function update(Request $request, Friend $friend)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'required|date',
            'notes' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['avatar'] = $this->handleAvatarUpload($request, $friend->avatar);

        $friend->update($validated);
        return redirect()
            ->route('friends.index')
            ->with('success', $this->successMessage('diperbarui', 'Data teman'));
    }

    public function destroy(Friend $friend)
    {
        if ($friend->avatar && Storage::disk('public')->exists($friend->avatar)) {
            Storage::disk('public')->delete($friend->avatar);
        }
        $friend->delete();
        return redirect()
            ->route('friends.index')
            ->with('success', $this->successMessage('dihapus', 'Data teman'));
    }

    public function calendar()
    {
        $currentMonth = now()->month;
        $friends = Friend::whereMonth('birth_date', $currentMonth)->get();
        $birthdaysByDay = $friends->groupBy(function ($friend) {
            return \Carbon\Carbon::parse($friend->birth_date)->format('j');
        });
        return view('calendar', compact('birthdaysByDay'));
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

                $filename = 'avatars/friend_' . time() . '_' . Str::random(10) . '.' . $extension;
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
