<?php

namespace App\Entities\CashRegisters;

use App\Entities\TransactionLogs\TransactionLog;
use Database\Factories\CashRegisterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class CashRegister
 * 
 * @author Alexander Pedrozo Solano
 */
class CashRegister extends Model
{
    use HasFactory;
    
    /**
     * @var string
     */
    protected $table = 'cash_registers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'denomination',
        'value',
        'quantity',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsToMany
     */
    public function transactionLogs(): BelongsToMany
    {
        return $this->belongsToMany(TransactionLog::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CashRegisterFactory::new();
    }

}
