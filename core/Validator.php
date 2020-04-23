<?php

namespace Zombie;

class Validator
{
    /**
     * Array of rules for validation
     *
     * @var array
     */
    private $rules;

    /**
     * Data for validation
     *
     * @var array
     */
    private $data;

    /**
     * Custom massages for errors response
     *
     * @var array
     */
    private $messages;

    /**
     * Array of errors
     *
     * @var
     */
    private $errors;

    /**
     * Validator constructor.
     * @param array $rules
     * @param array $data
     * @param array $messages
     */
    public function __construct(array $rules, array $data, array $messages = [])
    {
        $this->rules = $rules;
        $this->data = $data;
        $this->messages = $messages;

        $this->validate();
    }

    /**
     * Reduce array of rules and use validation method
     */
    public function validate()
    {
        foreach($this->rules as $key => $item) {
            foreach(explode('|', $item) as $rule) {
                list($method, $args) = explode(':', $rule);
                $this->{$method}($key, $args);
            }
        }
    }

    /**
     * Return errors
     *
     * @return mixed
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Check what validation is success
     *
     * @return bool
     */
    public function valid()
    {
        return $this->errors ? false : true;
    }

    /**
     * Field is should exist in validation
     *
     * @param $key
     */
    private function required($key)
    {
        if (!isset($this->data[$key]))
            $this->errors[$key][] = $this->messages[$key][__METHOD__] ?? "Field {$key} is required";
    }

    /**
     * Check min value
     *
     * @param $key
     * @param $length
     */
    private function min($key, $length)
    {
        if (strlen($this->data[$key]) < $length)
            $this->errors[$key][] = $this->messages[$key][__METHOD__] ?? "Field {$key} is should be have length $length or greater";
    }

    /**
     * Check max value
     *
     * @param $key
     * @param $length
     */
    private function max($key, $length)
    {
        if (strlen($this->data[$key]) > $length)
            $this->errors[$key][] = $this->messages[$key][__METHOD__] ?? "Field {$key} is should be have length $length or less";
    }

    /**
     * Check email
     *
     * @param $key
     */
    private function email($key)
    {
        if (!filter_var($this->data[$key], FILTER_VALIDATE_EMAIL))
            $this->errors[$key][] = $this->messages[$key][__METHOD__] ?? "Field {$key} is not correct";
    }

    /**
     * Check what value is contain in list
     *
     * @param $key
     * @param $list
     */
    private function in($key, $list)
    {
        $in = explode(',', $list);

        if (!in_array($this->data[$key], $in))
            $this->errors[$key][] = $this->messages[$key][__METHOD__] ?? "Field {$key} is should have value " . $list;
    }
}