<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    //
    function addMessage(Request $request){
        // search for validation 
            $data = $request->all();
            $message = new Message;
            $message->email = $data["email"];
            $message->subject = $data["subject"];
            $message->message = $data["message"];
            $message->save();

        return response()->json(["success" => true]);

    }
}
