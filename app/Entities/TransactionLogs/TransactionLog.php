<?php

namespace App\Entities\TransactionLogs;

use App\Entities\CashRegisters\CashRegister;
use Database\Factories\TransactionLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class TransactionLog
 * 
 * @author Alexander Pedrozo Solano
 */
class TransactionLog extends Model
{
    use HasFactory;
    
    protected $table = 'transaction_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'type',
        'value',
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
    public function cashRegister(): BelongsToMany
    {
        return $this->belongsToMany(CashRegister::class)->withPivot('cash_register_quantity');
    }    

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TransactionLogFactory::new();
    }

}
