<?php

namespace  Vannghia\SimpleQueryBuilder;

use Vannghia\SimpleQueryBuilder\Interfaces\CollectionInterface;

class Collection implements CollectionInterface
{

    private $elements = [];

    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    public function __toString()
    {
        return self::class . "@" . spl_object_hash($this);
    }

    public function createFrom(array $element)
    {
        return new static($element);
    }

    public function filter($callBack)
    {
        // TODO: Implement filter() method.
        return array_filter($this->elements, $callBack, ARRAY_FILTER_USE_BOTH);
    }

    public function add($element)
    {
        // TODO: Implement add() method.
        $this->elements[] = $element;
        return true;
    }

    public function last()
    {
        // TODO: Implement last() method.
        return end($this->elements);
    }

    public function isEmpty()
    {
        // TODO: Implement isEmpty() method.
        return empty($this->elements);
    }

    public function clear()
    {
        // TODO: Implement clear() method.
        $this->elements = [];
    }

    public function all()
    {
        return $this->elements;
    }

    public function count()
    {
        // TODO: Implement count() method.
        return $this->count($this->elements);
    }

    public function toArray()
    {
        // TODO: Implement toArray() method.
        $result = [];
        foreach ($this->elements as $element) {
            $result[] = $element->getAttributes();
        }
        return $result;
    }

    public function map($callBack)
    {
        // TODO: Implement map() method.
        return array_map($callBack, $this->elements);
    }

    public function first()
    {
        // TODO: Implement first() method.
        return reset($this->elements);
    }

    public function getIterator()
    {
        // TODO: Implement getiterator() method.
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
        return isset($this->elements[$offset]);
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
        if ($this->offsetExists($offset)) {
            return $this->elements[$offset];
        }
        return null;
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
        $this->elements[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }


//    public function sortBy($key, $mode = 'asc')
//    {
//        $items = $this->toArray();
//        if (array_key_exists($key,$items[0])) {
//            $mode = strtolower($mode);
//            $array_column = array_column($items, $key);
//            for ($i = 0; $i < count($array_column) - 1; $i++) {
//                for ($j = $i + 1; $j < count($array_column); $j++) {
//                    if ($mode === "asc") {
//                        if ($array_column[$i] > $array_column[$j]) {
//                            Helpers::swapArray($items[$i], $items[$j]);
//                        }
//                    } else {
//                        if ($array_column[$i] < $array_column[$j]) {
//                            Helpers::swapArray($items[$i], $items[$j]);
//                        }
//                    }
//                }
//            }
//            return $items;
//        }
//        throw  new \Exception("The field is invalid. Please choose again!");
//    }

}