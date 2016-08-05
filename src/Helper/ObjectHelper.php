<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MNHcC\Helper {

    use \Zend\Stdlib\ArrayUtils as AU;
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
	 * @param int $recrsusion
	 * @param bool $asName
	 * @return \ReflectionClass|string
	 */
	static public function getGrandparentClass($childclass, $recrsusion = 2, $asName = true) {
	    if (is_object($childclass)) {
		$childclass = get_class($childclass);
	    }
	    $lastparent = $class = new \ReflectionClass($childclass);
	    $i=1;
	    try {
		while (($parent = $class->getParentClass())) {
		    if($recrsusion > 0 && $recrsusion < $i){
			 break; 
		    }
		    $parent->recrsusionLevel = $i;
		    $lastparent = $parent;
		    $class = $parent;
		    $i++;
		}
	    } catch (Exception $exc) {
		
	    } finally {
		return $asName ? $lastparent->getName() : $lastparent;
	    }
	}
	
	/**
	 * @param string $method
	 * @param object $childclass
	 * @param int $recrsusion
	 * @return \Closure
	 */
	static public function getGrandparentClosure($method, $childclass,
		$recrsusion = 2) {
	    /* @var $class \ReflectionClass */
	    $class = static::getGrandparentClass($childclass, $recrsusion, false);
	    
	    return $class->getMethod($method)->getClosure($childclass);
	}
	

    }

      
}
