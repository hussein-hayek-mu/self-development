<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index(): Response
    {
        return Inertia::render('Home', [
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
    public function about(): Response
    {
        return Inertia::render('About');
    }

    /**
     * Display the contact page.
     */
    public function contact(): Response
    {
        return Inertia::render('Contact');
    }
}
