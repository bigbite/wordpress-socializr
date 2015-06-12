<?php

namespace Socializr\Services;

use Valitron\Validator as ValitronValidator;
use Herbert\Framework\Notifier;
use Herbert\Framework\Exceptions\HttpErrorException;

class Validator
{
    /**
     * The data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * The validation rules.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * The validation errors.
     *
     * @var array
     */
    protected $errors = [];

    /**
     * The validation state.
     *
     * @var bool
     */
    protected $dirty = true;

    /**
     * Constructs the Validator.
     *
     * @param array $data
     * @param array $rules
     * @param array $errors
     */
    public function __construct($data = [], $rules = [], $errors = null)
    {
        $this->data = $data;
        $this->rules = $rules;

        if ($errors !== null) {
            $this->dirty = false;
            $this->errors = $errors;
        }
    }

    /**
     * Validates the form.
     *
     * @param string $url
     *
     * @return bool
     */
    public function validate($url)
    {
        if ($this->dirty) {
            $this->gatherErrors();
        }

        if ($url === null || ($valid = $this->isValid())) {
            return $valid;
        }

        Notifier::error('There were errors validating your input.', true);

        throw new HttpErrorException(302,
            redirect_response($url)
                ->with('__validation_errors', $this->errors)
                ->with('__form_data', $this->data)
        );
    }

    /**
     * Gathers the data's errors.
     */
    protected function gatherErrors()
    {
        $validator = $this->createValidator();
        $validator->validate();

        $this->errors = $this->formatErrors($validator->errors());

        $this->dirty = false;
    }

    /**
     * Creates the validator.
     *
     * @return \Valitron\Validator
     */
    protected function createValidator()
    {
        $validator = new ValitronValidator($this->data);

        array_walk($this->rules, function ($rules, $field) use (&$validator) {
            foreach ($rules as $rule => $option) {
                if (is_numeric($rule)) {
                    list($rule, $option) = [$option, null];
                }

                $validator->rule($rule, [$field], $option);
            }
        });

        return $validator;
    }

    /**
     * Formats the errors.
     *
     * @param array $errors
     *
     * @return array
     */
    protected function formatErrors(array $errors)
    {
        $niceErrors = [];

        foreach ($errors as $field => $error) {
            $error = (array) $error;

            $niceErrors[$field] = $error[0];
        }

        return $niceErrors;
    }

    /**
     * Checks if the data is invalid.
     *
     * @return bool
     */
    public function isValid()
    {
        return empty($this->errors);
    }

    /**
     * Gets all the errors.
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }
}
