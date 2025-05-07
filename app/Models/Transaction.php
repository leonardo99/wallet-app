<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use NumberFormatter;

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

    public function getAmount()
    {
        $accountUser = auth()->user()->account->id;
        if($accountUser === $this->sender_account_id) {
            return "- {$this->getAmountFormated()}";
        }
        if($accountUser === $this->receiver_account_id) {
            return "+ {$this->getAmountFormated()}";
        }
    }

    public function getStatusTransaction()
    {
        $accountUser = auth()->user()->account->id;
        if($this->status === 'refunded') {
            return "Transferência devolvida";
        }
        if($this->status === 'completed') {
            if($this->type === 'deposit') {
                return "Depósito recebido";
            }
            if($accountUser === $this->sender_account_id) {
                return "Transferência enviada";
            }
            if($accountUser === $this->receiver_account_id) {
                return "Transferência recebida";
            }
        }
    }

    public function getAmountFormated()
    {
        $formatCurrency = new NumberFormatter('pt_BR', NumberFormatter::CURRENCY);
        return $formatCurrency->formatCurrency($this->amount, 'BRL');
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
