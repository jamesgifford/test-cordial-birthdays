<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Person extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The name of the MongoDB collection
     *
     * @var string
     */
    protected $collection = 'people';

    /**
     * Custom attributes added to serialized data.
     *
     * @var array
     */
    protected $appends = [
        'isBirthday', 'age', 'interval', 'message',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'birthdate', 'timezone',
    ];

    /**
     * Fields hidden from serialized data.
     *
     * @var array
     */
    protected $hidden = [
        '_id', 'created_at', 'updated_at'
    ];

    /**
     * Check whether today is the person's birthday
     *
     * @return boolean
     */
    public function getIsBirthdayAttribute()
    {
        $today = Carbon::now()->timezone($this->timezone);
        $birthdate = Carbon::parse($this->birthdate);

        return $birthdate->month == $today->month &&
                $birthdate->day == $today->day;
    }

    /**
     * Get the person's current age
     *
     * @return int
     */
    public function getAgeAttribute()
    {
        return Carbon::now()->timezone($this->timezone)
            ->diffInYears(Carbon::parse($this->birthdate));
    }

    /**
     * The duration until the person's next birthday
     *
     * @return array
     */
    public function getIntervalAttribute()
    {
        return $this->interval ?? $this->getInterval(Carbon::now()->timezone($this->timezone));
    }

    /**
     * Set the interval based on a future date
     *
     * @return void
     */
    public function setIntervalAttribute(Carbon $date)
    {
        $this->interval = $this->getInterval($date);
    }

    /**
     * A message describing the duration to the person's next birthday
     *
     * @return string
     */
    public function getMessageAttribute()
    {
        $message = sprintf('%s will turn %d years old in ', $this->name,
            $this->age + (int)$this->interval['y'] + 1
        );

        if ((int)$this->interval['y']) {
            $message .= sprintf('%d years, ', $this->interval['y']);
        }

        if ((int)$this->interval['m']) {
            $message .= sprintf('%d months, ', $this->interval['m']);
        }

        $message .= sprintf('%d days in %s', $this->interval['d'], $this->timezone);

        return $message;
    }

    /**
     * The duration to a person's next birthday from a specified date
     *
     * @var Carbon date
     * @return array
     */
    public function getInterval(Carbon $date)
    {
        $date->timezone($this->timezone);
        $today = Carbon::now()->timezone($this->timezone);

        if ($date < $today) {
            $date = $today->copy();
        }

        $birthday = Carbon::parse($this->birthdate);
        $birthday->year($date->year);

        if ($date->diffInDays($birthday, false) <= 0) {
            $birthday->addYear();
        }

        return array_combine(['y', 'm', 'd', 'h', 'i', 's'],
            explode('-', $birthday->diff($today)->format('%Y-%m-%d-%H-%I-%S')));
    }
}
