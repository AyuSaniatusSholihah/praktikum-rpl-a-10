<style>
/* ===== SEWAIN CONFIRM TOAST ===== */
#sewainConfirmToast {
    position: fixed;
    bottom: 32px;
    left: 50%;
    transform: translateX(-50%) translateY(100px);
    z-index: 99999;
    display: flex;
    align-items: flex-start;
    gap: 14px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.18), 0 2px 8px rgba(0,0,0,0.08);
    padding: 18px 24px 18px 20px;
    min-width: 320px;
    max-width: 420px;
    opacity: 0;
    transition: transform 0.4s cubic-bezier(.34,1.56,.64,1), opacity 0.4s ease;
    pointer-events: none;
}
#sewainConfirmToast.show {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
    pointer-events: auto;
}
#sewainConfirmToast .toast-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 20px;
    background: #fff7ed;
    color: #f97316;
}
#sewainConfirmToast .toast-body { flex: 1; text-align: left; }
#sewainConfirmToast .toast-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 15px;
    color: #181A18;
    margin-bottom: 4px;
}
#sewainConfirmToast .toast-msg {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    color: #555;
    line-height: 1.5;
}
#sewainConfirmToast .toast-action-btn {
    margin-top: 12px;
    display: inline-block;
    padding: 7px 18px;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    background: #181A18;
    color: #fff;
    margin-right: 8px;
}
#sewainConfirmToast .toast-action-btn:hover { background: #333; }
#sewainConfirmToast .toast-cancel-btn {
    margin-top: 12px;
    display: inline-block;
    padding: 7px 18px;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    border: 1px solid #ccc;
    background: #fff;
    color: #333;
}
#sewainConfirmToast .toast-cancel-btn:hover { background: #f9fafb; }
#sewainConfirmToast .toast-close {
    position: absolute;
    top: 12px;
    right: 14px;
    background: none;
    border: none;
    font-size: 18px;
    color: #aaa;
    cursor: pointer;
    line-height: 1;
    padding: 0;
}
</style>
<!-- SEWAIN CONFIRM TOAST (User Facing) -->
<div id="sewainConfirmToast">
    <div class="toast-icon warning" id="sewainConfirmIcon">⚠️</div>
    <div class="toast-body">
        <div class="toast-title" id="sewainConfirmTitle">Konfirmasi</div>
        <div class="toast-msg" id="sewainConfirmMsg">Apakah Anda yakin?</div>
        <div>
            <button class="toast-action-btn" id="sewainConfirmBtn">Ya, Lanjutkan</button>
            <button class="toast-cancel-btn" onclick="closeSewainConfirm()">Batal</button>
        </div>
    </div>
    <button class="toast-close" onclick="closeSewainConfirm()">&times;</button>
</div>

<script>
    let currentSewainConfirmFormId = null;

    function showSewainConfirm(title, msg, formId) {
        document.getElementById('sewainConfirmTitle').innerText = title;
        document.getElementById('sewainConfirmMsg').innerText = msg;
        currentSewainConfirmFormId = formId;
        
        const toast = document.getElementById('sewainConfirmToast');
        toast.classList.add('show');
    }

    function closeSewainConfirm() {
        const toast = document.getElementById('sewainConfirmToast');
        toast.classList.remove('show');
        currentSewainConfirmFormId = null;
    }

    document.getElementById('sewainConfirmBtn').addEventListener('click', function() {
        if (currentSewainConfirmFormId) {
            document.getElementById(currentSewainConfirmFormId).submit();
        }
        closeSewainConfirm();
    });
</script>
