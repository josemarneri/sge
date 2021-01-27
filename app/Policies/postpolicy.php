<?php

namespace App\Policies;
use App\User;
use App\post;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class postpolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function updatePost(User $user, post $post){
       return $user->id == $post->user_id;
        //return true;
        //$valid = $user->name == "josemar";
    	//$valid = $user->id == $notice->user_id;
    	//return $valid;
    }
    
    public function before(User $user){
       //return $user->name == 'julia';
        return true;
    }
}
