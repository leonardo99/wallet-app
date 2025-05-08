<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function getDate(): string
    {
        return Carbon::parse($this->created_at)->translatedFormat('j \d\e F - H\hi');
    }
    public function getHour(): string
    {
        return Carbon::parse($this->created_at)->translatedFormat('H\hi');
    }

    public function getAmount(): string
    {
        $accountUser = auth()->user()->account->id;
        if($accountUser === $this->sender_account_id) {
            return "- {$this->getAmountFormated()}";
        }
        if($accountUser === $this->receiver_account_id) {
            return "+ {$this->getAmountFormated()}";
        }
        return $this->getAmountFormated();
    }

    public function getTypeTransaction(): string
    {
        $accountUser = auth()->user()->account->id;
        if($accountUser === $this->sender_account_id) {
            return "output";
        }
        if($accountUser === $this->receiver_account_id) {
            return "input";
        }
        return "desconhecido";
    }

    public function getStatusTransaction(): string
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
        return "Status desconhecido";
    }

    public function getBeneficiary(): string
    {
        $accountUser = auth()->user()->account->id;
        if($this->status === 'refunded') {
            if($accountUser === $this->sender_account_id) {
                return $this->receiverAccount->user->name;
            }
            if($accountUser === $this->receiver_account_id) {
                return $this->senderAccount->user->name;
            }
            return $this->senderAccount->user->name;
        }
        if($this->status === 'completed') {
            if($this->type === 'deposit') {
                return $this->receiverAccount->user->name;
            }
            if($accountUser === $this->sender_account_id) {
                return $this->receiverAccount->user->name;
            }
            if($accountUser === $this->receiver_account_id) {
                return $this->senderAccount->user->name;
            }
        }
        return "Desconhecido";
    }

    public function getAmountFormated(): string
    {
        $formatCurrency = new NumberFormatter('pt_BR', NumberFormatter::CURRENCY);
        return $formatCurrency->formatCurrency($this->amount, 'BRL');
    }

    public function senderAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'sender_account_id');
    }
    
    public function receiverAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'receiver_account_id');
    }
}
