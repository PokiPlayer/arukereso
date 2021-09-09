<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use Illuminate\Validation\Rule;
use App\Enum\Order\OrderStatusEnum;
use App\Http\Requests\FormRequest;

class OrderModifyRequest extends FormRequest
{
    public const FIELD_ORDER_STATUS = 'order_status';

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            self::FIELD_ORDER_STATUS => [
                'required',
                'string',
                Rule::in(OrderStatusEnum::getEnumValues()),
            ],
        ];
    }
}
