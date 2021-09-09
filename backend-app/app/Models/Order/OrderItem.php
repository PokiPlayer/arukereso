<?php

declare(strict_types=1);

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Database\Eloquent\Casts\CurrencyCast;
use App\Enum\CurrencyEnum;
use App\Models\Product\Product;

/**
 * @property int          $id
 * @property int          $order_id
 * @property int          $product_id
 * @property int          $quantity
 * @property float        $unit_net_price
 * @property float        $unit_gross_price
 * @property float        $tax
 * @property CurrencyEnum $currency
 */
class OrderItem extends Model
{
    use SoftDeletes;

    public const TABLE_NAME = 'order_items';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        Order::FOREIGN_KEY_NAME,
        Product::FOREIGN_KEY_NAME,
        'quantity',
    ];

    protected $casts = [
        'currency' => CurrencyCast::class
    ];

    /**
     * @inheritDoc
     */
    public function __toString() {
        return sprintf('%s_%s', (int)$this->order_id, (int)$this->product_id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, Order::FOREIGN_KEY_NAME)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, Product::FOREIGN_KEY_NAME)->withTrashed();
    }
}
