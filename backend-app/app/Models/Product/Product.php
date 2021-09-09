<?php

declare(strict_types=1);

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int          $id
 * @property string       $name
 * @property ProductPrice $price
 */
class Product extends Model
{
    use SoftDeletes, HasFactory;

    public const TABLE_NAME       = 'products';
    public const FOREIGN_KEY_NAME = 'product_id';

    protected $table = self::TABLE_NAME;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function price()
    {
        return $this->hasOne(ProductPrice::class, self::FOREIGN_KEY_NAME, 'id');
    }
}
