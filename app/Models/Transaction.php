<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['sender_account_id', 'receiver_account_id', 'reversed_transaction_id', 'amount', 'type', 'status'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function getDate()
    {
        return Carbon::parse($this->created_at)->translatedFormat('j \d\e F - H\hi');
    }

    public function senderAccount()
    {
        return $this->belongsTo(Account::class, 'sender_account_id');
    }
    
    public function receiverAccount()
    {
        return $this->belongsTo(Account::class, 'receiver_account_id');
    }
}
