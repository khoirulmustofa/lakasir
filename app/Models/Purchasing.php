<?php

namespace App\Models;

use App\DataTables\PurchasingTable;
use App\Traits\HasLog;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLaTable;

class Purchasing extends Model
{
    use HasLaTable, HasLog;

    protected $latable = PurchasingTable::class;

    protected $fillable = [
        'date',
        'invoice_number',
        'total_initial_price',
        'total_selling_price',
        'total_qty',
        'note',
        'is_paid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }


    public function purchasingDetails()
    {
        return $this->hasMany(PurchasingDetail::class, 'purchasing_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function getPaidAttribute()
    {
        return view('app.transaction.purchasings.components.partials.paid', ['paid' => $this->is_paid]);
    }

    public function getTotalPurchasingAttribute()
    {
        $totalPurchasing = 0;
        foreach ($this->purchasingDetails as $purchasingDetail) {
            $totalPurchasing += $purchasingDetail->qty * $purchasingDetail->initial_price;
        }

        return price_format($totalPurchasing);
    }
}
