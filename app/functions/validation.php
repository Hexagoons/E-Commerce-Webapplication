<?php

/**
 * @return array
 */
function validation_rules()
{
    return array(
        'string' => [
            'function' => function ($attribute, $value) {
                return is_string($value);
            },
            'error' => ':attribute moet een string zijn'
        ],
        'numeric' => [
            'function' => function ($attribute, $value) {
                return (is_array($value)) ? is_numeric(implode('', $value)) : is_numeric($value);
            },
            'error' => [
                'string' => 'Het :attribute veld dient een nummer te bevatten.',
                'numeric' => 'Het :attribute veld dient een nummer te bevatten.',
                'array' => 'De :attribute list is ongeldig.'
            ]
        ],
        'min' => [
            'function' => function ($attribute, $value) {
                return strlen($value) >= (int) $attribute;
            },
            'error' => ':attribute dient minimaal :min karakters te bevatten.'
        ],
        'max' => [
            'function' => function ($attribute, $value) {
                return  strlen($value) <= (int) $attribute;
            },
            'error' => ':attribute mag niet groter zijn dan :max karakters.'
        ],
        'size' => [
            'function' => function ($attribute, $value) {
                return (is_numeric($value)) ? (int) $value == (int) $attribute : strlen($value) == (int) $attribute;
            },
            'error' => [
                'numeric' => ':attribute moet :size zijn.',
                'string' => ':attribute moet :size karakters lang zijn.',
            ]
        ],
        'price' => [
            'function' => function ($attribute, $value) {
                return preg_match('/^\d{1,10}(?:\.\d{1,2})?$/', $value);
            },
            'error' => 'Het :attribute formaat is ongeldig.'
        ],
        'in_array' => [
            'function' => function ($attribute, $value) {
                return in_array($value, explode(',', $attribute));
            },
            'error' => 'Het geselecteerde :attribute veld is ongeldig.'
        ],
        'chips' => [
            'function' => function ($attribute, $value) {
                return str_getcsv($value, '|')[0] !== null;
            },
            'error' => 'De opgegeven :attribute zijn ongeldig.'
        ],
        'email' => [
            'function' => function ($attribute, $value) {
                return filter_var($value, FILTER_VALIDATE_EMAIL);
            },
            'error' => ':attribute is geen geldig e-mailadres.'
        ],
        'tel' => [
            'function' => function ($attribute, $value) {
                $value = str_replace(' ', '', $value);
                return (is_numeric($value) && (strlen($value) === 10 || strlen($value) === 11));
            },
            'error' => ':attribute nummer is niet het juiste formaat 06 123 123 12.'
        ],
        'name' => [
            'function' => function ($attribute, $value) {
                return preg_match("/^([a-zA-Z'À-ÿ ])+$/i", $value);
            },
            'error' => ':attribute bevat ongeldige tekens.'
        ],
        'basic_string' => [
            'function' => function ($attribute, $value) {
                return preg_match("/^[a-zA-Z0-9'À-ÿ ]+$/i", $value);
            },
            'error' => ':attribute bevat ongeldige tekens.'
        ]
    );
}

/**
 * @param $request
 * @param $requestRules
 *
 * @return bool
 */
function validate($request, $requestRules)
{
    $validationRules = validation_rules();
    
    foreach ($requestRules as $index => $rules) {
        $rules        = explode('|', $rules);
        $requestValue = trim($request[$index]);
        
        // Check for nullable
        $nullable = array_search('nullable', $rules);
        
        // If value is null
        if(is_null($requestValue) || $requestValue == "") {
            // and nullable is NOT defined as a rule
            if ($nullable === false) {
                // alert that the value is required and stop validation for this value
                alert('validation', "Het {$index} veld is verplicht.");
            }
            
            // Stop validation for this value and continue to the next value
            continue;
        }
        
        // Remove nullable rule
        if($nullable !== false) {
            unset($rules[$nullable]);
        }
        
        // Validate rules
        foreach ($rules as $rule) {
            $rule          = explode(':', $rule);
            $ruleIndex     = $rule[0];
            $ruleAttribute = $rule[1] ?? null;
        
            $validationFunction = $validationRules[$ruleIndex]['function'];
        
            if (!$validationFunction($ruleAttribute, $requestValue)) {
                // Get error message
                $errorMsg = $validationRules[$ruleIndex]['error'];
                
                if (is_array($errorMsg)) {
                    if(is_numeric($request[ $index ]))
                        $errorMsg = $errorMsg[ 'numeric' ];
                    else if (is_array($request[ $index ]))
                        $errorMsg = $errorMsg[ 'array' ];
                    else
                        $errorMsg = $errorMsg[ 'string' ];
                }
            
                // Replace placeholders
                $errorMsg = str_replace(':attribute', $index, $errorMsg);
                $errorMsg = str_replace(":$ruleIndex", $ruleAttribute, $errorMsg);
            
                // Alert error
                alert('validation', $errorMsg);
            
                // Stop validation for this value
                break;
            }
        }
    }
    
    // If validation didn't pass
    if(isset_alert('validation')) {
        // Clear password from request
        $sessionRequest = $request;
        unset($sessionRequest['password']);
        // Clear form cache
        $_SESSION['form-cache'] = null;
        // Cache form values
        $_SESSION['form-cache'] = $sessionRequest;
        // Return false
        return false;
    }
    
    return $request;
}