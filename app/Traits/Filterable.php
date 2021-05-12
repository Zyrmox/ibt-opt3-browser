<?php
/**
 * Trait Filterable used to filter and format
 * default parrent class entity attributes
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Traits;

trait Filterable
{
    private $filterableArr;
    protected $replaceable;

    protected function initializeFilterable()
    {
        // If parent class overrides formatFilteredFields method, use its returned array
        if (method_exists($this, 'formatFilteredFields')) {
            $this->replaceable = self::formatFilteredFields();
        }
        
        if ($this->filterable != null) {
            $this->filterableArr = $this->filterable;
        }
    }
    
    /**
     * Filteres models entity attributes and formats them to specific format
     * using predefined syntax
     *
     * @param  mixed $keepIdAttr if set true UUID of entity won't get filtered away
     * @return void
     */
    public function getFilteredAttributes($keepIdAttr = true) {
        $attributes = $this->getAttributes();

        if (!$keepIdAttr) {
            unset($attributes[$this->getKeyName()]);
        }

        if ($this->replaceable != null) {
            foreach($attributes as $key => $attr) {
                if (array_key_exists($key, $this->replaceable)) {
                    preg_match_all('/{original}|{formatted}/', $this->replaceable[$key]["format"], $marks);

                    if (array_key_exists('map', $this->replaceable[$key]))
                    {
                        $format = str_replace(['{original}', '{formatted}'], [$attr, is_array($this->replaceable[$key]["map"]) ? $this->replaceable[$key]["map"][$attr] : $this->getAttribute($this->replaceable[$key]["map"])], $this->replaceable[$key]["format"]);
                    } 
                    else if (array_key_exists('value', $this->replaceable[$key])) 
                    {
                        if (is_callable($this->replaceable[$key]["value"])) {
                            $format = str_replace(['{original}', '{formatted}'], [$attr, $this->replaceable[$key]["value"]()], $this->replaceable[$key]["format"]);
                        } else {
                            $format = str_replace(['{original}', '{formatted}'], [$attr, $this->replaceable[$key]["value"]], $this->replaceable[$key]["format"]);
                        }
                    }
                    $attributes[$key] = $format;
                }
            }
        }

        if ($this->filterableArr == null) {
            return $attributes;
        }
        
        return array_filter($attributes, function($key) {
            return in_array($key, $this->filterableArr);
        }, ARRAY_FILTER_USE_KEY);
    }
}
