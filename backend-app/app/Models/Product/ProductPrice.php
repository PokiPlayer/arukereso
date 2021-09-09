<?php

declare(strict_types=1);

namespace App\Models\Product;

use App\Models\Price;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $product_id
 */
class ProductPrice extends Price
{
    use SoftDeletes, HasFactory;

    public const TABLE_NAME = 'product_prices';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        Product::FOREIGN_KEY_NAME,
        'net_price',
        'gross_price',
        'tax',
        'currency',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, Product::FOREIGN_KEY_NAME)->withTrashed();
    }
}
