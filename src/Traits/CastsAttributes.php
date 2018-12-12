<?php
/**
 * Casts Attributes Class
 */

namespace Twigger\UnionCloud\Traits;

use Carbon\Carbon;
use Twigger\UnionCloud\Exception\Resource\ResourceNotFoundException;
use Twigger\UnionCloud\ResourceCollection;

/**
 * Contains functions to aid with casting variables
 *
 * Trait CastsAttributes
 *
 * @package Twigger\UnionCloud\Core\Traits
 */
trait CastsAttributes
{

    /**
     * Casts the attribute to a Carbon instance
     *
     * @param string $attributeValue
     *
     * @return Carbon
     */
    public function parseDate($attributeValue)
    {
        return Carbon::parse($attributeValue);
    }

    /**
     * Convert a string into proper case
     *
     * @param string $attributeValue
     *
     * @return string
     */
    public function parseProperCase($attributeValue)
    {
        // https://www.media-division.com/correct-name-capitalization-in-php/
        $word_splitters = array(' ', '-', "O'", "L'", "D'", 'St.', 'Mc');
        $lowercase_exceptions = array('the', 'van', 'den', 'von', 'und', 'der', 'de', 'da', 'of', 'and', "l'", "d'");
        $uppercase_exceptions = array('III', 'IV', 'VI', 'VII', 'VIII', 'IX');

        $attributeValue = strtolower($attributeValue);
        foreach ($word_splitters as $delimiter)
        {
            $words = explode($delimiter, $attributeValue);
            $newWords = array();
            foreach ($words as $word)
            {
                if (in_array(strtoupper($word), $uppercase_exceptions))
                    $word = strtoupper($word);
                else
                    if (!in_array($word, $lowercase_exceptions))
                        $word = ucfirst($word);

                $newWords[] = $word;
            }

            if (in_array(strtolower($delimiter), $lowercase_exceptions))
                $delimiter = strtolower($delimiter);

            $attributeValue = join($delimiter, $newWords);
        }
        return $attributeValue;
    }

    /**
     * Parse a custom resource.
     *
     * Will pass each of the attribute values into the constructor of the resourceClass
     *
     * @param $attributeValue
     * @param $resourceClass
     *
     * @return ResourceCollection
     *
     * @throws ResourceNotFoundException
     */
    public function parseCustomResource($attributeValue, $resourceClass)
    {
        $collection = new ResourceCollection();
        foreach($attributeValue as $resource)
        {
            try{

            } catch (\Exception $e)
            {
                throw new ResourceNotFoundException('Couldn\'t find the specified resource '.$resourceClass, 404, $e);
            }
            $collection->addResource(new $resourceClass($resource));
        }
        return $collection;
    }
}