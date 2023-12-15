<?php
declare(strict_types=1);

namespace App\Controller\Users;

use App\Controller\AppController;

/**
 * Profiles Controller
 *
 * @method \App\Model\Entity\Profile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfilesController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();

        $this->Users = $this->fetchTable('Users');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // $profiles = $this->paginate($this->Profiles);
        $profile = $this->Users->find()->where(['id' => $this->Authentication->user->id])->first();

        $this->set(compact('profile'));
    }

    // /**
    //  * View method
    //  *
    //  * @param string|null $id Profile id.
    //  * @return \Cake\Http\Response|null|void Renders view
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function view($id = null)
    // {
    //     $profile = $this->Profiles->get($id, [
    //         'contain' => [],
    //     ]);

    //     $this->set(compact('profile'));
    // }

    // /**
    //  * Add method
    //  *
    //  * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
    //  */
    // public function add()
    // {
    //     $profile = $this->Profiles->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $profile = $this->Profiles->patchEntity($profile, $this->request->getData());
    //         if ($this->Profiles->save($profile)) {
    //             $this->Flash->success(__('The profile has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The profile could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('profile'));
    // }

    /**
     * Edit method
     *
     * @param string|null $id Profile id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(empty($this->Authentication) || empty($this->Authentication->user)) {
            $this->Flash->error(__('Please sign-in for editing profile'));
            return $this->redirect(['action' => 'index']);
        }
        $profile = $this->Users->find()->where(['id' => $this->Authentication->user->id])->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $profile = $this->Users->patchEntity($profile, $this->request->getData());
            if ($this->Users->save($profile)) {
                $this->Flash->success(__('The profile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The profile could not be saved. Please, try again.'));
        }
        $this->set(compact('profile'));
    }

    // /**
    //  * Delete method
    //  *
    //  * @param string|null $id Profile id.
    //  * @return \Cake\Http\Response|null|void Redirects to index.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $profile = $this->Profiles->get($id);
    //     if ($this->Profiles->delete($profile)) {
    //         $this->Flash->success(__('The profile has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The profile could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
}
