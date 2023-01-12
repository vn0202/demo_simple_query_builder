<?php

namespace  Vannghia\SimpleQueryBuilder;

use Vannghia\SimpleQueryBuilder\Interfaces\Arrayable;
use Vannghia\SimpleQueryBuilder\Interfaces\Jsonable;

class Data implements Jsonable, Arrayable
{
    use  HasAttributes;

    public function toJson($option = 0)
    {
        // TODO: Implement toJson() method.
    }

    public function toArray()
    {
        // TODO: Implement toArray() method.
    }

    public static function from(array $attributes)
    {
        $instance = new static();
        return $instance->setAttributes($attributes);

    }

    public static function collection(array $items)
    {
        $items = array_map(function ($item) {
            if ($item instanceof static) {
                return $item;
            }
            return static::from($item);


        }, $items);

        return new Collection($items);
    }



}

