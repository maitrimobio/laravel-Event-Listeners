<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\User;
use Illuminate\Http\Request;

class WelcomeEventController extends Controller
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function display()
    {
        $user = [
            'name' => 'Maitri',
            'email' => 'maitris.mobio@gmail.com',
        ];
        //call Event
        //UserRegistered::dispatch($user);
        event(new UserRegistered($user));
    }
}
