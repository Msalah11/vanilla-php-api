<?php

namespace App\Requests;

abstract class BaseRequest
{
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';

    public array $errors = [];

    /**
     * Get Request URL
     *
     * @return false|mixed|string
     */
    public function getUrl()
    {
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }
        return $path;
    }

    /**
     * Validate the request rules.
     *
     * @return array
     */
    public function validation(): array
    {
        foreach ($this->rules() as $attribute => $rules) {

            if (!isset($this->getBody()[$attribute])) {
                $this->addErrorByRule($attribute, self::RULE_REQUIRED);

                return $this->errors;
            }

            $value = $this->getBody()[$attribute];

            foreach ($rules as $key => $rule) {
                $ruleName = $rule;

                if (!is_string($rule)) {
                    $ruleName = $key;
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorByRule($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorByRule($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule) {
                    $this->addErrorByRule($attribute, self::RULE_MIN, ['min' => $rule]);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule) {
                    $this->addErrorByRule($attribute, self::RULE_MAX, ['max' => $rule]);
                }
            }
        }

        return $this->errors;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Get Request Body
     *
     * @return array
     */
    public function getBody(): array
    {
        $data = [];

        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->isPut() || $this->isDelete()) {
            $requestData = $this->extractPutData();
            foreach ($requestData as $key => $value) {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    private function extractPutData(): array
    {
        return $this->parseFormData(
            file_get_contents('php://input')
        );
    }

    public function parseFormData($formData, &$header = [])
    {
        $endOfFirstLine = strpos($formData, "\r\n");
        $boundary = substr($formData, 0, $endOfFirstLine);
        // Split form-data into each entry
        $parts = explode($boundary, $formData);
        $return = [];
        $header = [];
        // Remove first and last (null) entries
        array_shift($parts);
        array_pop($parts);
        foreach ($parts as $part) {
            $endOfHead = strpos($part, "\r\n\r\n");
            $startOfBody = $endOfHead + 4;
            $head = substr($part, 2, $endOfHead - 2);
            $body = substr($part, $startOfBody, -2);
            $headerParts = preg_split('#; |\r\n#', $head);
            $key = null;
            $thisHeader = [];
            // Parse the mini headers,
            // obtain the key
            foreach ($headerParts as $headerPart) {
                if (preg_match('#(.*)(=|: )(.*)#', $headerPart, $keyVal)) {
                    if ($keyVal[1] == "name") $key = substr($keyVal[3], 1, -1);
                    else {
                        if($keyVal[2] == "="){
                            $thisHeader[$keyVal[1]] = substr($keyVal[3], 1, -1);
                        }else{
                            $thisHeader[$keyVal[1]] = $keyVal[3];
                        }
                    }
                }
            }
            // If the key is multidimensional,
            // generate multidimentional array
            // based off of the parts
            $nameParts = preg_split('#(?=\[.*\])#', $key);
            if (count($nameParts) > 1) {
                $current = &$return;
                $currentHeader = &$header;
                $l = count($nameParts);
                for ($i = 0; $i < $l; $i++) {
                    // Strip array access tokens
                    $namePart = preg_replace('#[\[\]]#', "", $nameParts[$i]);

                    // If we are at the end of the depth of this entry,
                    // add data to array
                    if ($i == $l - 1) {
                        if (isset($thisHeader['filename'])) {
                            $filename = tempnam(sys_get_temp_dir(), "php");
                            file_put_contents($filename, $body);
                            $current[$namePart] = [
                                "name" => $thisHeader['filename'],
                                "type" => $thisHeader['Content-Type'],
                                "tmp_name" => $filename,
                                "error" => 0,
                                "size" => count($body)
                            ];
                        } else {
                            $current[$namePart] = $body;
                        }
                        $currentHeader[$namePart] = $thisHeader;
                    } else {
                        // Advance into the array
                        if (!isset($current[$namePart])) {
                            $current[$namePart] = [];
                            $currentHeader[$namePart] = [];
                        }
                        $current = &$current[$namePart];
                        $currentHeader = &$currentHeader[$namePart];
                    }
                }
            } else {
                if (isset($thisHeader['filename'])) {
                    $filename = tempnam(sys_get_temp_dir(), "php");
                    file_put_contents($filename, $body);
                    $return[$key] = [
                        "name" => $thisHeader['filename'],
                        "type" => $thisHeader['Content-Type'],
                        "tmp_name" => $filename,
                        "error" => 0,
                        "size" => count($body)
                    ];
                } else {
                    $return[$key] = $body;
                }
                $return[$key] = $body;
                $header[$key] = $thisHeader;
            }

        }
        return $return;
    }

    /**
     * Check if request is get
     *
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->getMethod() === 'get';
    }

    /**
     * Get Request Method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Check if request is post
     *
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->getMethod() === 'post';
    }

    /**
     * Check if request is put
     *
     * @return bool
     */
    public function isPut(): bool
    {
        return $this->getMethod() === 'put';
    }

    /**
     * Check if request is put
     *
     * @return bool
     */
    public function isDelete(): bool
    {
        return $this->getMethod() === 'delete';
    }

    protected function addErrorByRule(string $attribute, string $rule, $params = [])
    {
        $params['field'] ??= $attribute;
        $errorMessage = $this->errorMessage($rule);
        foreach ($params as $key => $value) {
            $errorMessage = str_replace("{{$key}}", $value, $errorMessage);
        }
        $this->errors[$attribute][] = $errorMessage;
    }

    /**
     * Get Role Error Message
     *
     * @param $rule
     * @return string
     */
    public function errorMessage($rule): string
    {
        return $this->errorMessages()[$rule];
    }

    /**
     * The validation error messages
     *
     * @return string[]
     */
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
        ];
    }

}