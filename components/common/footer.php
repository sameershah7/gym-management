<?php 
function footer() {
    return '
    <footer class="text-center py-4" style="border-top: 2px solid var(--primary); background-color: var(--surface); color: var(--text);">
        <div class="container">
            <p class="mb-0">&copy; ' . date("Y") . ' shah Fitness. All rights reserved.</p>
            <small class="text-muted">Made with ❤️ for your health and discipline.</small>
        </div>
    </footer>';
}
?>
