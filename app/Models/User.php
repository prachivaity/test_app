<?php

namespace Chatty\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Chatty\Models\Status;



class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $table='users';
    protected $fillable = [
        'username', 'email', 'password',
        'first_name',
        'last_name',
        'location',
        'department',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getName()
    {
        if($this->first_name && $this->last_name){
            return"{$this->first_name} {$this->last_name}";
        }
        if ($this->first_name){
            return $this->first_name;
        }
        return null;
    }
    


    public function getNameOrUsername(){
    return $this->getName() ?: $this->username;
    }

    public function getAvatarUrl(){
        return "https://www.gravatar.com/avatar/{{md5($this->email)}}?d=mm&s=60";
    }

    public function statuses(){
        return $this->hasMany('Chatty\Models\Status','user_id');
    }

      public function likes(){
        return $this->hasMany('Chatty\Models\Like','user_id');
    }



    public function friendsOfMine(){
        return $this->belongsToMany('Chatty\Models\User' , 'friends','user_id','friend_id');
    }

public function friendOf(){
        return $this->belongsToMany('Chatty\Models\User' , 'friends','friend_id','user_id');
    }

    public function friends(){
        return $this -> friendsOfMine()->wherePivot('accepted',true)->get()->merge($this->friendOf()->wherePivot('accepted',true)->get()); 
    }


    public function friendRequests(){
        return $this->friendsOfMine()->wherePivot('accepted',false)->get();
    }

    public function friendRequestsPending(){
        return $this->friendOf()->wherePivot('accepted',false)->get();
    }

    public function hasFriendRequestPending(User $user){
        return (bool) $this->friendRequestsPending()->where('id',$user->id)->count();
    }

    public function hasFriendRequestReceived(User $user){
        return (bool) $this->friendRequests()->where('id',$user->id)->count();
    }

    public function addFriend(User $user){
        $this->friendOf()->attach($user->id);
    }

    public function deleteFriend(User $user){
        $this->friendOf()->detach($user->id);
    }

    public function acceptFriendRequest(User $user){
        $this->friendRequests()->where('id',$user->id)->first()->pivot->update(['accepted'=>true,
            ]);
    }

    public function isFriendsWith(User $user){
        return (bool) $this->friends()->where('id',$user->id)->count();
    }

    public function hasLikedStatus(Status $status){
        return (bool) $status->likes->where('user_id',$this->id)->count();
    }


}