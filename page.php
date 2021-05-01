<?php
echo 'index';

$val = new Validator();

$val->check($_POST + $_FILES,[
    'username' => [
        'required' => true,
        'min' => 2,
        'max' => 15
    ],
    'password' => [
        'required' => true,
        'min' => 3
    ],
    'email'=>[
        'required'=>true,
        'email'=>true,
        'unique' => 'users'
    ],
    'file'=>[
        'extension'=>['jpg','png']
    ]
]);
