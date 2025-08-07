<?php
function toast($status, $message, $bg)
{
  return '
  <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080; max-width: 100vw;">
    <div id="customToast" 
         class="toast align-items-center text-white border-0 show shadow-sm" 
         style="background-color:var(--' . $bg . '); max-width: 90vw;" 
         role="alert" 
         aria-live="assertive" 
         aria-atomic="true" 
         data-bs-delay="3000">
         
      <div class="d-flex">
        <div class="toast-body text-break">
          <strong>' . htmlspecialchars($status) . ':</strong> ' . htmlspecialchars($message) . '
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>';
}
?>