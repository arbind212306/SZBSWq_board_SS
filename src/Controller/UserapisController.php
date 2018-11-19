<?php

namespace App\Controller;

ob_start();


use App\Controller\AppController;

use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;


//use Cake\Controller\Controller;
//use Cake\Auth\DefaultPasswordHasher;
/**
 * All User management
 */


class UserapisController extends AppController
{
	
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
		$this->Auth->allow(['index','add','view','delete']);
    }

    public function index()
    {
		 $this->loadModel('Userapis');
        $recipes = $this->Userapis->find('all');
        $this->set([
            'users' => $recipes,
            '_serialize' => ['users']
        ]);
		
		
    }

    public function view($id)
    {
		$this->loadModel('Userapis');
        $recipe = $this->Userapis->get($id);
        $this->set([
            'users' => $recipe,
            '_serialize' => ['users']
        ]);
		
    }

    public function add()
    {
		$this->loadModel('Userapis');
		  if ($this->request->is(['post'])) {
        $recipe = $this->Userapis->newEntity($this->request->getData());
        if ($this->Userapis->save($recipe)) {
			
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
		
		  }
        $this->set([
            'message' => $message,
            'users' => $recipe,
            '_serialize' => ['message', 'users']
        ]);
		
	
		
		
    }

    public function edit($id)
    {
		$this->loadModel('Userapis');
        $recipe = $this->Userapis->get($id);
        if ($this->request->is(['post'])) {
            $recipe = $this->Userapis->patchEntity($recipe, $this->request->getData());
            if ($this->Userapis->save($recipe)) {
				//pr($recipe);die;
				
                $message = 'Saved';
            } else {
                $message = 'Error';
            }
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
		
    }

    public function delete($id)
    {
		
		$this->loadModel('Userapis');
        $recipe = $this->Userapis->get($id);
        $message = 'Deleted';
        if (!$this->Userapis->delete($recipe)) {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
		
    }
}