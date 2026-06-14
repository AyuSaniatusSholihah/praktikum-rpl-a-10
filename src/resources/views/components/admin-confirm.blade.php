<div id="adminToast">
    <div class="toast-icon warning" id="adminToastIcon">⚠️</div>
    <div class="toast-body">
        <div class="toast-title" id="adminToastTitle">Konfirmasi</div>
        <div class="toast-msg" id="adminToastMsg">Apakah Anda yakin?</div>
        <div>
            <button class="toast-action-btn" id="adminToastConfirmBtn">Ya, Lanjutkan</button>
            <button class="toast-cancel-btn" onclick="closeAdminConfirm()">Batal</button>
        </div>
    </div>
    <button class="toast-close" onclick="closeAdminConfirm()">&times;</button>
</div>

<script>
    let currentAdminConfirmFormId = null;

    function showAdminConfirm(title, msg, formId) {
        document.getElementById('adminToastTitle').innerText = title;
        document.getElementById('adminToastMsg').innerText = msg;
        currentAdminConfirmFormId = formId;
        
        const toast = document.getElementById('adminToast');
        toast.classList.add('show');
    }

    function closeAdminConfirm() {
        const toast = document.getElementById('adminToast');
        toast.classList.remove('show');
        currentAdminConfirmFormId = null;
    }

    document.getElementById('adminToastConfirmBtn').addEventListener('click', function() {
        if (currentAdminConfirmFormId) {
            document.getElementById(currentAdminConfirmFormId).submit();
        }
        closeAdminConfirm();
    });
</script>
