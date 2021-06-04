<?php

namespace MonerisAssignment\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Simple Customer Model with relations with User, PaymentMethod and Transaction models
 */

class Customer extends Model
{
    use HasFactory;

    /**
     * Customer to User models relation. Customer belongs to 1 User, User have 1 Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Customer to PaymentMethod models relation.
     * Customer can have more then 1 PaymentMethods,
     * Payment method belongs to 1 Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentMethods() {
        return $this->hasMany(PaymentMethod::class);
    }

    /**
     * Customer to Transactions Models relation
     * Customer can have more then 1 Transaction,
     * Transaction belongs to 1 Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Returns Default PaymentMethod associated with Customer
     *
     * @return PaymentMethod
     */
    public function getDefaultPaymentMethod() {
        return PaymentMethod::where('customer_id', '=', $this->id)->
                        where('is_default', '=', 1)->
                        first();
    }

}
