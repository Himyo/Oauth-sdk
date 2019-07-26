<?php

interface ProviderInterface {
    /**
     * Return the provider name
     * @example google, facebook, ...
     */
    public function getProviderName(): string;
    /**
     * Return the authorization endpoint
     * @example http://auth-server/auth
     */
    public function getAuthorizationUrl(): string;
    /**
     * Return the access token endpoint
     * @example http://auth-server/token
     */
    public function getAccessTokenUrl(): string;
    /**
     * Return the user information
     * @example [
     *  "id" => "123456",
     *  "name" => "John Smith",
     *  "email" => "john.smith@domain.com"
     * ]
     */
    public function getUsersInfo(): array;
}