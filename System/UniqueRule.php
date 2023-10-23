<?php

namespace System;

use Rakit\Validation\Rule;
use Database\Connection;

class UniqueRule extends Rule
{
    protected $message = ":attribute :value has been used";

    protected $fillableParams = ['table', 'column', 'except'];

    protected Connection $db;

    public function __construct(){
        $this->db = Connection::getInstance();
    }

    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(['table', 'column']);

        // getting parameters
        $column = $this->parameter('column');
        $table = $this->parameter('table');


        // do query
        $query = "SELECT COUNT(*) AS count FROM `{$table}` WHERE `{$column}` = :value";
        $binds = ['value' => $value];
        $stmt = $this->db->query($query, $binds);
        $data = $stmt->fetch();

        // true for valid, false for invalid
        return intval($data['count']) === 0;
    }
}