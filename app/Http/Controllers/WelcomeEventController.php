<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\User;
use Illuminate\Http\Request;

class WelcomeEventController extends Controller
{
    public $user;

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /*
     * Calling Event with method.
     * @return array
     */
    public function display()
    {
        $user = [
            'name' => 'Testuser',
            'email' => 'testuser@gmail.com',
        ];
        //call Event
        //UserRegistered::dispatch($user);
        event(new UserRegistered($user));
    }
}
