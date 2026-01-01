<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Public marketing pages (landing, about, contact).
 */
class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        return view('home', [
            'features' => [
                [
                    'icon' => '🎯',
                    'title' => 'Track Goals',
                    'description' => 'Set daily, weekly, and boss quests to achieve your dreams.'
                ],
                [
                    'icon' => '🔥',
                    'title' => 'Build Habits',
                    'description' => 'Build streaks and turn positive actions into lasting habits.'
                ],
                [
                    'icon' => '⚡',
                    'title' => 'Level Up',
                    'description' => 'Earn XP, gain levels, and watch yourself grow into a hero.'
                ],
            ],
            'contact' => [
                'email' => 'support@levelup.com',
                'discord' => 'Join our community',
                'twitter' => '@LevelUpApp'
            ]
            
        ]);
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('contact');
    }
}
