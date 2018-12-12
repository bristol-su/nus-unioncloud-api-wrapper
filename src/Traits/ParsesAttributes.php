<?php
/**
 * GetsSetsAttributes Trait
 */
namespace Twigger\UnionCloud\Traits;

use Carbon\Carbon;

/**
 * Helper functions for getting and setting  attributes in a class
 * when given by an array.
 *
 * This class was designed to aid with Resource development, in particular setting
 * and getting resource attributes. All attributes should be set using the property phpDoc
 * tag, and accessed through $this->camelCase.
 * e.g. $this->studentId
 *
 * It also allows for casting. Define a protected property $casts, which holds as
 * associative array. The key should be the camel cased attribute, and the
 * value should be one of
 *      'date' => returns a Carbon instance
 *
 * This will set the initial resource attributes to
 *
 *
 * @package Twigger\UnionCloud\Core\Traits
 */
trait ParsesAttributes
{

     /**
     * Convert camelCase to snake_case
     *
     * @param string $key
     *
     * @return string
     */
    public function fromCamelToSnake($key)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $key, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    /**
     * Convert snake_case to camelCase
     *
     * @param string $key
     *
     * @return mixed
     */
    public function fromSnakeToCamel($key)
    {
        $key = str_replace('_', '', ucwords($key, '_'));
        $key = lcfirst($key);
        return $key;
    }

}