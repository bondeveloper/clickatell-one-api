<?php

namespace Clickatell;

use Clickatell\Exceptions\ValidationException;
use stdClass;

class SignedRequest
{
    public string $username;
    public string $password;
    /**
     * @throws ValidationException
     */
    public static function createBasic(string $username, string $password): SignedRequest
    {
        try {
            $signedRequest = new self();
            $requestData = compact('username', 'password');
            $signedRequest->validateRequest($requestData);
            $signedRequest->setPropertyValues((object) $requestData);
        } catch(ValidationException $ex) {
            throw new ValidationException($ex->getMessage());
        }
        return $signedRequest;
    }

    public function setPropertyValues(stdClass $object): self
    {
        foreach($object as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    /**
     * @throws ValidationException
     */
    private function validateRequest(array $request): void
    {
        $required = [
            'username' => 'is_string',
            'password'=> 'is_string'
        ];
        foreach($required as $name => $type) {
            if (!isset($request[$name])) {
                throw new ValidationException($name.' is required.');
            }

            if (! $type($request[$name])) {
                throw new ValidationException($name.' is invalid.');
            }
        }
    }
}