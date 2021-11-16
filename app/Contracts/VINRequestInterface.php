<?php namespace App\Contracts;

interface VINRequestInterface
{
    public function searchVin($code);

    public function checkSalvageRecord($code);

    public function storeVIN($data);

    public function retrieveVINFromStore($user, $code);

    public function retrieveSalvageDataFromStore($user, $code);

    public function storeVINSalvageRecord($code);
}










