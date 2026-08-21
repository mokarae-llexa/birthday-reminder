<?php
namespace App\Http\Controllers;
use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index() //show all friends data
    {
        $friends = Friend::latest()->get();

        return view('friends.index', compact('friends'));
    }

    public function create() //show form data
    {
        return view('friends.create');
    }


    public function store(Request $request) //saving friends data
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Friend::create($validated);

        return redirect()
            ->route('friends.index')
            ->with('success', 'Data teman berhasil ditambahkan.');
    }

    public function edit(Friend $friend) //show form
    {
        return view('friends.edit', compact('friend'));
    }

    public function update(Request $request, Friend $friend) //update data
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $friend->update($validated);
        return redirect()
            ->route('friends.index')
            ->with('success', 'Data teman berhasil diperbarui.');
    }

    public function destroy(Friend $friend) //delete data
    {
        $friend->delete();
        return redirect()
            ->route('friends.index')
            ->with('success', 'Data teman berhasil dihapus.');
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
}
