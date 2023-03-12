<?php

namespace Clickatell;

class RequestValidator
{
    /**
     * Username and password the request should be authenticated with
     *
     * @var string
     */
    public string $signingUsername;
    public string $signingPassword;

    public function __construct(string $signingUsername, string $signingPassword)
    {
        $this->signingUsername = $signingUsername;
        $this->signingPassword = $signingPassword;
    }

    /**
     * Verify the request is from someone authenticated
     */
    public function verify(SignedRequest $signedRequest): bool
    {
        if( $this->signingUsername !== $signedRequest->username ||
            $this->signingPassword !== $signedRequest->password
        ) {
            return false;
        }
        return true;
    }
}