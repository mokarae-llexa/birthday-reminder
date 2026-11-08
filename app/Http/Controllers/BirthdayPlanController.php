<?php

namespace App\Http\Controllers;

use App\Models\BirthdayPlan;
use App\Models\Friend;
use Illuminate\Http\Request;

class BirthdayPlanController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'friend_id' => ['required', 'exists:friends,id'],
            'title'     => ['required', 'string', 'max:150'],
            'due_date'  => ['nullable', 'date'],
        ]);

        // hanya boleh untuk teman milik user yang login
        $friend = Friend::where('created_by', auth()->id())->findOrFail($data['friend_id']);

        BirthdayPlan::create([
            'user_id'   => auth()->id(),
            'friend_id' => $friend->id,
            'title'     => $data['title'],
            'due_date'  => $data['due_date'] ?? null,
        ]);

        return back()->with('success', 'Preparation added.');
    }

    public function toggle(BirthdayPlan $plan)
    {
        abort_unless((int) $plan->user_id === (int) auth()->id(), 404);
        $plan->update(['is_done' => !$plan->is_done]);

        return back();
    }

    public function destroy(BirthdayPlan $plan)
    {
        abort_unless((int) $plan->user_id === (int) auth()->id(), 404);
        $plan->delete();

        return back()->with('success', 'Preparation deleted.');
    }
}