<?php

namespace Makler;


class Register
{
    private array $data = [];
    private $db;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->db = DB::getInstance();
    }

    public function validateEmail(): void
    {
        if (!empty($this->data['email'])) {
            $email = filter_var($this->data['email'], FILTER_VALIDATE_EMAIL);
            $this->db->insert('customers', ['email' => $email]);

        }
    }

}