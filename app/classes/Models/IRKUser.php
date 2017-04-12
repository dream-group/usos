<?php

namespace Dream\USOS\Models;

use Dream\DreamApply\Client\Models\Applicant;

class IRKUser implements \JsonSerializable
{
    private $id;
    private $applicant;

    public function __construct(Applicant $applicant, int $id)
    {
        $this->id = $id;
        $this->applicant = $applicant;
    }

    public function toIRKArray(): array
    {
        $data = [
            'id'    => $this->id,
            'email' => $this->applicant->email,
            'name'  => $this->applicant->name, // DA structure is the same as IRK
            'phone' => $this->applicant->phone,
        ];

        return $data;
    }

    public function jsonSerialize()
    {
        return $this->toIRKArray();
    }
}
