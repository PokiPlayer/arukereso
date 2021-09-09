<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enum\CurrencyEnum;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;

/**
 * @mixin Order
 */
class OrderListItemResource extends JsonResource
{
    /**
     * @inheritDoc
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'orderStatus'  => $this->order_status->getValue(),
            'customerName' => $this->customer_name,
            'createdAt'    => $this->created_at->format('Y-m-d H:i:s'),
            'totalPrice'   => $this->calculateTotalOrder(),
            'currency'     => CurrencyEnum::HUF,
        ];
    }

    /**
     * @return float
     */
    protected function calculateTotalOrder(): float
    {
        $total = 0.00;

        foreach ($this->items as $item) {
            /** @var OrderItem $item */
            $total += $item->unit_gross_price * $item->quantity;
        }


        return $total;
    }
}
