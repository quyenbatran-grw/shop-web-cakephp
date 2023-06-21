<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\UploadfileForm;

/**
 * Fileupload Controller
 *
 * @method \App\Model\Entity\Fileupload[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FileuploadController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $uploadfile = new UploadfileForm();
        $filedetails = array();

        if ($this->request->is('post')) {

            if ($uploadfile->execute($this->request->getData())) {

                  // Read file for preview
                  $attachment = $this->request->getData('fileel');
                  $filename = $attachment->getClientFilename();
                  $extension = pathinfo($filename, PATHINFO_EXTENSION);

                  $filepath = "/uploads/".$filename;
                  $extension = $extension;

                  $filedetails['filepath'] = $filepath;
                  $filedetails['extension'] = $extension;

                  $this->Flash->success('File uploaded successfully.');
            } else {
                  $this->Flash->error('File not uploaded.');
            }
      }

      $this->set('filedetails', $filedetails);
      $this->set('uploadfile', $uploadfile);

        // $fileupload = $this->paginate($this->Fileupload);

        // $this->set(compact('fileupload'));
    }

    /**
     * View method
     *
     * @param string|null $id Fileupload id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fileupload = $this->Fileupload->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('fileupload'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $fileupload = $this->Fileupload->newEmptyEntity();
        if ($this->request->is('post')) {
            $fileupload = $this->Fileupload->patchEntity($fileupload, $this->request->getData());
            if ($this->Fileupload->save($fileupload)) {
                $this->Flash->success(__('The fileupload has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fileupload could not be saved. Please, try again.'));
        }
        $this->set(compact('fileupload'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Fileupload id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $fileupload = $this->Fileupload->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fileupload = $this->Fileupload->patchEntity($fileupload, $this->request->getData());
            if ($this->Fileupload->save($fileupload)) {
                $this->Flash->success(__('The fileupload has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fileupload could not be saved. Please, try again.'));
        }
        $this->set(compact('fileupload'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Fileupload id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fileupload = $this->Fileupload->get($id);
        if ($this->Fileupload->delete($fileupload)) {
            $this->Flash->success(__('The fileupload has been deleted.'));
        } else {
            $this->Flash->error(__('The fileupload could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
