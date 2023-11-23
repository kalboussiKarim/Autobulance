<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Localisation ; 
use App\Models\Staff  ; 

class SendLocalisation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   
    //  public Localisation $localisation ; 
    //  public Staff  $manager ; 
    public function __construct()
    
    {
        //$this->localisation = $localisation;
        
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
         return [
     new Channel('public.localisation'),
 ];
    }
     public function broadcastAs(): string
 {
    return 'pushLocalisation';
 }
 public function broadcastWith(): array
{

    return [ "longitude"=>10 , "lattitude"=>10 ,"autobulance_id"=>1 , "manager"=>"manager_name","manager_tel"=>1122233 , "autobulance_mat"=>"124TUN141"];
}
}
