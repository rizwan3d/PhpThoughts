<?php

namespace GrowBitTech\Framework\RouteLoader;

class RouteCollector
{
    public static function findClassMethods(array $classFiles): array
    {
        $classMethodsList = [];

        foreach ($classFiles as $fileName => $splFileObject) {
            $attributeReader = new AttributeReader($splFileObject);
            $classMethods = $attributeReader->findClassMethodInfo();

            if (!empty($classMethods)) {
                $classMethodsList[] = $classMethods;
            }
        }

        // Removed array_merge outside of loop
        return array_merge(...$classMethodsList);
    }
}
