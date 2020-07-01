<?php

declare(strict_types=1);

namespace App\Model;


interface InterfaceModel 
{
    public function list(string $by,string $order,int $size,int $number,?string $phrase = null):array;
    public function count(?string $phrase = null):int;
    public function get(int $id):array;
    public function edit(int $id,array $data):void;
    public function delete(int $id):void;
    public function create(array $data):void;
}