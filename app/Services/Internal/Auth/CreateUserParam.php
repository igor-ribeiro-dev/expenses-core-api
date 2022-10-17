<?php

namespace App\Services\Internal\Auth;

class CreateUserParam {
    protected string $name = '';
    protected string $last_name = '';
    protected string $email = '';
    protected string $password = '';

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CreateUserParam
     */
    public function setName(string $name): CreateUserParam {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return CreateUserParam
     */
    public function setLastName(string $last_name): CreateUserParam {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * @param string $email
     * @return CreateUserParam
     */
    public function setEmail(string $email): CreateUserParam {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * @param string $password
     * @return CreateUserParam
     */
    public function setPassword(string $password): CreateUserParam {
        $this->password = $password;
        return $this;
    }
}