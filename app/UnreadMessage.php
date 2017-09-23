<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class UnreadMessage extends Model
{
    protected $table = 'unread_messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_id', 'message_id',
    ];
}