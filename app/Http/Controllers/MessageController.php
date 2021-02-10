<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function conversation($userId)
    {
        $users = User::where('id', '!=', Auth::id())->get();
        $friendInfo = User::findOrFail($userId);
        $myinfo = User::find(Auth::id());

        $this->data['users'] = $users;
        $this->data['friendInfo'] = $friendInfo;
        $this->data['myinfo'] = $myinfo;
        $this->data['userId'] = $userId;

        return view('message.conversation', $this->data);
    }
}
