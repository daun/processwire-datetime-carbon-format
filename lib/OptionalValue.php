<?php

namespace Daun;

/**
 * Provide access to optional objects.
 *
 * Allow arrow-syntax access of optional objects by using a higher-order
 * proxy object. The eliminates some need of ternary and null coalesce
 * operators in templates.
 *
 */

class OptionalValue implements \Stringable
{
    /**
     * Create a new instance.
     *
     * @param  mixed  $value
     * @return void
     */
    public function __construct(protected $value)
    {
    }

    /**
     * Create an optional object.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public static function make($value = null)
    {
        if (is_object($value)) {
            $value->empty = false;
            return $value;
        }
        return new OptionalValue($value);
    }

    /**
     * Dynamically access a property on the underlying object.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($key === 'empty' && !isset($this->value->empty)) {
            return !is_object($this->value);
        }
        if (is_object($this->value)) {
            return $this->value->{$key} ?? null;
        }
    }

    /**
     * Dynamically check a property exists on the underlying object.
     *
     * @param  mixed  $name
     * @return bool
     */
    public function __isset($name)
    {
        if (is_object($this->value)) {
            return isset($this->value->{$name});
        }
        return false;
    }

    /**
     * Dynamically pass a method call to the underlying object.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (is_object($this->value)) {
            return $this->value->{$method}(...$parameters);
        }
    }

    /**
     * Dynamically pass a string coercion call to the underlying object.
     *
     * @return string
     */
    public function __toString(): string
    {
        if (is_object($this->value)) {
            return (string) $this->value;
        }
        return '';
    }
}
