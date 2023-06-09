<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules( [
        'array_syntax'                          => true,
        'braces'                                => ['allow_single_line_closure' => true],
        'concat_space'                          => ['spacing' => 'one'],
        'no_unused_imports'                     => true,
        'no_whitespace_before_comma_in_array'   => true,
        'no_trailing_comma_in_singleline_array' => true,
        'trailing_comma_in_multiline'           => true,
        'trim_array_spaces'                     => true,
        'whitespace_after_comma_in_array'       => true,
        'unary_operator_spaces'                 => true,
        'cast_spaces'                           => true,
        'blank_line_after_namespace'            => true,
        'blank_line_before_statement'           => ['statements' => ['return', 'yield']],
        'declare_equal_normalize'               => ['space' => 'none'],
        'function_typehint_space'               => true,
        'include'                               => true,
        'linebreak_after_opening_tag'           => true,
        'lowercase_cast'                        => true,
        'constant_case'                         => true,
        'lowercase_keywords'                    => true,
        'lowercase_static_reference'            => true,
        'magic_constant_casing'                 => true,
        'magic_method_casing'                   => true,
        'method_argument_space'                 => true,
        'native_function_casing'                => true,
        'no_blank_lines_after_class_opening'    => true,
        'no_closing_tag'                        => true,
        'no_extra_blank_lines'                  => [
            'tokens' => [
                'curly_brace_block',
                'parenthesis_brace_block',
                'square_brace_block',
                'use',
                'use_trait',
                'extra',
            ],
        ],
        'no_leading_import_slash'                    => true,
        'no_leading_namespace_whitespace'            => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_spaces_after_function_name'              => true,
        'no_spaces_around_offset'                    => true,
        'no_spaces_inside_parenthesis'               => true,
        'no_trailing_comma_in_list_call'             => true,
        'no_trailing_whitespace'                     => true,
        'no_trailing_whitespace_in_comment'          => true,
        'no_unneeded_curly_braces'                   => true,
        'no_whitespace_in_blank_line'                => true,
        'normalize_index_brace'                      => true,
        'object_operator_without_whitespace'         => true,
        'phpdoc_indent'                              => true,
        'return_type_declaration'                    => true,
        'short_scalar_cast'                          => true,
        'single_blank_line_at_eof'                   => true,
        'single_blank_line_before_namespace'         => true,
        'single_class_element_per_statement'         => true,
        'single_import_per_statement'                => true,
        'single_line_after_imports'                  => true,
        'standardize_not_equals'                     => true,
        'switch_case_semicolon_to_colon'             => true,
        'switch_case_space'                          => true,
        'ternary_operator_spaces'                    => true,
        'ternary_to_null_coalescing'                 => true,
        'visibility_required'                        => ['elements' => ['property', 'method', 'const']],
        'ordered_imports'                            => true,
        'compact_nullable_typehint'                  => true,
        'method_chaining_indentation'                => true,
        'multiline_whitespace_before_semicolons'     => ['strategy' => 'new_line_for_chained_calls'],
        'binary_operator_spaces'                     => [
            'operators' => [
                '=>' => 'align_single_space_minimal',
            ],
        ],
        'single_quote'                => true,
        'array_indentation'           => true,
        'no_superfluous_elseif'       => true,
        'no_useless_else'             => true,
        'class_attributes_separation' => [
            'elements' => [
                'method'   => 'one',
                'property' => 'one',
            ],
        ],
        'new_with_braces'                     => true,
        'no_blank_lines_after_phpdoc'         => true,
        'no_empty_comment'                    => true,
        'no_empty_phpdoc'                     => true,
        'no_empty_statement'                  => true,
        'phpdoc_order'                        => true,
        'phpdoc_separation'                   => ['groups' => [['ORM\\*'], ['*Assert\\*', '*Constraint*', '*Validator*']]],
        'phpdoc_var_annotation_correct_order' => true,
        'full_opening_tag'                    => true,
        'encoding'                            => true,
        'class_definition'                    => true,
        'elseif'                              => true,
        'function_declaration'                => true,
        'indentation_type'                    => true,
        'line_ending'                         => true,
        'no_break_comment'                    => true,
        'ordered_class_elements'              => [
            'order' => [
                'use_trait',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'destruct',
                'magic',
                'phpunit',
                'method_public_static',
                'method_public',
                'method_protected',
                'method_private',
            ],
        ],
        'phpdoc_line_span' => [
            'const'    => 'single',
            'property' => 'single',
        ],
        'no_superfluous_phpdoc_tags' => ['remove_inheritdoc' => true, 'allow_mixed' => true],
        'phpdoc_trim'                => true,
        'lambda_not_used_import'     => true,
    ])->setFinder($finder);