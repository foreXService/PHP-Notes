<?php

declare(strict_types=1);


namespace App\Controller;

use App\View;
use App\Request;
use App\Model\NoteModel;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
use App\Exception\ConfigurationException;

abstract class AbstractController 
{
    protected const DEFAULT_ACTION = 'list';
    protected const CREATE_ACTION = 'create';
    protected const SHOW_ACTION = 'show';
    protected const EDIT_ACTION = 'edit';
    protected const DELETE_ACTION = 'delete';
    protected const ERROR_ACTION = 'error';

    protected static $config;
    public static function initConfig(array $config):void
    {
        self::$config = $config;
    }

    protected Request $request;
    protected View $view;
    protected NoteModel $noteModel;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = new View();

        if (empty(self::$config['db'])) throw new ConfigurationException("Configuration error");
        
        $this->noteModel = new NoteModel(self::$config['db']);
    }

    public function run():void
    {
        try {
            $action = $this->getAction().'Action';
        if (!\method_exists($this,$action)){
            $action = self::DEFAULT_ACTION.'Action';
        }
            
        $this->$action();
        }catch (NotFoundException $ex) {
            $this->redirect("/kurs_php/?error=noteNotFound");
        } catch (StorageException $ex) {
            $this->view->render(
                self::ERROR_ACTION,
                [
                    'error' => $ex->getMessage()
                ]
            );
        }
        
    }

    protected function getAction():string
    {
        return $this->request->getParam('action',self::DEFAULT_ACTION);
    }

    protected function redirect(string $location):void{
        header("Location: $location");
        exit;
    }
}