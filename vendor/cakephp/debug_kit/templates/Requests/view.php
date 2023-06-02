<?php
/**
 * @var \DebugKit\View\AjaxView $this
 * @var \DebugKit\Model\Entity\Request $toolbar
 */

use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Utility\Inflector;

?>
<div class="c-panel-content-container js-panel-content-container">
    <span class="c-panel-content-container__close js-panel-close"></span>
    <div class="c-panel-content-container__content">
        <!-- content here -->
    </div>
</div>


<?php
    $this->Html->script('DebugKit./js/jquery', [
        'block' => true,
    ]);
    $this->Html->script('DebugKit./js/main', [
        'type' => 'module',
        'block' => true,
        'id' => '__debug_kit_app',
        'data-id' => $toolbar->id,
        'data-url' => Router::url('/', true),
        'data-webroot' => $this->getRequest()->getAttribute('webroot'),
    ]);
    ?>
