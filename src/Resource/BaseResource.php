<?php
/**
 * Base Resource
 */
namespace Twigger\UnionCloud\API\Resource;

use Carbon\Carbon;
use Twigger\UnionCloud\API\Exception\Resource\ResourceNotFoundException;
use Twigger\UnionCloud\API\ResourceCollection;
use Twigger\UnionCloud\API\Traits\CastsAttributes;
use Twigger\UnionCloud\API\Traits\ParsesAttributes;

/**
 * Contains methods to deal with a Resource
 *
 * Class BaseResource
 *
 * @package Twigger\UnionCloud\API\Core\Resources
 */
class BaseResource
{
    use ParsesAttributes, CastsAttributes;

    /**
     * Holds an array representing the resource
     *
     * Should store attributes in snake case
     *
     * @var mixed $modelParameters
     */
    public $attributes = [];

    /**
     * Enable casting variables.
     *
     * The key of the array should be the attribute in camelCase
     * The value of the array should be one of:
     *      date -> will parse to a Carbon instance
     *      properCase -> will parse names
     *      Class::class -> will pass the individual attributes into the class constructor.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Enable advanced casting for multiple return variables
     *
     * The key of the array should contain the new attribute reference in snake case,
     * and a string representing the class. i.e.
     * usergroup|UserGroup::class.
     *
     * The value of the array should be an array to specify the transformation from
     * the first attribute to the second attribute. I.e. if the initial request contains
     * a key called ug_id, but the UserGroup class has an attribute id, we put
     *  ['ug_id' => 'id']
     *
     * @var array
     */
    protected $customCasts = [];



    /*
    |--------------------------------------------------------------------------
    | Getting and Setting attributes
    |--------------------------------------------------------------------------
    |
    | Save the attributes returned from the JSON response into a more
    | useful form.
    |
    */

    /**
     * BaseResource constructor.
     *
     * Set all the attributes to make up the model
     *
     * @throws ResourceNotFoundException
     *
     * @param $attributes
     */
    public function __construct($attributes = [])
    {
        $this->setAllAttributes($attributes);
    }


    /**
     * Set all attributes given a response from UnionCloud
     *
     * This will overwrite any previously saved attributes
     *
     * @throws ResourceNotFoundException
     *
     * @param $attributes array of snake case attribute keys and values
     */
    protected function setAllAttributes($attributes)
    {
        foreach ($attributes as $attributeKey => $value)
        {
            $value = $this->castAttribute($attributeKey, $value);
            if ($value !== null) // Will occur for customCasts, since we don't want the attribute to exist in this class but in the child resource
            {
                $this->attributes[$attributeKey] = $value;
            }
        }
    }


    /**
     * Allow getting model attributes
     *
     * If the attribute doesn't exist, this will return false.
     * Ensure the result is exactly false (=== false).
     *
     * @param string $attributeKey in camelCase
     *
     * @throws ResourceNotFoundException
     *
     * @return mixed|bool
     */
    public function __get($attributeKey)
    {
        if ($this->doesAttributeExist($attributeKey)) {
            $attribute = $this->attributes[$attributeKey];
            return $attribute;
            //return $this->castAttribute($attributeKey, $attribute);
        }
        return false;
    }

    /**
     * Allow setting model attributes
     *
     * @param string $attributeKey camelCase
     * @param mixed $value
     *
     * @throws ResourceNotFoundException
     *
     * @return $this
     */
    public function __set($attributeKey, $value) {
        $snakeAttributeKey = $this->fromCamelToSnake($attributeKey);
        if (!$this->doesAttributeExist($attributeKey)) {
            $this->attributes[$snakeAttributeKey] = '';
        }
        $value = $this->castAttribute($attributeKey, $value);
        $this->attributes[$snakeAttributeKey] = $value;
        return $this;
    }












    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    |
    | Allow for casting of attributes.
    |
    */





    /**
     * Cast an attribute from the JSON response to a more useful form
     *
     * @param string $attributeKey snake of the key
     * @param mixed $attributeValue Value of the attribute
     *
     * @throws ResourceNotFoundException
     *
     * @return mixed Casted value of the attribute value
     */
    private function castAttribute($attributeKey, $attributeValue)
    {
        if (($castTo = $this->getAttributeCastSetting($attributeKey)) !== false)
        {
            # Cast is one of date, properName etc
            return $this->castAttributeFromCode($castTo, $attributeValue);
        } elseif (($castToSettings = $this->getAttributeCustomCastSettings($attributeKey)) !== false)
        {
            # Cast is custom

            // The attribute under which the new resource is accessible
            $newAttribute = $castToSettings['new_attribute'];
            // The new resource to use
            $handler = $castToSettings['handler'];
            // The attribute to be set in the new handler
            $newHandlerAttribute = $castToSettings['new_handler_attribute'];

            if (!$this->doesAttributeExist($newAttribute))
            {
                $this->$newAttribute = new $handler([]);
            }

            $this->$newAttribute->$newHandlerAttribute = $attributeValue;

            // If it doesn't already exist, make it so it does
            // Populate the correct attribute in the class
            return null;
        }
        return $attributeValue;
    }

    /**
     * Actually casts the attribute
     *
     * @param string $castTo
     * @param mixed $attributeValue
     *
     * @return mixed
     *
     * @throws ResourceNotFoundException
     */

    private function castAttributeFromCode($castTo, $attributeValue)
    {
        switch ($castTo)
        {
            case 'date':
                return $this->parseDate($attributeValue);
            case 'properCase':
                return $this->parseProperCase($attributeValue);
            default:
                return $this->parseCustomResource($attributeValue, $castTo);
        }

        // TODO throw error to do with casting
    }
    /**
     * Return the setting for the cast from the user
     *
     * Will return false if $casts doesn't have an index associated
     * with the attributeKey. Otherwise, returns the value of the
     * cast array, i.e. the setting
     *
     * @param string $attributeKey snake case of attribute key
     *
     * @return string|false
     */

    private function getAttributeCastSetting($attributeKey)
    {
        if (property_exists($this, 'casts'))
        {
            if (array_key_exists($camelCase = $this->fromSnakeToCamel($attributeKey), $this->casts))
            {
                return $this->casts[$camelCase];
            }
        }

        return false;
    }

    /**
     * Used to create more custom casting
     *
     * Given an API response contains several parameters, i.e. ug_id and ug_name, and
     * both have to be put into a usergroup attribute, containing a usergroup, this
     * method is used. The received attributeKey will be found in the customCasts array,
     * and set up correctly.
     *
     * @param string $attributeKey
     *
     * @return array|bool
     */
    private function getAttributeCustomCastSettings($attributeKey)
    {
        if (property_exists($this, 'customCasts') && is_array($this->customCasts))
        {
            foreach ($this->customCasts as $classSettings=>$customCast)
            {
                if (array_key_exists($camelCase = $this->fromSnakeToCamel($attributeKey), $customCast))
                {
                    $castSettings = explode('|', $classSettings);
                    return [
                        'new_attribute' => $castSettings[0],
                        'handler' => $castSettings[1],
                        'current_attribute' => $attributeKey,
                        'new_handler_attribute' => $customCast[$camelCase]
                    ];
                }
            }
        }

        return false;
    }








    /*
    |--------------------------------------------------------------------------
    | Helper Functions
    |--------------------------------------------------------------------------
    |
    | Helper functions for using resources.
    |
    */







    /**
     * Determines if an attribute is present in a resource
     *
     * @param string $attributeKey camelCase attribute key
     * @param string $type camel|snake, type of string passed in $attributeKey.
     *
     * @return bool
     */
    private function doesAttributeExist($attributeKey, $type = 'camel')
    {
        if ($type === 'camel')
        {
            $attributeKey = $this->fromCamelToSnake($attributeKey);
        }
        if (property_exists($this, 'attributes'))
        {
            if (array_key_exists($attributeKey, $this->attributes)) {
                // TODO Check the attribute key isn't blank
                if ($this->attributes[$attributeKey])
                {
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * Return an array of the resource attributes
     *
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

}