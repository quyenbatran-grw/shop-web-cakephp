<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="position-fixed bottom-0 end-0 p-3 position-relative top-0 end-0 mt-5 text-danger" style="z-index: 5">
    <div
        id="liveToast"
        class="toast showing bg-wheat"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
    >
        <div class="d-flex">
            <div class="toast-body">
            <?=$message?>
            </div>
            <button type="button" class="btn-close me-2 m-auto text-white" data-bs-dismiss="toast" aria-label="閉じる"></button>
        </div>
    </div>
</div>
<script>
    let closeBtn = document.querySelector('.btn-close');
    closeBtn.addEventListener('click', () => {
        document.getElementById('liveToast').classList.remove('showing');
        document.getElementById('liveToast').classList.add('hide');
    });

    setTimeout(() => {
        const event = new Event('click')
        closeBtn.dispatchEvent(event);
        console.log('timeout')
    }, 2000);


</script>

