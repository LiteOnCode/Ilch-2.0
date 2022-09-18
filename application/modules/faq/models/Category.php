<?php
/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Faq\Models;

class Category extends \Ilch\Mapper
{

    private $id;
    private $title;
    private $read_access;


    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }


    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

}
