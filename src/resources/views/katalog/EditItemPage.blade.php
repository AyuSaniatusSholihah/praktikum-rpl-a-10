<x-layout title="Edit Item — SEWAIN">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/katalog.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/edititempage.css') }}" />
    </x-slot:styles>

<section class="add-item-page">
 <div class="container" style="max-width:1280px;">

   <h1 class="katalog-title">My Katalogs</h1>
   <nav class="katalog-breadcrumb" aria-label="Breadcrumb">
     <a href="{{ route('home') }}">Home</a>
     <span class="sep">›</span>
     <a href="{{ route('katalog') }}" class="current">My Katalogs</a>
   </nav>

   <div class="profile-publish-row">
     <div class="profile-card">
       <div class="profile-photo">
         <img src="{{ asset('assets/img/katalog/profile-placeholder.jpg') }}" alt="Camping Groups Bandung" onerror="this.style.display='none'"/>
       </div>
       <div class="profile-info">
         <h2 class="profile-name">Camping Groups Bandung</h2>
         <div class="profile-detail-grid">
           <div class="label lokasi-label">
            <svg width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.66667 7.08333C6.05625 7.08333 6.38976 6.94462 6.66719 6.66719C6.94462 6.38976 7.08333 6.05625 7.08333 5.66667C7.08333 5.27708 6.94462 4.94358 6.66719 4.66615C6.38976 4.38872 6.05625 4.25 5.66667 4.25C5.27708 4.25 4.94358 4.38872 4.66615 4.66615C4.38872 4.94358 4.25 5.27708 4.25 5.66667C4.25 6.05625 4.38872 6.38976 4.66615 6.66719C4.94358 6.94462 5.27708 7.08333 5.66667 7.08333ZM5.66667 14.1667C3.76597 12.5493 2.34635 11.047 1.40781 9.6599C0.469271 8.27274 0 6.98889 0 5.80833C0 4.0375 0.569618 2.62674 1.70885 1.57604C2.84809 0.525347 4.16736 0 5.66667 0C7.16597 0 8.48524 0.525347 9.62448 1.57604C10.7637 2.62674 11.3333 4.0375 11.3333 5.80833C11.3333 6.98889 10.8641 8.27274 9.92552 9.6599C8.98698 11.047 7.56736 12.5493 5.66667 14.1667Z" fill="#727272"/></svg>
             Lokasi
           </div>
           <div class="value">Kota Bandung</div>

           <div class="label">Rating</div>
           <div class="value">
             <span class="star">★</span>
             <span style="position: relative; top: 4px;"> 4,3 (120 Reviews)</span>
           </div>

           <div class="label">Jumlah Katalog</div>
           <div class="value" id="profileJumlahKatalog">0 Barang</div>

           <div class="label wa-label">
             <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.2019 13.2332V15.7332C18.2029 15.9653 18.153 16.195 18.0554 16.4077C17.9577 16.6203 17.8145 16.8112 17.635 16.9681C17.4554 17.125 17.2434 17.2445 17.0126 17.3188C16.7817 17.3932 16.5371 17.4208 16.2944 17.3999C13.6019 17.1213 11.0155 16.245 8.74316 14.8416C6.62901 13.5621 4.83658 11.855 3.49316 9.84155C2.01439 7.66756 1.09412 5.19238 0.806907 2.61655C0.785041 2.38611 0.813797 2.15385 0.891345 1.93457C0.968892 1.71529 1.09353 1.51379 1.25733 1.3429C1.42112 1.17201 1.62049 1.03548 1.84272 0.941987C2.06496 0.848498 2.3052 0.800103 2.54816 0.799885H5.17316C5.5978 0.795905 6.00947 0.939118 6.33145 1.20283C6.65342 1.46654 6.86372 1.83276 6.92316 2.23322C7.03395 3.03327 7.23943 3.81882 7.53566 4.57489C7.65338 4.87316 7.67886 5.19731 7.60907 5.50895C7.53929 5.82059 7.37716 6.10664 7.14191 6.33322L6.03066 7.39155C7.27627 9.47784 9.09005 11.2053 11.2807 12.3916L12.3919 11.3332C12.6298 11.1092 12.9302 10.9548 13.2574 10.8883C13.5846 10.8218 13.925 10.8461 14.2382 10.9582C15.032 11.2403 15.8568 11.436 16.6969 11.5416C17.122 11.5987 17.5101 11.8026 17.7876 12.1145C18.0651 12.4264 18.2126 12.8245 18.2019 13.2332Z" stroke="#1E1E1E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
             WhatsApp
           </div>
           <div class="value">0821-5620-9034</div>
         </div>
       </div>
     </div>
        <button class="btn-delete-listing" id="btnDelete" aria-label="Delete listing" title="Hapus Listing">
            <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20.125 3.9375H16.625V1.75C16.625 0.784766 15.8402 0 14.875 0H6.125C5.15977 0 4.375 0.784766 4.375 1.75V3.9375H0.875C0.391016 3.9375 0 4.32852 0 4.8125V5.6875C0 5.80781 0.0984375 5.90625 0.21875 5.90625H1.87031L2.5457 20.207C2.58945 21.1395 3.36055 21.875 4.29297 21.875H16.707C17.6422 21.875 18.4105 21.1422 18.4543 20.207L19.1297 5.90625H20.7812C20.9016 5.90625 21 5.80781 21 5.6875V4.8125C21 4.32852 20.609 3.9375 20.125 3.9375ZM14.6562 3.9375H6.34375V1.96875H14.6562V3.9375Z" fill="white"/>
            </svg>
        </button>
     </div>

   <div class="upload-section">

     <label class="upload-box large" for="upload_a1" id="mainImageLabel">
       <img src="" id="mainImagePreview" alt="Foto Barang" style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: 8px;"/>
        <input type="file" id="upload_a1" accept="image/*" hidden/>
     </label>

     <div class="upload-side">
       <label class="upload-box" for="upload1">
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
         <span class="upload-label">Angle 1</span>
         <input type="file" id="upload1" accept="image/*" hidden/>
       </label>
       <label class="upload-box" for="upload3">
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
         <span class="upload-label">Angle 3</span>
         <input type="file" id="upload3" accept="image/*" hidden/>
       </label>
       <div class="upload-date">
         <div class="date-title">Tanggal Item Mulai<br/>Tersedia</div>
        <div class="date-value">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
              <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
            </svg>
          <span id="displayStart"></span>
          <input type="date" class="date-hidden" id="dateStart"/>
        </div>
       </div>
     </div>

     <div class="upload-side">
       <label class="upload-box" for="upload2">
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
         <span class="upload-label">Angle 2</span>
         <input type="file" id="upload2" accept="image/*" hidden/>
       </label>
       <label class="upload-box" for="upload4">
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
         <span class="upload-label">Angle 4</span>
         <input type="file" id="upload4" accept="image/*" hidden/>
       </label>
       <div class="upload-date">
         <div class="date-title">Tanggal Item tidak<br/>Tersedia</div>
          <div class="date-value">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
              <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
            </svg>
          <span id="displayEnd"></span>
          <input type="date" class="date-hidden" id="dateEnd"/>
        </div>
       </div>
     </div>

   </div>

   <div class="item-details-section">
     <h2 class="item-details-title">Item Details</h2>

     <div class="item-details-grid">

       <div class="form-col">
         <div class="form-group">
           <label for="itemName">Item Name</label>
           <input type="text" id="itemName" value=""/>
         </div>

         <div class="form-group">
           <label for="category">Category</label>
           <select id="category">
             <option value="Camping">Camping</option>
             <option value="Vehicles">Vehicles</option>
             <option value="Photography">Photography</option>
             <option value="Electronics">Electronics</option>
             <option value="Fashion">Fashion</option>
             <option value="Tools">Tools</option>
           </select>
         </div>

         <div class="form-group">
           <label for="price">Harga</label>
           <input type="text" id="price" value=""/>
         </div>

         <div class="form-group">
           <label for="description">Description</label>
           <textarea id="description"></textarea>
         </div>

         <div class="form-group">
           <label for="whatsapp">WhatsApp</label>
           <input type="tel" id="whatsapp" value=""/>
         </div>

         <div class="form-group">
           <label for="lokasi">Lokasi</label>
           <input type="text" id="lokasi" value=""/>
         </div>
       </div>

       <div class="form-col">
         <div class="form-group">
           <label for="addInfo">Additional Informations</label>
           <textarea id="addInfo" class="large"></textarea>
         </div>

         <div class="form-group">
           <label for="jaminan">Jaminan</label>
           <input type="text" id="jaminan" value=""/>
         </div>

         <div class="form-group">
           <label for="denda">Denda</label>
           <input type="text" id="denda" value=""/>
         </div>

         <div class="form-group">
           <div class="form-group-label">Stock Quantity</div>
           <div class="stock-qty">
             <button type="button" id="stockMinus" aria-label="Decrease">−</button>
             <span class="qty-num" id="stockNum">01</span>
             <button type="button" id="stockPlus" aria-label="Increase">+</button>
           </div>
         </div>
       </div>

     </div>
   </div>

   <div class="save-row">
     <button class="btn-save-changes" id="btnSave">SAVE CHANGES</button>
   </div>

 </div>
</section>

<x-slot:scripts>
<script>
 /* ============ LOAD DATA FROM STORAGE ============ */
const saved = JSON.parse(localStorage.getItem('publishedItem') || '{}');
let imgBase64 = saved.img || '';

 // Pratinjau Gambar Utama Berdasarkan Data Database Aktif
 if (imgBase64) {
    const mainImgLabel = document.getElementById('mainImageLabel');
    const mainImgPreview = document.getElementById('mainImagePreview');
    if (mainImgPreview) {
        mainImgPreview.src = imgBase64;
        mainImgPreview.style.display = 'block';
        if (mainImgLabel) mainImgLabel.classList.add('filled');
    }
 }

 /* ============ STOCK QUANTITY ============ */
 let stockQty = 1;
 const stockNum = document.getElementById('stockNum');
 document.getElementById('stockMinus').addEventListener('click', () => {
   if (stockQty > 1) { stockQty--; stockNum.textContent = String(stockQty).padStart(2, '0'); }
 });
 document.getElementById('stockPlus').addEventListener('click', () => {
   if (stockQty < 99) { stockQty++; stockNum.textContent = String(stockQty).padStart(2, '0'); }
 });

 /* ============ IMAGE UPLOAD PREVIEW ============ */
 document.querySelectorAll('input[type="file"]').forEach(input => {
   input.addEventListener('change', (e) => {
     const file = e.target.files[0];
     if (!file) return;
     const label = input.closest('.upload-box');
     const reader = new FileReader();
     reader.onload = ev => {
       label.classList.add('filled');
       
       if (input.id === 'upload_a1') {
           const mainImgPreview = document.getElementById('mainImagePreview');
           if (mainImgPreview) {
               mainImgPreview.src = ev.target.result;
               mainImgPreview.style.display = 'block';
           }
           imgBase64 = ev.target.result;
       } else {
           label.style.backgroundImage = `url(${ev.target.result})`;
           label.style.backgroundSize = 'cover';
           label.style.backgroundPosition = 'center';
           const svg = label.querySelector('svg'); if (svg) svg.style.display = 'none';
           const lbl = label.querySelector('.upload-label'); if (lbl) lbl.style.display = 'none';
       }
     };
     reader.readAsDataURL(file);
   });
 });

 /* ============ DELETE LISTING ============ */
document.getElementById('btnDelete').addEventListener('click', () => {
  if (confirm('Yakin mau hapus listing ini? Aksi ini tidak bisa dibatalkan.')) {
    const katalogs = JSON.parse(localStorage.getItem('katalogs') || '[]');
    const filtered = katalogs.filter(k => k.title !== saved.nama);
    localStorage.setItem('katalogs', JSON.stringify(filtered));
    localStorage.removeItem('publishedItem');
    alert('Listing berhasil dihapus');
    window.location.href = '{{ route('katalog') }}';
  }
});

 /* ============ SAVE CHANGES ============ */
document.getElementById('btnSave').addEventListener('click', () => {
  const updated = {
    ...saved,
    tglMulai:   document.getElementById('dateStart').value,
    tglSelesai: document.getElementById('dateEnd').value,
    nama:       document.getElementById('itemName').value,
    kategori:   document.getElementById('category').value,
    harga:      parseInt(document.getElementById('price').value.replace(/\D/g, '')) || saved.harga || 0,
    deskripsi:  document.getElementById('description').value,
    addInfo:    document.getElementById('addInfo').value,
    stok:       stockQty,
    img:        imgBase64,
    pemilik: {
      ...saved.pemilik,
      wa:      document.getElementById('whatsapp').value,
      jaminan: document.getElementById('jaminan').value,
      denda:   document.getElementById('denda').value,
      lokasi:  document.getElementById('lokasi').value,
    }
  };

    const katalogs = JSON.parse(localStorage.getItem('katalogs') || '[]');
    const idx = katalogs.findIndex(k => k.title === saved.nama);
    if (idx > -1) {
      katalogs[idx] = {
        ...katalogs[idx],
        title: document.getElementById('itemName').value,
        loc:   document.getElementById('lokasi').value || katalogs[idx].loc,
        price: parseInt(document.getElementById('price').value.replace(/\D/g, '')) || katalogs[idx].price,
        stock: stockQty,
        img:   imgBase64 || katalogs[idx].img,
      };
      localStorage.setItem('katalogs', JSON.stringify(katalogs));
    }

  localStorage.setItem('publishedItem', JSON.stringify(updated));
  alert('Perubahan berhasil disimpan!');
  window.location.href = '{{ route('katalog') }}';
});

if (saved.tglMulai) {
  document.getElementById('dateStart').value = saved.tglMulai;
  document.getElementById('displayStart').textContent =
    new Date(saved.tglMulai).toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
}
if (saved.tglSelesai) {
  document.getElementById('dateEnd').value = saved.tglSelesai;
  document.getElementById('displayEnd').textContent =
    new Date(saved.tglSelesai).toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
}

// Auto-fill form murni dari database yang tersimpan di localStorage
if (saved.nama) document.getElementById('itemName').value = saved.nama;
if (saved.harga) document.getElementById('price').value = 'Rp ' + saved.harga.toLocaleString('id-ID') + '/hari';
if (saved.deskripsi) document.getElementById('description').value = saved.deskripsi;
if (saved.addInfo) document.getElementById('addInfo').value = saved.addInfo;
if (saved.kategori) document.getElementById('category').value = saved.kategori;
if (saved.stok) { stockQty = saved.stok; stockNum.textContent = String(stockQty).padStart(2, '0'); }
if (saved.pemilik?.wa) document.getElementById('whatsapp').value = saved.pemilik.wa;
if (saved.pemilik?.jaminan) document.getElementById('jaminan').value = saved.pemilik.jaminan;
if (saved.pemilik?.denda) document.getElementById('denda').value = saved.pemilik.denda;
if (saved.pemilik?.lokasi) document.getElementById('lokasi').value = saved.pemilik.lokasi;

// Set counter stats profile berdasarkan total database lokal jika ada
const localKatalogs = JSON.parse(localStorage.getItem('katalogs') || '[]');
if(localKatalogs.length > 0) {
    document.getElementById('profileJumlahKatalog').textContent = localKatalogs.length + ' Barang';
}

/* ============ DATE PICKER ============ */
document.getElementById('dateStart').addEventListener('change', function() {
  const d = new Date(this.value);
  document.getElementById('displayStart').textContent =
    d.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
});
document.getElementById('dateEnd').addEventListener('change', function() {
  const d = new Date(this.value);
  document.getElementById('displayEnd').textContent =
    d.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
});
</script>
</x-slot:scripts>
</x-layout>