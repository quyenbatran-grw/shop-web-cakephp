<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
<div class="row">
    <div class="col-6">

        <?php

        // Upload form
        echo $this->Form->create($uploadfile,array('url'=>['controller' => 'fileupload','action' => 'index'],"enctype" => "multipart/form-data" ));
        echo $this->Form->control('fileel',['label' => 'Select file','type' => 'file','class' => 'form-control','required' => true]);
        echo $this->Form->button('Submit');
        echo $this->Form->end();

        ?>

        <?php
        // Preview file
        if(count($filedetails) > 0){
             $image_exts = array("jpg","jpeg","png");
             if(in_array($filedetails['extension'],$image_exts)){
                  echo $this->HTML->image($filedetails['filepath']);
             }else{
                  echo $this->Html->link(
                      'View file',
                      $filedetails['filepath'],
                      ['target' => '_blank']
                  );
             }
        }
        ?>

    </div>
</div>
</div>
