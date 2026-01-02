<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function ban_user(User $user){
        if(Auth::user()->is_support == 1){
            $user->is_banned = 1;
            $user->save();
        }else{
            abort(403 , 'You cannot ban user! You are not support!');
        }
    }
    public function unban_user(User $user){
        if(Auth::user()->is_support ==1 ){
            $user->is_banned = 0;
            $user->save();
        }else{
            abort(403 , 'You cannot unban user! You are not support!');
        }
    }
}
