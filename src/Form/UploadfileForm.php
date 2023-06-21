<?php
declare(strict_types=1);

namespace App\Form;

use Cake\Filesystem\Folder;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * Uploadfile Form.
 */
class UploadfileForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema;
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
               ->notEmptyFile('fileel')
               ->add('fileel', [
                      'mimeType' => [
                           'rule' => ['mimeType',['image/jpg','image/png','image/jpeg','application/pdf']],
                           'message' => 'File type must be .jpg,.jpeg,.png,.pdf',
                      ],
                      'fileSize' => [
                           'rule' => ['fileSize','<', '20MB'],
                           'message' => 'File size must be less than 20MB',
                      ]
               ]);
        return $validator;
    }

    /**
     * Defines what to execute once the Form is processed
     *
     * @param array $data Form data.
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        $attachment = $data['fileel'];

        // File details
        $filename = $attachment->getClientFilename();
        $type = $attachment->getClientMediaType();
        $size = $attachment->getSize();
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $tmpName = $attachment->getStream()->getMetadata('uri');
        $error = $attachment->getError();
        // var_dump($attachment);
        // exit();

        // Upload file
        if($error == 0){

                $location = WWW_ROOT . 'uploads' . DS;

                if(!file_exists($location)){ // Not exists
                    mkdir($location, 0777);
                }

                $targetPath = $location.$filename;
                $attachment->moveTo($targetPath);

                return true;
        }else{
                return false;
        }
    }
}
