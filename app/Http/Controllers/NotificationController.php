<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
{
    $notification= [
        [
            'title' => 'It’s Pharita day now!',
            'message' => 'Don’t forget to send her some birthday wishes.',
            'url' => '#',
            'button_text' => 'Send Wishes'
        ],
        [
            'title' => 'Elva’s birthday is tomorrow!',
            'message' => 'Get ready to send a special gift or message.',
            'url' => '#',
            'button_text' => 'View Profile'
        ],
        [
            'title' => 'Neysa is turning another year older!',
            'message' => 'Greet her and make her day happier.',
            'url' => '#',
            'button_text' => 'View'
        ],
        [
            'title' => 'Diana’s big day is coming soon!',
            'message' => 'Let’s prepare a surprise wish together.',
            'url' => '#',
            'button_text' => 'View'
        ],
    ];

    return view('notifications.index', compact('notification'));
}
}