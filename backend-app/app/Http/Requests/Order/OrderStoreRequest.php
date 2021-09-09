<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use Illuminate\Validation\Rule;
use App\Enum\Order\DeliveryModeEnum;
use App\Http\Requests\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public const FIELD_CUSTOMER_NAME    = 'customer_name';
    public const FIELD_CUSTOMER_EMAIL   = 'customer_email';
    public const FIELD_DELIVERY_MODE    = 'delivery_mode';
    public const FIELD_SHIPPING_ADDRESS = 'shipping_address';
    public const FIELD_BILLING_ADDRESS  = 'billing_address';
    public const FIELD_ITEMS            = 'items';

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            self::FIELD_CUSTOMER_NAME    => 'required',
            self::FIELD_CUSTOMER_EMAIL   => 'required',
            self::FIELD_DELIVERY_MODE    => [
                'required',
                'string',
                Rule::in(DeliveryModeEnum::getEnumValues()),
            ],
            self::FIELD_SHIPPING_ADDRESS => 'required_if:delivery_mode,=,shipping',
            'shipping_address.city'      => 'string|max:128',
            'shipping_address.postcode'  => 'string|max:128',
            'shipping_address.address'   => 'string|max:256',
            self::FIELD_BILLING_ADDRESS  => 'required|array',
            'billing_address.city'       => 'required|string|max:128',
            'billing_address.postcode'   => 'required|string|max:128',
            'billing_address.address'    => 'required|string|max:256',
            self::FIELD_ITEMS            => 'required|array',
            'items.*.product_id'         => 'required|exists:products,id',
            'items.*.quantity'           => 'required|numeric|min:1',
        ];
    }
}
