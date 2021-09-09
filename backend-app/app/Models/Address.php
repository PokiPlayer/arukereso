<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $city
 * @property string $postcode
 * @property string $address
 */
abstract class Address extends Model
{

}
