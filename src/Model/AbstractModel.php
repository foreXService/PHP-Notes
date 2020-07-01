<?php

declare(strict_types=1);

namespace App\Model;

use PDO;
use Throwable;
use App\Exception\StorageException;
use App\Exception\ConfigurationException;

abstract class AbstractModel 
{
    protected PDO $connection;
    public function __construct(array $config)
    {
        $this->validateConfig($config);
        $this->createConnection($config);
    }

    private function createConnection(array $config):void{


        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $user = $config['user'];
        $password = $config['password'];
        
        try {
            $this->connection = new PDO($dsn, $user, $password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        }
        catch (Throwable $ex){
            throw new StorageException("Connection error");
        }
    }

    private function validateConfig(array $config):void{

        if (empty($config['database']) || empty($config['host']) || empty($config['user']) || empty($config['password'])) 
            throw new ConfigurationException("Storage configuration error");
    }
}