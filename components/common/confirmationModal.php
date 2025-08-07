<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background: var(--surface);">
      <div class="modal-header">
        <h5 class="modal-title" id="title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="body">
      </div>
      <div class="modal-footer">
        <form method="POST">
          <input type="hidden" name="" id="hidden-value">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger border-0" id="conformation-btn"> Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>