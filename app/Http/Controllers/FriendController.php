<?php
namespace App\Http\Controllers;
use App\Models\Friend;
use App\Models\User;
use App\Traits\MessageResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FriendController extends Controller
{
    use MessageResponser;

    public function index(Request $request)
    {
        $query = Friend::query()->with(['linkedUser', 'requester']);

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

    public function create(Request $request)
    {
        $prefill = $this->resolvePrefill($request);
        $prefillSourceLabel = $prefill['_source_label'] ?? null;
        $prefillIsLinked = (bool) ($prefill['_is_linked'] ?? false);
        unset($prefill['_source_label'], $prefill['_is_linked']);

        return view('friends.create', compact('prefill', 'prefillSourceLabel', 'prefillIsLinked'));
    }

    public function searchDatabase(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $source = $request->input('source', 'all');
        $limit = (int) $request->input('limit', 10);
        $limit = max(1, min($limit, 20));

        $data = [];

        if (in_array($source, ['all', 'users'])) {
            $usersQuery = User::query()->select(['id', 'name', 'email', 'birth_date', 'avatar']);
            if ($q !== '') {
                $usersQuery->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            }
            $linkedIds = Friend::whereNotNull('linked_user_id')->pluck('linked_user_id')->all();
            foreach ($usersQuery->latest()->limit($limit)->get() as $user) {
                $data[] = [
                    'source' => 'user',
                    'source_label' => 'Registered User',
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => null,
                    'birth_date' => $user->birth_date ? (string) $user->birth_date : null,
                    'notes' => null,
                    'avatar' => $user->avatar_url,
                    'is_self' => (int) $request->user()->id === (int) $user->id,
                    'is_added' => in_array($user->id, $linkedIds),
                    'prefill_url' => route('friends.create', ['source' => 'user', 'source_id' => $user->id]),
                ];
            }
        }

        if (in_array($source, ['all', 'friends'])) {
            $friendsQuery = Friend::query();
            if ($q !== '') {
                $friendsQuery->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%");
                });
            }
            foreach ($friendsQuery->latest()->limit($limit)->get() as $friend) {
                $data[] = [
                    'source' => 'friend',
                    'source_label' => 'Saved Friend',
                    'id' => $friend->id,
                    'name' => $friend->name,
                    'email' => $friend->email,
                    'phone' => $friend->phone,
                    'birth_date' => $friend->birth_date ? (string) $friend->birth_date : null,
                    'notes' => $friend->notes,
                    'avatar' => $friend->avatar_url,
                    'prefill_url' => route('friends.create', ['source' => 'friend', 'source_id' => $friend->id]),
                ];
            }
        }

        return response()->json(['data' => $data]);
    }

    private function resolvePrefill(Request $request): array
    {
        $prefill = [
            'linked_user_id' => null,
            'name' => null,
            'email' => null,
            'phone' => null,
            'birth_date' => null,
            'notes' => null,
            'avatar' => null,
        ];

        $source = $request->input('source');
        $sourceId = $request->input('source_id');

        if ($source === 'user' && $sourceId) {
            $user = User::find($sourceId);
            if ($user) {
                $prefill['linked_user_id'] = $user->id;
                $prefill['name'] = $user->name;
                $prefill['email'] = $user->email;
                $prefill['birth_date'] = $user->birth_date ? (string) $user->birth_date : null;
                $prefill['avatar'] = $user->avatar_url;
                $prefill['_source_label'] = 'Registered User: ' . $user->name;
                $prefill['_is_linked'] = true;
                return $prefill;
            }
        }

        if ($source === 'friend' && $sourceId) {
            $friend = Friend::find($sourceId);
            if ($friend) {
                $prefill['name'] = $friend->name;
                $prefill['email'] = $friend->email;
                $prefill['phone'] = $friend->phone;
                $prefill['birth_date'] = $friend->birth_date ? (string) $friend->birth_date : null;
                $prefill['notes'] = $friend->notes;
                $prefill['avatar'] = $friend->avatar_url;
                $prefill['_source_label'] = 'Friend Data: ' . $friend->name;
                return $prefill;
            }
        }

        $hasDirectPrefill = false;
        foreach (['name', 'email', 'phone', 'birth_date', 'notes', 'avatar'] as $field) {
            if ($request->filled($field)) {
                $prefill[$field] = $request->input($field);
                $hasDirectPrefill = true;
            }
        }
        if ($hasDirectPrefill) {
            $prefill['_source_label'] = 'Data from Database';
        }

        return $prefill;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'linked_user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'required|date',
            'notes' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'avatar_url' => 'nullable|string|max:2048',
        ]);

        if (!empty($validated['linked_user_id'])) {
            if (Friend::where('linked_user_id', $validated['linked_user_id'])->exists()) {
                return back()
                    ->withErrors(['linked_user_id' => 'This account is already in the friends list.'])
                    ->withInput();
            }

            $sourceUser = User::findOrFail($validated['linked_user_id']);
            $validated['name'] = $sourceUser->name;
            $validated['email'] = $sourceUser->email;
            $validated['birth_date'] = $sourceUser->birth_date
                ? (string) $sourceUser->birth_date
                : $validated['birth_date'];
            $validated['created_by'] = $request->user()->id;
            $validated['request_status'] = (int) $validated['linked_user_id'] === (int) $request->user()->id
                ? 'accepted'
                : 'pending';
        }

        $validated['avatar'] = $this->handleAvatarUpload($request);

        if (empty($validated['avatar']) && $request->filled('avatar_url')) {
            $validated['avatar'] = $request->input('avatar_url');
        }

        if (empty($validated['avatar']) && !empty($validated['linked_user_id'])) {
            $validated['avatar'] = $sourceUser->getAttributes()['avatar'] ?? null;
        }
        unset($validated['avatar_url']);

        $friend = Friend::create($validated);

        if ($friend->isPending()) {
            return redirect()
                ->route('friends.index')
                ->with('success', 'Friend request sent to ' . $friend->name . '.');
        }

        return redirect()
            ->route('friends.index')
            ->with('success', $this->successMessage('ditambahkan', 'Data teman'));
    }

    public function edit(Friend $friend)
    {
        $friend->load('linkedUser');

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
            'avatar_url' => 'nullable|string|max:2048',
            'unlink' => 'nullable|boolean',
        ]);

        $unlink = $request->boolean('unlink');
        $wantsCustomAvatar = $request->hasFile('avatar')
            || $request->filled('avatar_base64')
            || $request->boolean('avatar_remove')
            || $request->filled('avatar_url');

        $validated['avatar'] = $this->handleAvatarUpload($request, $friend->avatar);

        if (empty($validated['avatar']) && $request->filled('avatar_url')) {
            $validated['avatar'] = $request->input('avatar_url');
        }
        unset($validated['avatar_url'], $validated['unlink']);

        if ($unlink) {
            $validated['linked_user_id'] = null;
        } elseif ($friend->linked_user_id) {
            $sourceUser = User::find($friend->linked_user_id);
            if ($sourceUser) {
                $validated['linked_user_id'] = $sourceUser->id;
                $validated['name'] = $sourceUser->name;
                $validated['email'] = $sourceUser->email;
                $validated['birth_date'] = $sourceUser->birth_date
                    ? (string) $sourceUser->birth_date
                    : $validated['birth_date'];

                if (!$wantsCustomAvatar) {
                    $friend->syncFromUser($sourceUser);
                    $validated['name'] = $friend->name;
                    $validated['email'] = $friend->email;
                    $validated['birth_date'] = $friend->birth_date;
                    $validated['avatar'] = $friend->avatar;
                }
            } else {
                $validated['linked_user_id'] = null;
            }
        }

        $friend->update($validated);
        return redirect()
            ->route('friends.index')
            ->with('success', $this->successMessage('diperbarui', 'Data teman'));
    }

    public function inbox()
    {
        $incoming = Friend::with('requester')
            ->where('linked_user_id', auth()->id())
            ->where('request_status', 'pending')
            ->latest()
            ->get();

        $outgoing = Friend::with('linkedUser')
            ->where('created_by', auth()->id())
            ->where('request_status', 'pending')
            ->latest()
            ->get();

        return view('friends.requests', compact('incoming', 'outgoing'));
    }

    public function accept(Friend $friend)
    {
        $this->ensureRequestTarget($friend);

        $friend->update(['request_status' => 'accepted']);

        $requesterId = $friend->created_by;
        if ($requesterId && !Friend::where('linked_user_id', $requesterId)->exists()) {
            $requester = User::find($requesterId);
            if ($requester) {
                Friend::create([
                    'linked_user_id' => $requester->id,
                    'created_by' => auth()->id(),
                    'request_status' => 'accepted',
                    'name' => $requester->name,
                    'email' => $requester->email,
                    'birth_date' => $requester->birth_date ? (string) $requester->birth_date : $friend->birth_date,
                    'avatar' => $requester->getAttributes()['avatar'] ?? null,
                ]);
            }
        }

        return redirect()
            ->route('friends.requests')
            ->with('success', 'Friend request from ' . $friend->display_name . ' accepted.');
    }

    public function decline(Friend $friend)
    {
        $this->ensureRequestTarget($friend);

        $name = $friend->display_name;
        $this->deleteAvatarFile($friend);
        $friend->delete();

        return redirect()
            ->route('friends.requests')
            ->with('success', 'Friend request from ' . $name . ' declined.');
    }

    private function ensureRequestTarget(Friend $friend): void
    {
        abort_unless(
            $friend->isPending()
                && $friend->linked_user_id
                && (int) $friend->linked_user_id === (int) auth()->id(),
            403
        );
    }

    public function destroy(Friend $friend)
    {
        $this->deleteAvatarFile($friend);
        $friend->delete();
        return redirect()
            ->route('friends.index')
            ->with('success', $this->successMessage('dihapus', 'Data teman'));
    }

    private function deleteAvatarFile(Friend $friend): void
    {
        $friend->loadMissing('linkedUser');
        $sharedAvatar = $friend->linked_user_id
            && $friend->linkedUser
            && ($friend->getAttributes()['avatar'] ?? null) === ($friend->linkedUser->getAttributes()['avatar'] ?? null ?: '___');

        if ($friend->avatar && !$sharedAvatar && Storage::disk('public')->exists($friend->avatar)) {
            Storage::disk('public')->delete($friend->avatar);
        }
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
                $data = base64_decode($data, true);

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
