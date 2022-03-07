<?php
namespace Sashsvamir\LaravelUserCRUD\Models;


use Illuminate\Database\Eloquent\Builder;


/**
 * @property int|null $notify
 * @property int|null $notify_spam
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User notifiable()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User notifiableSpam()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNotify($value)
 */
trait UserNotifyTrait
{

    public function initializeUserNotifyTrait()
    {
        $this->fillable = array_merge($this->fillable, [
            'notify',
            'notify_spam',
        ]);

        $this->casts = array_merge($this->casts, [
            'notify' => 'boolean',
            'notify_spam' => 'boolean',
        ]);
    }

    public function scopeNotifiable(Builder $query)
    {
        return $query->where('notify', 1);
    }

    public function scopeNotifiableSpam(Builder $query)
    {
        return $query->where('notify_spam', 1);
    }

}

