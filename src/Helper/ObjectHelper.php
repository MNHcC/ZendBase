<?php

/**
 * MNHcC/ZendBase https://github.com/MNHcC/ZendBase
 *
 * @link      https://github.com/MNHcC/ZendBase for the canonical source repository
 * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @license BSD
 */

namespace MNHcC\Helper {

    use Zend\Stdlib\ArrayUtils;
    
    /**
     * ObjectHelper
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    abstract class ObjectHelper {

	const PROPERTY_IS_PUBLIC = \ReflectionProperty::IS_PUBLIC;
	const PROPERTY_IS_PRIVATE = \ReflectionProperty::IS_PRIVATE;
	const PROPERTY_IS_PROTECTED = \ReflectionProperty::IS_PROTECTED;
	const PROPERTY_IS_STATIC = \ReflectionProperty::IS_STATIC;
	const PROPERTY_IS_DEFAULT = 2048;
	const PROPERTY_ALL = self::PROPERTY_IS_PUBLIC | self::PROPERTY_IS_PRIVATE | self::PROPERTY_IS_PROTECTED | self::PROPERTY_IS_STATIC | self::PROPERTY_IS_DEFAULT;
	
	static public function getPropertyTypeModifiers(\ReflectionProperty $reflectionProperty){
	    $defaultbit = $reflectionProperty->isDefault() ? self::PROPERTY_IS_DEFAULT : 0;
	    return $reflectionProperty->getModifiers() | $defaultbit;
	}
	
	/**
	 * 
	 * @param string|object $propertyObject the object or class for get the properties
	 * @param int $modifiers
	 * @return \SplObjectStorage
	 */
	static function getObjectProperties($propertyObject, $modifiers=self::PROPERTY_ALL & ~self::PROPERTY_IS_STATIC){
	    /* @var $sourcePropertiesStorage \SplObjectStorage */
	    $sourcePropertiesStorage = new \SplObjectStorage();
	    $propertynames=[];
	    try {
		$rc = is_object($propertyObject) ? new \ReflectionObject($propertyObject) : \ReflectionClass($propertyObject);
		do {
		    $prop = [];
		    /* @var $p \ReflectionProperty */
		    foreach ($rc->getProperties() as $p) {
			if(in_array($p->getName(), $propertynames) // is the property already exists or does not match the bit mask match...
				|| (static::getPropertyTypeModifiers($p) & $modifiers) == $modifiers){
			    continue; //...then go ahead
			}
			$propertynames[] = $p->getName();
			$prop[] = $p;
		    }
		    $sourcePropertiesStorage[$rc] = $prop;
		    
		    //$sourceProperties = array_merge($rp, $sourceProperties);
		} while (($rc = $rc->getParentClass()));
	    } catch (\ReflectionException $e) {
		$sourcePropertiesStorage = false;
		return false;
	    } finally {
		return $sourcePropertiesStorage;
	    }
	}
	
	
	/**
	 * 
	 * @param object $sourceObject
	 * @param $destination $destination
	 * @return $destination
	 * @throws \InvalidArgumentException
	 */
	static public function cast($sourceObject, $destination, $args = null) {
	    if (\is_string($destination)) {
		//create $destination Object
		$cast_refl = new \ReflectionClass($destination);
		$destination = $cast_refl->newInstanceWithoutConstructor();
		unset($cast_refl);
	    }
	    if( !( !is_subclass_of(get_class($destination), get_class($sourceObject)) 
		    xor !is_subclass_of(get_class($sourceObject), get_class($destination))) ) {
		throw new \InvalidArgumentException(sprintf('$s is not a subclass of s% on %s::%s', get_class($sourceObject), get_class($destination), __CLASS__, __FUNCTION__ ));
	    }
			    

	    $destinationReflection = new \ReflectionObject($destination);
	    //$sourceProperties = $sourceReflection->getProperties();
	    
	    /* @var $sourcePropertiesStorage \SplObjectStorage */
	    $sourcePropertiesStorage = static::getObjectProperties($sourceObject);
	    
	    //$propertys = ($destination instanceof Traversable) ?  AU::iteratorToArray($destination, false) : (array) $destination;
	    $propertys = get_object_vars( $destination );
	    foreach ($sourcePropertiesStorage as $parentDestinationReflection) {
		 $sourceProperties = $sourcePropertiesStorage->getInfo();
		foreach ($sourceProperties as $sourceProperty) {
		    
		    $hasPropertySet = false;
		    $sourceProperty->setAccessible(true);
		    $name = $sourceProperty->getName();
		    $value = $sourceProperty->getValue($sourceObject);
		    $sourceProperty->setValue($destination, $value);
		    
		    //  for downcast
		    if(isset($propertys[$name])) {unset($propertys[$name]);}
		    
		    if($destinationReflection->hasProperty($name)) {
			$propDest = $parentDestinationReflection->getProperty($name);
			$propDest->setAccessible(true);
			$propDest->setValue($destination, $value);
			$hasPropertySet = true;
		    } 
		    
		    if(!$hasPropertySet) {
			$destination->$name = $value;
		    }
		}
	    }
	    foreach ($propertys as $name => $value) {
		$destination->$name = $value;
	    }
	    return $destination;
	}
	
	/**
	 * 
	 * @param object|string $childclass object or classname
	 * @param int $appearance_deep
	 * @param bool $asName
         * @return string|\ReflectionClass
         * @throws \InvalidArgumentException
         * @throws \UnderflowException
         * @throws \ReflectionException
         */
	static public function getGrandparentClass($childclass, $appearance_deep = 2, $asName = true) {
            
            if(!is_string($childclass) && !is_object($childclass)) {
                throw new \InvalidArgumentException(sprintf('Argument 1 (childclass) passed to %s must be greater than 1 type of object or string, %s given', __METHOD__, gettype($childclass)));
            } elseif ($appearance_deep <= 1) {
                 throw new \UnderflowException(sprintf('Argument 2 (appearance_deep) passed to %s must be greater than 2', __METHOD__));
            }
            /*@var $last_parent_class \ReflectionClass */
	    $last_parent_class = new \ReflectionClass($childclass);
	    $i=1;
	    try {
		while ( $appearance_deep < $i && ($current_parent_class = $last_parent_class->getParentClass()) ) {
		    $current_parent_class->appearanceDeep  = $current_parent_class->recrsusionLevel = $i;
		    $last_parent_class = $current_parent_class;
		    $i++;
		}
	    } catch (\Exception $exc) {
		
	    } finally {
		return $asName ? $last_parent_class->getName() : $last_parent_class;
	    }
	}
	
	/**
	 * @param string $method
	 * @param object $childclass
	 * @param int $appearance_deep
	 * @return \Closure
	 */
	static public function getGrandparentClosure($method, $childclass,
		$appearance_deep = 2) {
	    /* @var $class \ReflectionClass */
	    $class = static::getGrandparentClass($childclass, $appearance_deep, false);
	    
	    return $class->getMethod($method)->getClosure($childclass);
	}
	

    }

      
}
