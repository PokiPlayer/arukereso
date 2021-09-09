<?php

declare(strict_types=1);

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest as BaseRequest;

class FormRequest extends BaseRequest
{
    /**
     * @return mixed
     */
    public function validationData()
    {
        $this->replace($this->snakeCase($this->all()));

        return $this->all();
    }

    /**
     * @param array $array
     *
     * @return array
     */
    public function snakeCase(array $array): array
    {
        return array_map(
            function($item) {
                if (is_array($item)) {
                    $item = $this->snakeCase($item);
                }

                return $item;
            },
            $this->doSnakeCase($array)
        );
    }

    /**
     * @param array $array
     *
     * @return array
     */
    protected function doSnakeCase(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $key = strtolower(preg_replace('~(?<=\\w)([A-Z])~', '_$1', $key));

            $result[$key] = $value;
        }

        return $result;
    }
}
