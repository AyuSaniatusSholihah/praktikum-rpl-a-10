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

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-family: 'Poppins', sans-serif;">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-family: 'Poppins', sans-serif;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="delete-form-{{ $product->id }}" action="{{ route('katalog.delete-item', $product->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <form action="{{ route('katalog.edit-item.post', $product->id) }}" method="POST" enctype="multipart/form-data" id="editItemForm">
        @csrf

        <div class="profile-publish-row">
          <div class="profile-card">
            <div class="profile-photo">
              @php
                  $authUser = auth()->user();
                  $fotoProfil = ($authUser && $authUser->foto_profil)
                      ? asset('storage/' . $authUser->foto_profil)
                      : asset('assets/img/katalog/profile-placeholder.jpg');
                  $katalogCount = $authUser ? $authUser->barangs()->count() : 0;
              @endphp
              <img src="{{ $fotoProfil }}" alt="{{ $authUser->name ?? 'User' }}" onerror="this.style.display='none'"/>
            </div>
            <div class="profile-info">
              <h2 class="profile-name">{{ $authUser->name ?? 'Pengguna' }}</h2>
              <div class="profile-detail-grid">
                <div class="label lokasi-label">
                 <svg width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.66667 7.08333C6.05625 7.08333 6.38976 6.94462 6.66719 6.66719C6.94462 6.38976 7.08333 6.05625 7.08333 5.66667C7.08333 5.27708 6.94462 4.94358 6.66719 4.66615C6.38976 4.38872 6.05625 4.25 5.66667 4.25C5.27708 4.25 4.94358 4.38872 4.66615 4.66615C4.38872 4.94358 4.25 5.27708 4.25 5.66667C4.25 6.05625 4.38872 6.38976 4.66615 6.66719C4.94358 6.94462 5.27708 7.08333 5.66667 7.08333ZM5.66667 14.1667C3.76597 12.5493 2.34635 11.047 1.40781 9.6599C0.469271 8.27274 0 6.98889 0 5.80833C0 4.0375 0.569618 2.62674 1.70885 1.57604C2.84809 0.525347 4.16736 0 5.66667 0C7.16597 0 8.48524 0.525347 9.62448 1.57604C10.7637 2.62674 11.3333 4.0375 11.3333 5.80833C11.3333 6.98889 10.8641 8.27274 9.92552 9.6599C8.98698 11.047 7.56736 12.5493 5.66667 14.1667Z" fill="#727272"/></svg>
                  Lokasi
                </div>
                <div class="value">{{ $authUser->alamat ?? 'Belum diatur' }}</div>

                <div class="label">Rating</div>
                <div class="value">
                  <span class="star" style="color: #f5b800;">★</span>
                  <span style="position: relative; top: 4px;"> 5,0 ({{ $katalogCount }} Item)</span>
                </div>

                <div class="label">Jumlah Katalog</div>
                <div class="value">{{ $katalogCount }} Barang</div>

                <div class="label wa-label">
                  <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.2019 13.2332V15.7332C18.2029 15.9653 18.153 16.195 18.0554 16.4077C17.9577 16.6203 17.8145 16.8112 17.635 16.9681C17.4554 17.125 17.2434 17.2445 17.0126 17.3188C16.7817 17.3932 16.5371 17.4208 16.2944 17.3999C13.6019 17.1213 11.0155 16.245 8.74316 14.8416C6.62901 13.5621 4.83658 11.855 3.49316 9.84155C2.01439 7.66756 1.09412 5.19238 0.806907 2.61655C0.785041 2.38611 0.813797 2.15385 0.891345 1.93457C0.968892 1.71529 1.09353 1.51379 1.25733 1.3429C1.42112 1.17201 1.62049 1.03548 1.84272 0.941987C2.06496 0.848498 2.3052 0.800103 2.54816 0.799885H5.17316C5.5978 0.795905 6.00947 0.939118 6.33145 1.20283C6.65342 1.46654 6.86372 1.83276 6.92316 2.23322C7.03395 3.03327 7.23943 3.81882 7.53566 4.57489C7.65338 4.87316 7.67886 5.19731 7.60907 5.50895C7.53929 5.82059 7.37716 6.10664 7.14191 6.33322L6.03066 7.39155C7.27627 9.47784 9.09005 11.2053 11.2807 12.3916L12.3919 11.3332C12.6298 11.1092 12.9302 10.9548 13.2574 10.8883C13.5846 10.8218 13.925 10.8461 14.2382 10.9582C15.032 11.2403 15.8568 11.436 16.6969 11.5416C17.122 11.5987 17.5101 11.8026 17.7876 12.1145C18.0651 12.4264 18.2126 12.8245 18.2019 13.2332Z" stroke="#1E1E1E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  WhatsApp
                </div>
                <div class="value">{{ $authUser->phone_number ?? 'Belum diatur' }}</div>
              </div>
            </div>
          </div>
          <button type="button" class="btn-delete-listing" id="btnDelete" aria-label="Delete listing" title="Hapus Listing">
              <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M20.125 3.9375H16.625V1.75C16.625 0.784766 15.8402 0 14.875 0H6.125C5.15977 0 4.375 0.784766 4.375 1.75V3.9375H0.875C0.391016 3.9375 0 4.32852 0 4.8125V5.6875C0 5.80781 0.0984375 5.90625 0.21875 5.90625H1.87031L2.5457 20.207C2.58945 21.1395 3.36055 21.875 4.29297 21.875H16.707C17.6422 21.875 18.4105 21.1422 18.4543 20.207L19.1297 5.90625H20.7812C20.9016 5.90625 21 5.80781 21 5.6875V4.8125C21 4.32852 20.609 3.9375 20.125 3.9375ZM14.6562 3.9375H6.34375V1.96875H14.6562V3.9375Z" fill="white"/>
              </svg>
          </button>
        </div>

        <div class="upload-section">

          <label class="upload-box large" for="upload_a1" id="mainImageLabel">
            <img src="{{ $product->foto_barang ? asset('storage/' . $product->foto_barang) : '' }}" id="mainImagePreview" alt="Foto Barang" style="{{ $product->foto_barang ? 'display: block;' : 'display: none;' }} width: 100%; height: 100%; object-fit: cover; border-radius: 8px;"/>
             <input type="file" name="foto_barang" id="upload_a1" accept="image/*" hidden/>
          </label>

          <div class="upload-side">
            <label class="upload-box" for="upload1"
              @if($product->fotoproduk1)
                style="background-image: url('{{ asset('storage/' . $product->fotoproduk1) }}'); background-size: cover; background-position: center;"
              @endif
            >
              @if(!$product->fotoproduk1)
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
              <span class="upload-label">Angle 1</span>
              @endif
              <input type="file" name="fotoproduk1" id="upload1" accept="image/*" hidden/>
            </label>
            <label class="upload-box" for="upload3"
              @if($product->fotoproduk3)
                style="background-image: url('{{ asset('storage/' . $product->fotoproduk3) }}'); background-size: cover; background-position: center;"
              @endif
            >
              @if(!$product->fotoproduk3)
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
              <span class="upload-label">Angle 3</span>
              @endif
              <input type="file" name="fotoproduk3" id="upload3" accept="image/*" hidden/>
            </label>
            <div class="upload-date">
              <div class="date-title">Tanggal Item Mulai<br/>Tersedia</div>
              <div class="date-value">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" 
                        style="flex-shrink:0;">
                    <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                    </svg>
                <span id="displayStart">{{ $product->tanggal_item_mulai ? $product->tanggal_item_mulai->translatedFormat('d M Y') : 'Pilih tanggal mulai' }}</span>
                <input type="date" name="tanggal_item_mulai" class="date-hidden" id="dateStart" value="{{ $product->tanggal_item_mulai ? $product->tanggal_item_mulai->format('Y-m-d') : '' }}"/>
              </div>
             </div>
           </div>

        <div class="upload-side">
          <label class="upload-box" for="upload2"
            @if($product->fotoproduk2)
              style="background-image: url('{{ asset('storage/' . $product->fotoproduk2) }}'); background-size: cover; background-position: center;"
            @endif
          >
            @if(!$product->fotoproduk2)
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <span class="upload-label">Angle 2</span>
            @endif
            <input type="file" name="fotoproduk2" id="upload2" accept="image/*" hidden/>
          </label>
          <label class="upload-box" for="upload4"
            @if($product->fotoproduk4)
              style="background-image: url('{{ asset('storage/' . $product->fotoproduk4) }}'); background-size: cover; background-position: center;"
            @endif
          >
            @if(!$product->fotoproduk4)
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <span class="upload-label">Angle 4</span>
            @endif
            <input type="file" name="fotoproduk4" id="upload4" accept="image/*" hidden/>
          </label>
          <div class="upload-date">
            <div class="date-title">Tanggal Item tidak<br/>Tersedia</div>
             <div class="date-value">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" 
                        style="flex-shrink:0;">
                    <path d="M15 3.33317H14.1667V2.49984C14.1667 2.27882 14.0789 2.06686 13.9226 1.91058C13.7663 1.7543 13.5543 1.6665 13.3333 1.6665C13.1123 1.6665 12.9004 1.7543 12.7441 1.91058C12.5878 2.06686 12.5 2.27882 12.5 2.49984V3.33317H7.5V2.49984C7.5 2.27882 7.4122 2.06686 7.25592 1.91058C7.09964 1.7543 6.88768 1.6665 6.66667 1.6665C6.44565 1.6665 6.23369 1.7543 6.07741 1.91058C5.92113 2.06686 5.83333 2.27882 5.83333 2.49984V3.33317H5C4.33696 3.33317 3.70107 3.59656 3.23223 4.0654C2.76339 4.53424 2.5 5.17013 2.5 5.83317V15.8332C2.5 16.4962 2.76339 17.1321 3.23223 17.6009C3.70107 18.0698 4.33696 18.3332 5 18.3332H15C15.663 18.3332 16.2989 18.0698 16.7678 17.6009C17.2366 17.1321 17.5 16.4962 17.5 15.8332V5.83317C17.5 5.17013 17.2366 4.53424 16.7678 4.0654C16.2989 3.59656 15.663 3.33317 15 3.33317ZM6.66667 14.1665C6.50185 14.1665 6.34073 14.1176 6.20369 14.0261C6.06665 13.9345 5.95984 13.8043 5.89677 13.6521C5.83369 13.4998 5.81719 13.3322 5.84935 13.1706C5.8815 13.0089 5.96087 12.8605 6.07741 12.7439C6.19395 12.6274 6.34244 12.548 6.50409 12.5159C6.66574 12.4837 6.8333 12.5002 6.98557 12.5633C7.13784 12.6263 7.26799 12.7332 7.35956 12.8702C7.45113 13.0072 7.5 13.1684 7.5 13.3332C7.5 13.5542 7.4122 13.7661 7.25592 13.9224C7.09964 14.0787 6.88768 14.1665 6.66667 14.1665ZM13.3333 14.1665H10C9.77899 14.1665 9.56702 14.0787 9.41074 13.9224C9.25446 13.7661 9.16667 13.5542 9.16667 13.3332C9.16667 13.1122 9.25446 12.9002 9.41074 12.7439C9.56702 12.5876 9.77899 12.4998 10 12.4998H13.3333C13.5543 12.4998 13.7663 12.5876 13.9226 12.7439C14.0789 12.9002 14.1667 13.1122 14.1667 13.3332C14.1667 13.5542 14.0789 13.7661 13.9226 13.9224C13.7663 14.0787 13.5543 14.1665 13.3333 14.1665ZM15.8333 9.1665H4.16667V5.83317C4.16667 5.61216 4.25446 5.4002 4.41074 5.24392C4.56702 5.08764 4.77899 4.99984 5 4.99984H5.83333V5.83317C5.83333 6.05418 5.92113 6.26615 6.07741 6.42243C6.23369 6.57871 6.44565 6.6665 6.66667 6.6665C6.88768 6.6665 7.09964 6.57871 7.25592 6.42243C7.4122 6.26615 7.5 6.05418 7.5 5.83317V4.99984H12.5V5.83317C12.5 6.05418 12.5878 6.26615 12.7441 6.42243C12.9004 6.57871 13.1123 6.6665 13.3333 6.6665C13.5543 6.6665 13.7663 6.57871 13.9226 6.42243C14.0789 6.26615 14.1667 6.05418 14.1667 5.83317V4.99984H15C15.221 4.99984 15.433 5.08764 15.5893 5.24392C15.7455 5.4002 15.8333 5.61216 15.8333 5.83317V9.1665Z" fill="#181A18"/>
                    </svg>
             <span id="displayEnd">{{ $product->tanggal_item_tidak_tersedia ? $product->tanggal_item_tidak_tersedia->translatedFormat('d M Y') : 'Pilih tanggal selesai' }}</span>
             <input type="date" name="tanggal_item_tidak_tersedia" class="date-hidden" id="dateEnd" value="{{ $product->tanggal_item_tidak_tersedia ? $product->tanggal_item_tidak_tersedia->format('Y-m-d') : '' }}"/>
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
                <input type="text" name="nama_barang" id="itemName" value="{{ old('nama_barang', $product->nama_barang) }}" maxlength="100" required/>
                <small id="namaCounter" style="font-size:11px; color:#8A8A8A; text-align:right; display:block; margin-top:4px;">0 / 100</small>
            </div>

            <div class="form-group" style="position: relative;">
              <label for="categorySearch">Category</label>
              <div class="searchable-select-wrapper" style="position: relative; width: 100%;">
                  <input type="text" id="categorySearch" placeholder="Cari kategori..." autocomplete="off" style="width: 100%; padding: 10px 14px; background: rgba(178, 201, 221, 0.5); border: 1px solid #8A8A8A; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 13px; color: #484848; outline: none;" value="{{ $product->kategori->nama_kategori ?? '' }}" required />
                  <input type="hidden" name="kategori_id" id="kategori_id_hidden" value="{{ old('kategori_id', $product->kategori_id) }}" />
                  <ul id="categoryOptions" style="display: none; position: absolute; left: 0; right: 0; top: 100%; max-height: 200px; overflow-y: auto; background: #fff; border: 1px solid #8A8A8A; border-radius: 0 0 6px 6px; z-index: 1000; list-style: none; margin: 0; padding: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                      @foreach($kategoris as $kategori)
                          <li class="option-item" data-value="{{ $kategori->id }}" style="padding: 10px 14px; cursor: pointer; color: #484848; font-family: 'Poppins', sans-serif; font-size: 13px; border-bottom: 1px solid #f0f0f0;" onmouseover="this.style.background='#DDE9F5'" onmouseout="this.style.background='none'">{{ $kategori->nama_kategori }}</li>
                      @endforeach
                  </ul>
              </div>
            </div>

            <div class="form-group">
              <label for="price">Harga Sewa (Rp / hari)</label>
              <input type="number" name="harga_sewa" id="price" value="{{ old('harga_sewa', (int)$product->harga_sewa) }}" required/>
            </div>

            <div class="form-group">
              <label for="description">Description</label>
              <textarea name="deskripsi" id="description" required>{{ old('deskripsi', $product->deskripsi) }}</textarea>
            </div>

            <div class="form-group">
              <label for="whatsapp">WhatsApp</label>
              <input type="tel" id="whatsapp" value="{{ auth()->user()->phone_number ?? '' }}" disabled title="No. WA diambil dari profil kamu" style="opacity: 0.7; cursor: not-allowed;"/>
            </div>

            <div class="form-group">
              <label for="lokasi">Lokasi</label>
              <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $product->lokasi) }}" required/>
            </div>
          </div>

          <div class="form-col">
            <div class="form-group">
              <label for="addInfo">Additional Informations</label>
              <textarea name="additional_information" id="addInfo" class="large">{{ old('additional_information', $product->additional_information) }}</textarea>
            </div>

            <div class="form-group">
              <label for="jaminan">Harga Jaminan (Rp)</label>
              <input type="number" name="harga_jaminan" id="jaminan" value="{{ old('harga_jaminan', (int)$product->harga_jaminan) }}" required/>
            </div>

            <div class="form-group">
              <label for="denda">Denda per jam (Rp)</label>
              <input type="number" name="harga_denda_perjam" id="denda" value="{{ old('harga_denda_perjam', (int)$product->harga_denda_perjam) }}" required/>
            </div>

            <div class="form-group">
              <div class="form-group-label">Stock Quantity</div>
              <div class="stock-qty">
                <button type="button" id="stockMinus" aria-label="Decrease">−</button>
                <span class="qty-num" id="stockNum">{{ str_pad($product->stok, 2, '0', STR_PAD_LEFT) }}</span>
                <button type="button" id="stockPlus" aria-label="Increase">+</button>
              </div>
              <input type="hidden" name="stok" id="stokInput" value="{{ $product->stok }}" />
            </div>
          </div>

        </div>
      </div>

      <div class="save-row">
        <button type="submit" class="btn-save-changes" id="btnSave">SAVE CHANGES</button>
      </div>

    </form>

  </div>
</section>

<x-slot:scripts>
<script>
const namaInput = document.getElementById('itemName');
const namaCounter = document.getElementById('namaCounter');
namaInput.addEventListener('input', function() {
    const len = this.value.length;
    namaCounter.textContent = len + ' / 100';
    namaCounter.style.color = len > 80 ? '#e53e3e' : '#8A8A8A';
});
namaCounter.textContent = (namaInput.value.length) + ' / 100';

 /* ============ STOCK QUANTITY ============ */
 let stockQty = {{ $product->stok }};
 const stockNum = document.getElementById('stockNum');
 const stokInput = document.getElementById('stokInput');
 document.getElementById('stockMinus').addEventListener('click', () => {
   if (stockQty > 1) {
     stockQty--;
     stockNum.textContent = String(stockQty).padStart(2, '0');
     stokInput.value = stockQty;
   }
 });
 document.getElementById('stockPlus').addEventListener('click', () => {
   if (stockQty < 99) {
     stockQty++;
     stockNum.textContent = String(stockQty).padStart(2, '0');
     stokInput.value = stockQty;
   }
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
       } else {
           label.style.backgroundImage = `url(${ev.target.result})`;
           label.style.backgroundSize = 'cover';
           label.style.backgroundPosition = 'center';
       }
     };
     reader.readAsDataURL(file);
   });
 });

 /* ============ DELETE LISTING ============ */
document.getElementById('btnDelete').addEventListener('click', (e) => {
  e.preventDefault();
  if (confirm('Yakin mau hapus listing ini? Aksi ini tidak bisa dibatalkan.')) {
    document.getElementById('delete-form-{{ $product->id }}').submit();
  }
});

/* ============ SEARCHABLE CATEGORY SELECT ============ */
const categorySearch = document.getElementById('categorySearch');
const categoryOptions = document.getElementById('categoryOptions');
const kategoriIdHidden = document.getElementById('kategori_id_hidden');
const optionItems = document.querySelectorAll('#categoryOptions .option-item');

categorySearch.addEventListener('focus', () => {
    categoryOptions.style.display = 'block';
});

categorySearch.addEventListener('input', (e) => {
    const term = e.target.value.toLowerCase();
    optionItems.forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(term) ? 'block' : 'none';
    });
    categoryOptions.style.display = 'block';
});

optionItems.forEach(item => {
    item.addEventListener('click', () => {
        categorySearch.value = item.textContent;
        kategoriIdHidden.value = item.getAttribute('data-value');
        categoryOptions.style.display = 'none';
    });
});

document.addEventListener('click', (e) => {
    if (!categorySearch.contains(e.target) && !categoryOptions.contains(e.target)) {
        categoryOptions.style.display = 'none';
    }
});

/* ============ DATE PICKER ============ */
const dateStart = document.getElementById('dateStart');
const dateEnd = document.getElementById('dateEnd');
const displayStart = document.getElementById('displayStart');
const displayEnd = document.getElementById('displayEnd');

function formatDateLabel(value) {
    if (!value) return '';
    const dateValue = new Date(value);
    if (Number.isNaN(dateValue.getTime())) return '';
    return dateValue.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
}

function syncDateFields() {
    displayStart.textContent = formatDateLabel(dateStart.value) || 'Pilih tanggal mulai';
    displayEnd.textContent = formatDateLabel(dateEnd.value) || 'Pilih tanggal selesai';

    if (dateStart.value) {
        dateEnd.min = dateStart.value;
    }

    if (dateStart.value && dateEnd.value && dateEnd.value < dateStart.value) {
        dateEnd.value = dateStart.value;
        displayEnd.textContent = formatDateLabel(dateEnd.value);
    }
}

dateStart.addEventListener('change', function() {
    if (this.value && dateEnd.value && dateEnd.value < this.value) {
        dateEnd.value = this.value;
    }
    syncDateFields();
});

dateEnd.addEventListener('change', syncDateFields);
</script>
</x-slot:scripts>
</x-layout>