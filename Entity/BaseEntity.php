<?php

namespace zer0latency\KladrBundle\Entity;

/**
 * BaseEntity class
 */
class BaseEntity implements \Symfony\Component\Validator\Tests\Fixtures\EntityInterface
{

    /**
     * Build entity from array
     *
     * @param array $values
     *
     * @return \zer0latency\KladrBundle\Entity\Altnames
     */
    public function deserialize($values)
    {
        foreach ($values as $name => $value) {
            $field = strtolower($name);
            if ($field === 'index') {
                $field = 'postIndex';
            }
            $methodName = 'set'.ucfirst($field);

            if ( !method_exists($this, $methodName) ) {
                continue;
            }

            $type = gettype($this->$field);
            if ( $type === 'integer' ) {
                $value = intval($value);
            } else {
                $value = trim(iconv('cp866', 'utf8', $value));
            }

            $this->$methodName($value);
        }

        return $this;
    }

}
