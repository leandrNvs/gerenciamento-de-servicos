<?php

namespace Src\Validation;

use Src\Exceptions\ValidateException;
use Src\Session\Session;

final class Validation
{
    const REQUIRED = 'required';
    const ALPHA    = 'alpha';
    const NUMERIC  = 'numeric';
    const PHONE    = 'phone';
    const CPF      = 'cpf';
    const DATE     = 'date';
    const YEAR     = 'year';
    const DECIMAL  = 'decimal';
    const TEXT     = 'text';
    const OPTIONAL = 'optionial';
    const PERCENT  = 'percent';
    const ALPHANUMERIC = 'alphanumeric';

    const VALIDATE_HAS_ERROR    = 'validade_has_error';
    const VALIDATE_ERR_MESSAGES = 'validate_err_messages';
    const VALIDATE_FORM_DATA    = 'validate_form_data';

    private static ?string $bagName = null;

    public static function validate($rules, $data)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            $skip = in_array(static::OPTIONAL, $rule) && !isset($data[$field]);

            if (!$skip) {
                foreach ($rule as $r) {
                    if (static::validation($r, $field, $data)) {
                        $errors[$field] = static::messages($r);
                        break;
                    }
                }
            }
        }

        if(!empty($errors)) {
            Session::set(static::VALIDATE_HAS_ERROR, true);

            Session::set(
                static::VALIDATE_ERR_MESSAGES,
                static::$bagName? [static::$bagName => $errors] : $errors
            );
            
            Session::set(
                static::VALIDATE_FORM_DATA,
                static::$bagName? [static::$bagName => $data] : $data
            );

            throw new ValidateException;
        }

        return $data;
    }

    public static function bag(string $bagName): void
    {
        static::$bagName = $bagName;
    }

    public static function maxlength($max)
    {
        return fn($value) => strlen($value) > $max;
    }

    private static function validation($rule, $field, $data)
    {
        switch ($rule) {
            case static::REQUIRED:
                return !isset($data[$field]);
                break;
            case static::ALPHA:
                return preg_match('/^[\d]+$/', $data[$field]);
                break;
            case static::NUMERIC:
                return !preg_match('/^[0-9]+$/', $data[$field]);
                break;
            case static::ALPHANUMERIC:
                return !preg_match('/^[a-zA-Z0-9\,\.\s\-]+$/', $data[$field]);
                break;
            case static::PHONE:
                return !preg_match('/^\([0-9]{2}\)\s[0-9]{5}\-[0-9]{4}$/', $data[$field]);
                break;
            case static::CPF:
                break;
            case static::DATE:
                return !preg_match('/^[\d]{2}\/[\d]{2}\/[\d]{2,4}$/', $data[$field]);
                break;
            case static::YEAR:
                return !preg_match('/^[0-9]{4}$/', $data[$field]);
                break;
            case static::DECIMAL:
                return !preg_match('/^[0-9\,\.]+$/', $data[$field]);
                break;
        }
    }

    private static function messages($rule)
    {
        $messages = [
            static::REQUIRED => 'O campo é obrigatório',
            static::ALPHA => 'O campo deve conter apenas letras',
            static::NUMERIC => 'O campo deve conter apenas números',
            static::ALPHANUMERIC => 'O campo deve conter apenas letras e números',
            static::PHONE => 'Telefone está com o formato errado',
            static::CPF => 'Cpf inválido',
            static::DATE => 'O campo deve estar no formato dd/mm/yyyy',
            static::YEAR => 'Ano deve conter 4 dígitos numéricos',
            static::DECIMAL => 'O campo deve conter apenas números, ponto ou vírgula',
        ];

        return $messages[$rule];
    }
}
