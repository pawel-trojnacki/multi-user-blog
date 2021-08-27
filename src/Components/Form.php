<?php

namespace App\Components;

class Form
{
    public function __construct(
        public array $values = [],
        public array $errors = []
    ) {
    }

    private function errorField(array|string $error): void
    {
        if ($error) {
            echo '<div class="text-danger mb-3">';
            echo $error[0];
            echo '</div>';
        }
    }

    public function start(string $method = 'POST', string $action = '', bool $multipart = false)
    {
        $enctype = $multipart ? 'enctype="multipart/form-data"' : '';
        echo sprintf('<form method="%s" action="%s" %s >', $method, $action, $enctype);
    }

    public function end()
    {
        echo '</form>';
    }

    public function submit(string $value = 'Submit')
    {
        echo sprintf('<button type="submit" class="btn btn-primary mt-3">%s</button>', $value);
    }

    public function field(string $label, string $name, string $type = 'text', string $options = '')
    {

        $value = $this->values[$name] ?? null;
        $error = $this->errors[$name] ?? '';

        $validationClass = $error ? 'is-invalid' : '';

        echo '<div class="form-floating mb-3">';

        if ($type === 'textarea') {
            echo sprintf('<textarea id="%s" name="%s" class="form-control %s" placeholder="%s" %s >%s</textarea>', $name, $name, $validationClass, $name, $options, $value);
        } else {
            echo sprintf('<input id="%s" name="%s" class="form-control %s" type="%s" value="%s" placeholder="%s" %s >', $name, $name, $validationClass, $type, $value, $name, $options);
        }

        echo sprintf('<label for="%s" class="form-label">%s</label>', $name, $label);

        echo '</div>';

        $this->errorField($error);
    }

    public function fileField(string $label, string $name, string $options): void
    {
        $error = $this->errors[$name] ?? '';

        $validationClass = $error ? 'is-invalid' : '';

        echo '<div class="mb-3">';
        echo sprintf('<label for="%s" class="form-label">%s</label>', $name, $label);
        echo sprintf('<input id="%s" name="%s" class="form-control %s" type="file" %s >', $name, $name, $validationClass, $options);
        echo '</div>';

        $this->errorField($error);
    }

    public function select(string $label, string $name, array $options): void
    {
        $value = $this->values[$name] ?? null;
        $error = $this->errors[$name] ?? '';

        $validationClass = $error ? 'is-invalid' : '';

        echo '<div class="form-floating mb-3">';
        echo sprintf('<select name="%s" id="%s" class="form-select %s">', $name, $name, $validationClass);
        foreach ($options as $option) {
            $selected = $value === $option['value'] ? 'selected' : '';
            echo sprintf('<option value="%s" %s >%s</option>', $option['value'], $selected, $option['label']);
        }
        echo '</select>';
        echo sprintf('<label for="%s" class="form-label">%s</label>', $name, $label);
        echo '</div>';

        $this->errorField($error);
    }

    public function hiddenField(string $name, string $value): void
    {
        echo sprintf('<input type="hidden" name="%s" value="%s">', $name, $value);
    }

    public function deleteButton(string $value = 'Delete')
    {
        echo sprintf('<input type="submit" class="btn btn-sm btn-outline-danger" value="%s">', $value);
    }
}
