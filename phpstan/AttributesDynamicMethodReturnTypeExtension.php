<?php

declare(strict_types=1);

namespace Symfony\UX\Html\PHPStan;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Symfony\UX\Html\Attribute\Attributes;

/**
 * Treats any dynamic method invoked on {@see Attributes} as returning another
 * immutable `Attributes` instance. This mirrors the runtime behaviour provided
 * by {@see Attributes::__call()} when magic methods are enabled.
 */
final class AttributesDynamicMethodReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function getClass(): string
    {
        return Attributes::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return true;
    }

    public function getTypeFromMethodCall(MethodReflection $methodReflection, MethodCall $methodCall, Scope $scope): Type
    {
        if (method_exists(Attributes::class, $methodReflection->getName())) {
            $variants = $methodReflection->getVariants();
            if ($variants !== []) {
                return $variants[0]->getReturnType();
            }

            return new ObjectType(Attributes::class);
        }

        return new ObjectType(Attributes::class);
    }
}
