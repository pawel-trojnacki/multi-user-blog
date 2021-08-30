<?php

namespace App\Models\Services;

class ValidationService
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_FILE_REQUIRED = 'file required';
    public const RULE_FILE_MAX_SIZE = 'file max size';

    private const ERR_REQUIRED = 'The field is required';
    private const ERR_EMAIL = 'The field has to be a valid email address';
    private const ERR_MIN = 'The field has to be at least of {min} characters long';
    private const ERR_MAX = 'The field has to be maximum of {max} characters long';
    private const ERR_MATCH = 'The field has to bee the same as the {match}';
    private const ERR_FILE_MAX = 'Maximum file size is {file max size}';
    private const ERR_FILE_DEFAULT = 'Something went wrong with uploading the file';


    public function validate(array $validation): array
    {
        $errors = [];

        foreach ($validation as $key => $value) {
            $field = $value[0];
            $rules = $value[1];

            foreach ($rules as $rule) {
                $ruleName = is_array($rule) ? $rule[0] : $rule;
                switch ($ruleName) {
                    case self::RULE_REQUIRED:
                        if (!$field) {
                            $errors[$key][] = self::ERR_REQUIRED;
                        }
                        break;
                    case self::RULE_EMAIL:
                        if (!$field || !filter_var($field, FILTER_VALIDATE_EMAIL)) {
                            $errors[$key][] = self::ERR_EMAIL;
                        }
                        break;
                    case self::RULE_MIN:
                        if (!$field || strlen($field) < $rule[1]) {
                            $err = str_replace(
                                '{' . self::RULE_MIN . '}',
                                $rule[1],
                                self::ERR_MIN
                            );
                            $errors[$key][] = $err;
                        }
                        break;
                    case self::RULE_MAX:
                        if (!$field || strlen($field) > $rule[1]) {
                            $err = str_replace(
                                '{' . self::RULE_MAX . '}',
                                $rule[1],
                                self::ERR_MAX
                            );
                            $errors[$key][] = $err;
                        }
                        break;
                    case self::RULE_MATCH:
                        if (!$field || $field !== $rule[1]) {
                            $err = str_replace(
                                '{' . self::RULE_MATCH . '}',
                                $rule[2],
                                self::ERR_MATCH
                            );
                            $errors[$key][] = $err;
                        }
                        break;
                    case self::RULE_FILE_REQUIRED:
                        if (!$field || !isset($field['name']) || !$field['name']) {
                            $errors[$key][] = self::ERR_REQUIRED;
                        } else if (isset($field['error']) && $field['error']) {
                            $errors[$key][] = self::ERR_FILE_DEFAULT;
                        }
                        break;
                    case self::RULE_FILE_MAX_SIZE:
                        if ($field && (!isset($field['size']) || $field['size'] > $rule[1])) {
                            $err = str_replace(
                                '{' . self::RULE_FILE_MAX_SIZE . '}',
                                $rule[2],
                                self::ERR_FILE_MAX
                            );
                            $errors[$key][] = $err;
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        return $errors;
    }
}
