<?php
class Validator
{

    private array $errors = [];

    public function validate(array $data, array $rules)
    {
        foreach ($rules as $field => $ruleString) {
            $rulesArray = explode(',', $ruleString);
            // Verificar si la regla "nullable" está presente en las reglas
            if (in_array('nullable', $rulesArray) && (empty($data[$field]) || $data[$field] === null)) {
                continue;
            }
            foreach ($rulesArray as $rule) {
                $ruleParts = explode(':', $rule);
                $ruleName = $ruleParts[0];

                switch ($ruleName) {
                    case 'required':
                        if (empty($data[$field])) {
                            $this->errors[$field][] = "El campo $field es requerido.";
                        }
                        break;

                    case 'string':
                        if (!is_string($data[$field])) {
                            $this->errors[$field][] = "El campo $field debe ser una cadena de texto.";
                        }
                        break;

                    case 'min':
                        $minValue = $ruleParts[1];
                        if (strlen($data[$field]) < $minValue) {
                            $this->errors[$field][] = "El campo $field debe tener al menos $minValue caracteres.";
                        }
                        break;

                    case 'max':
                        $maxValue = $ruleParts[1];
                        if (strlen($data[$field]) > $maxValue) {
                            $this->errors[$field][] = "El campo $field no debe exceder los $maxValue caracteres.";
                        }
                        break;

                    case 'email':
                        if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                            $errors[$field][] = "El campo $field debe ser una dirección de correo electrónico válida.";
                        }
                        break;

                    case 'array':
                        if (!is_array($data[$field])) {
                            $errors[$field][] = "El campo $field debe ser un array.";
                        }
                        break;

                    case 'json':
                        if (!is_string($data[$field]) || !json_decode($data[$field])) {
                            $errors[$field][] = "El campo $field debe ser un JSON válido.";
                        }
                        break;

                    case 'url':
                        if (!filter_var($data[$field], FILTER_VALIDATE_URL)) {
                            $errors[$field][] = "El campo $field debe ser una URL válida.";
                        }
                        break;

                    case 'date':
                        $dateFormat = isset($ruleParts[1]) ? $ruleParts[1] : 'Y-m-d';
                        $date = DateTime::createFromFormat($dateFormat, $data[$field]);
                        $errors[$field] = DateTime::getLastErrors();
                        if ($errors[$field]['warning_count'] > 0 || $errors[$field]['error_count'] > 0 || !$date) {
                            $errors[$field][] = "El campo $field no es una fecha válida en el formato $dateFormat.";
                        }
                        break;

                    case 'numeric':
                        if (!is_numeric($data[$field])) {
                            $errors[$field][] = "El campo $field debe ser un valor numérico.";
                        }
                        break;
                    default:
                        // Regla no reconocida
                        break;
                }
            }
        }
        return $this;
    }
    public function fails(): bool
    {
        return count($this->errors) > 0;
    }
    public function errors(): array
    {
        return $this->errors;
    }
}
