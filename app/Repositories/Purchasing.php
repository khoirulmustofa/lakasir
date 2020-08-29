<?php

namespace App\Repositories;

use App\Abstracts\Repository as RepositoryAbstract;
use App\Builder\NumberGeneratorBuilder;
use App\Traits\HasParent;
use Illuminate\Http\Request;

class Purchasing extends RepositoryAbstract
{
    use HasParent;

    protected string $model = 'App\Models\Purchasing';

    public function datatable(Request $request)
    {
        $paymentMethd = new PaymentMethod();
        $user = new User();
        $purchasing = $this->model::toBase()->addSelect([
            'payment_method' => $paymentMethd->getModel()::select('name')->whereColumn('payment_method_id', 'payment_methods.id')->latest()->limit(1),
            'user' => $user->getModel()::select('username')->whereColumn('user_id', 'users.id')->latest()->limit(1)
        ])->latest()->get();

        return $this->getObjectModel()->table($purchasing);
    }
}
