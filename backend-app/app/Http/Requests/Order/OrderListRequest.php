<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Contracts\Repositories\Order\OrderRepositoryInterface;
use App\Enum\Order\OrderStatusEnum;
use App\Http\Requests\FormRequest;

class OrderListRequest extends FormRequest
{

    public const FIELD_ID           = 'id';
    public const FIELD_STATUS       = 'status';
    public const FIELD_CREATED_FROM = 'from';
    public const FIELD_CREATED_TO   = 'to';
    public const FIELD_USER         = 'user_id';

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function validationData()
    {
        $now  = new \DateTime();
        parent::validationData();

        if (!isset($this[self::FIELD_CREATED_FROM])) {
            /** @var OrderRepositoryInterface $repository */
            $repository                     = $this->container->get(OrderRepositoryInterface::class);
            $firstDate                      = $repository->findFirstOrderCreatedDate();
            $this[self::FIELD_CREATED_FROM] = null !== $firstDate ? $firstDate->format('Y-m-d H:i:s') : $now->format(
                'Y-m-d H:i:s'
            );
        }

        if (!isset($this[self::FIELD_CREATED_TO])) {
            $this[self::FIELD_CREATED_TO] = $now->format('Y-m-d H:i:s');
        }

        $currentUser            = Auth::user();
        $this[self::FIELD_USER] = $currentUser->id;

        return $this->all();
    }

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            self::FIELD_ID           => 'numeric',
            self::FIELD_STATUS       => [
                'string',
                Rule::in(OrderStatusEnum::getEnumValues()),
            ],
            self::FIELD_CREATED_FROM => 'date|date_format:Y-m-d H:i:s',
            self::FIELD_CREATED_TO   => 'date|after_or_equal:from|date_format:Y-m-d H:i:s',
            self::FIELD_USER         => 'required|numeric|exists:users,id',
        ];
    }
}
