<?php

namespace MonerisAssignment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PaymentMethod
 * @package MonerisAssignment\Models
 */
class PaymentMethod extends Model
{
    use HasFactory;

    // Using SoftDelete for keeping Transactions table usable even if Payment Method was "deleted" by customer.
    // Will need to garble/mask the card_number in payment method table on softDelete event
    use SoftDeletes;

    /**
     * PaymentMethod to Customer models relation.
     * Customer can have more then 1 PaymentMethods,
     * Payment method belongs to 1 Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * PaymentMethod to Transaction models relation
     * PaymentMethod can have more then one Transactions
     * Transaction can have 1 PaymentMethod
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * returns MMYY formatted date for Moneris Charge request data
     *
     * @return false|string
     */
    public function getExpDateMMYY()
    {
        return date("my", strtotime($this->exp_date));
    }
}
