<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Laravel\Cashier\BillableInterface;
use Laravel\Cashier\BillableTrait;

/**
 * Class User
 */
class User extends Eloquent implements UserInterface, RemindableInterface, BillableInterface{
    use BillableTrait;
    /**
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * @var array
     */
    protected $fillable = ['email','first_name','last_name','password','display_name','profile_image','phone_number','address1','address2','city','state','zip','lat','lng','employer_role','contractor_role','avg_rating'];
    /**
     * @var bool
     */
    protected $softDelete = true;
    /**
     * @var array
     */
    protected $dates = array('employer_role','contractor_role','trial_ends_at','subscription_ends_at');
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     *
     */
    public static function boot(){
        parent::boot();
        static::deleted(function($model){
            $model->jobs()->delete();
            $model->skills()->detach();
            $model->ratingsByUser()->delete();
            $model->ratingsForUser()->delete();
            $model->groups()->detach();

            //find user
            //record skill: 40
            //find a rating and mark by who
                //rating for: 143
                //rating by:134
            //find a job: 265
            //check that their are no longer in user group

        });
    }

    /**
     * @param $pass
     */
    public function setPasswordAttribute($pass){
        $this->attributes['password'] = Hash::make($pass);
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills(){
        return $this->belongsToMany('Skill','skill_user','user_id','skill_id')->withPivot('id','skill_id','user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs(){
        return $this->hasMany('Job','posted_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratingsByUser(){
        return $this->hasMany('Rating','rating_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratingsForUser(){
        return $this->hasMany('Rating','rating_for');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups(){
        return $this->belongsToMany('Group','users_groups','user_id','group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function charges(){
        return $this->hasMany('Charge','user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites(){
        return $this->belongsToMany('Job','user_favorites_jobs','user_id','job_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usersgroups(){
        return $this->hasMany('UserGroup','user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function days(){
        return $this->belongsToMany('Day','day_user','user_id','day_id');
    }
}