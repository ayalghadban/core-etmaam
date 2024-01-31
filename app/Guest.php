<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class Guest extends Model
{
    use Notifiable, HasPushSubscriptions;
    protected $fillable = [
        'endpoint',
    ];
    /**
     * Determine if the given subscription belongs to this user.
     *
     * @param  \NotificationChannels\WebPush\PushSubscription $subscription
     * @return bool
     */
    /*
    This method checks if a given push subscription belongs to the current user (`Guest`).
    It takes a `PushSubscription` object as a parameter and compares the 'guest_id' attribute of
    the subscription with the 'id' attribute of the current `Guest` instance. The `(int)` casting ensures
    that the values are compared as integers.
    In summary, this code defines a `Guest` model with the ability to handle web push subscriptions.
    It includes a method to check if a given push subscription belongs to a particular guest based on their IDs.
    This is particularly useful for managing and associating push subscriptions with guest users
    in a Laravel application.
    */

    public function pushSubscriptionBelongsToUser($subscription)
    {
        return (int) $subscription->guest_id === (int) $this->id;
    }
}
