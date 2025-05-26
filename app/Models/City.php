<?php

namespace App\Models;

use Valitron\Validator;

class City
{
    protected array $loaded = ['id', 'name', 'population'];

    public array $attributes = [];


    protected array $rules = [
        'required' => [
            'name', 'population'
        ],
        'lengthMin'=> [
            ['population', 1]
        ]
    ];

    public array $errors = [];


    public function validate(array $data=[]): bool
    {
        Validator::lang('ru');
        $v = new Validator($this->attributes);
        $v->rules($this->rules);

        if ($v->validate()) {
            return true;
        } else {
            $this->errors = $v->errors();
            return false;
        }
    }

    public function listErrors(): string
    {
        $output = '<ul class="list-unstyled text-start text-danger">';
        foreach ($this->errors as $field_errors) {
            foreach ($field_errors as $error) {
                $output .= "<li>{$error}</li>";
            }
        }
        $output .= "</ul>";
        return $output;
    }

    public function loadData(): void
    {
        $data = request()->getData();
        foreach ($this->loaded as $field) {
            if (isset($data[$field])){
                $this->attributes[$field] = $data[$field];
            } else {
                $this->attributes[$field] = '';
            }
        }
    }

}