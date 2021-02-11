<?php

namespace App\Http\Controllers;

use App\Message;
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
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'receiver_id' => 'required'
        ]);
        $sender_id = Auth::id();
        $receiver_id = $request->receiver_id;

        $msg = new Message();
        $msg->message = $request->message;

        if ($msg->save()) {
            try {
                $msg->users()->attach($sender_id, ['receiver_id' => $receiver_id]);
                $sender = User::where('id', $sender_id)->first();

                $data = [];
                $data['sender_id'] = $sender_id;
                $data['sender_name'] = $sender->name;
                $data['receiver_id'] = $receiver_id;
                $data['content'] = $msg->message;
                $data['created_at'] = $msg->created_at;
                $data['message_id'] = $msg->id;

                return response()->json([
                    'data' => $data,
                    'success' => true,
                    'message' => 'Message sent successfully'
                ]);
            } catch (\Throwable $th) {
                $msg->delete();
            }
        }
    }
}
