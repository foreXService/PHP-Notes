<?php

declare(strict_types=1);

namespace App\Model;

use PDO;
use Throwable;
use App\Model\AbstractModel;
use App\Model\InterfaceModel;
use App\Exception\StorageException;
use App\Exception\NotFoundException;



class NoteModel extends AbstractModel implements InterfaceModel
{

    public function edit(int $id,array $data):void{
        try{
            $title = $this->connection->quote($data['title']);
            $description = $this->connection->quote($data['description']);
            $query = "UPDATE notes SET title=$title,description=$description WHERE id=$id";
            $this->connection->exec($query );
        }
        catch(Throwable $ex)
        {
            throw new StorageException("Update note error");
        }
    }

    public function delete(int $id):void{
        try{
            $query = "DELETE FROM notes WHERE id=$id";
            $this->connection->exec($query );
        }
        catch(Throwable $ex)
        {
            throw new StorageException("Delete note error");
        }
    }

    public function create(array $data):void{
        try{
            $title = $this->connection->quote($data['title']);
            $description = $this->connection->quote($data['description']);
            $created = $this->connection->quote($data['created']);
            $query = "INSERT INTO notes(title,description,created) VALUES($title,$description,$created)";
            $this->connection->exec($query );
        }
        catch(Throwable $ex)
        {
            throw new StorageException("Create note error");
        }
    }

    public function get(int $id):array
    {
        try{
            $note = [];

            $query = "SELECT * FROM notes WHERE id='$id'";
            $result = $this->connection->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        }
        catch(Throwable $ex)
        {
            throw new StorageException("Receive note id = $id error" );
        }
        if (!$note)
        {
            throw new NotFoundException("Note not found id = $id");
            
        }
        return $note;
    }

    public function list(string $by,string $order,int $size,int $number,?string $phrase = null):array
    {
        try{
            $notes = [];

            if ($phrase) {
                $phrase = $this->connection->quote('%' . $phrase . '%',PDO::PARAM_STR);
                $phrase = $phrase ? "WHERE title LIKE($phrase)" : "";
            }
            $offset = ($number - 1) * $size;
            $query = "SELECT id,title,created FROM notes $phrase ORDER BY $by $order LIMIT $offset,$size";
            $result = $this->connection->query($query);
            $notes = $result->fetchAll(PDO::FETCH_ASSOC);
            return $notes;
        }
        catch(Throwable $ex)
        {
            dump($ex->getMessage());
            throw new StorageException("Receive notes error" );
        }
    }

    public function count(?string $phrase = null):int 
    {
        try{
            $notes = [];

            if ($phrase) {
                $phrase = $this->connection->quote('%' . $phrase . '%',PDO::PARAM_STR);
                $phrase = $phrase ? "WHERE title LIKE($phrase)" : "";
            }
            $query = "SELECT count(*) AS cn FROM notes $phrase";
            $result = $this->connection->query($query);
            $notes = $result->fetch(PDO::FETCH_ASSOC);
            return (int)$notes['cn'] ?? 0;
        }
        catch(Throwable $ex)
        {
            throw new StorageException("Receive count notes error" );
        }
    }
}