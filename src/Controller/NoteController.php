<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AbstractController;
use App\Exception\NotFoundException;


class NoteController extends AbstractController
{

    protected function createAction()
    {
        if ($this->request->hasPost())
        {
            $this->noteModel->create([
                'title'=>$this->request->postParam('title'),
                'description'=>$this->request->postParam('description'),
                'created'=>date('Y-m-d H:i:s')
            ]);
            $this->redirect("/kurs_php/?before=created");
        }
        $this->view->render(self::CREATE_ACTION);
    }

    protected function showAction()
    {     
        $note = $this->getNote();

        $this->view->render(
            self::SHOW_ACTION,
            [
                'note' => $note
            ]
        );
    }

    protected function listAction()
    {
        $phrase = $this->request->getParam('phrase');
        $size = (int)$this->request->getParam('pagesize',10);
        $number = (int)$this->request->getParam('pagenumber',1);
        $by = $this->request->getParam('sortby','title');
        $order = $this->request->getParam('sortorder','desc');

        $by = in_array($by,['title' ,'created'])  ? $by : 'title';
        $order = in_array($order,['asc' ,'desc']) ? $order : 'desc';
        $size = in_array($size,[1,5,10,25]) ? $size : 10;
        
        $this->view->render(
            self::DEFAULT_ACTION,
            [
                'page' =>[
                    'size'=> $size,
                    'number' => $number ,
                    'pages' =>(int)ceil($this->noteModel->count($phrase) / $size)
                ],
                'sort' =>[
                    'by'=> $by,
                    'order' => $order 
                ],
                'phrase' => $phrase ,
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error'),
                'notes' => $this->noteModel->list($by,$order,$size,$number,$phrase)
            ]
        );
    }

    protected function editAction()
    { 
        if ($this->request->isPost())
        {
            $this->noteModel->edit(
                (int)$this->request->postParam('id'),
                [
                    'title'=>$this->request->postParam('title'),
                    'description'=>$this->request->postParam('description')
                ]
            );
            $this->redirect("/kurs_php/?before=edited");
        }

        $note = $this->getNote();
        $this->view->render(
            self::EDIT_ACTION,
            [
                'note' => $note
            ]
        );
    }
    protected function deleteAction()
    {
        if ($this->request->isPost())
        {
            $this->noteModel->delete(
                (int)$this->request->postParam('id')
            );
            $this->redirect("/kurs_php/?before=deleted");
        }

        $note = $this->getNote();
        $this->view->render(
            self::DELETE_ACTION,
            [
                'note' => $note
            ]
        );
    }

    private function getNote():array{

        $noteId = $this->request->getParam('id') ?? null;
        if (!$noteId){
            $this->redirect("/kurs_php/?error=missingNoteId");
        }

        $note = $this->noteModel->get((int)$noteId);

        return $note;
    }

}