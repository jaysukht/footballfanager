<?php declare(strict_types=1);

namespace App\GraphQL\Scalars;

use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\ScalarType;

/** Read more about scalars here: https://webonyx.github.io/graphql-php/type-definitions/scalars. */
final class EmailScalar extends ScalarType
{
    public $name="Email";
    /** Serializes an internal value to include in a response. */
    public function serialize(mixed $value): mixed
    {
        // TODO validate if $value might be incorrect
        return $value;
    }

    /** Parses an externally provided value (query variable) to use as an input. */
    public function parseValue(mixed $value): mixed
    {
        // TODO implement validation and transformation of $value
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \GraphQL\Error\Error("Invalid email address: $value");
        }
        return $value;
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input.
     *
     * Should throw an exception with a client friendly message on invalid value nodes, @see \GraphQL\Error\ClientAware.
     *
     * @param  \GraphQL\Language\AST\ValueNode&\GraphQL\Language\AST\Node  $valueNode
     * @param  array<string, mixed>|null  $variables
     */
    public function parseLiteral(Node $valueNode, ?array $variables = null): mixed
    {
        // TODO implement validation and transformation of $valueNode
        $value = $valueNode->value;

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \GraphQL\Error\Error("Invalid email address: $value");
        }
        return $value;
    }
}

