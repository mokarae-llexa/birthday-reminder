<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = [
            [
                'id' => 1,
                'title' => 'its pharita day now!',
                'message' => "Don't forget to send her some birthday wishes.",
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
                'button_text' => 'Send Wishes',
                'url' => '#'
            ],
            [
                'id' => 2,
                'title' => 'its pharita day now!',
                'message' => "Don't forget to send her some birthday wishes.",
                'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150',
                'button_text' => 'View Profile',
                'url' => '#'
            ],
            [
                'id' => 3,
                'title' => 'its pharita day now!',
                'message' => "Don't forget to send her some birthday wishes.",
                'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=150',
                'button_text' => 'View',
                'url' => '#'
            ],
            [
                'id' => 4,
                'title' => 'its pharita day now!',
                'message' => "Don't forget to send her some birthday wishes.",
                'avatar' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=150',
                'button_text' => 'View',
                'url' => '#'
            ]
        ];

        return view('notifications.index', compact('notifications'));
    }
}