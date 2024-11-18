<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;
use App\Models\UserAttributesUpdate;

final class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        /** Uncomment if created users can also be "registered" using the batch update */

//        UserAttributesUpdate::createUpdate(
//            $user, [
//                "name" => $user->full_name,
//                "time_zone" => $user->time_zone,
//            ],
//        );
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $changedAttributes = $user->getDirty();

        if (!empty($changedAttributes)) {
            UserAttributesUpdate::createUpdate(
                $user, $changedAttributes
            );
        }
    }
}
