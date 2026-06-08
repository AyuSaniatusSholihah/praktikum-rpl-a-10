<x-layout title="Checkout Payment — SEWAIN">
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}" />
    </x-slot:styles>

    <div class="page-header">
        <h1>Checkout Payment</h1>
        <div class="breadcrumb-nav">
            <a href="{{ route('home') }}">Home</a>
            <span class="sep">›</span>
            <a href="{{ route('rentals') }}">Rentals</a>
            <span class="sep">›</span>
            <span class="current">Checkout Payment</span>
        </div>
    </div>

    @if(session('error'))
        <div style="max-width:1280px; margin:0 auto 20px auto; padding:15px; background-color:#ffebee; color:#c62828; border-radius:8px;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div style="max-width:1280px; margin:0 auto 20px auto; padding:15px; background-color:#ffebee; color:#c62828; border-radius:8px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="checkoutForm" action="{{ route('checkout.post') }}" method="POST">
        @csrf
        <input type="hidden" name="shipping_method" id="shipping_method" value="cod" />
        @if(isset($barangId))
            <input type="hidden" name="single_barang_id" value="{{ $barangId }}" />
        @endif
        <main class="checkout-main">
            <div class="form-side">
                <div class="form-section">
                    <div class="contact-header">
                        <div class="form-section-title">Contact</div>
                        <div class="have-account">
                            <span>Have an Account? </span>
                            <a href="{{ route('register') }}">Create Account</a>
                        </div>
                    </div>
                    <div class="form-row form-field" id="nameFields" 
                        style="{{ auth()->check() ? 'display:none;' : '' }}">
                        <input type="text" name="first_name" placeholder="First Name" 
                            {{ auth()->check() ? '' : 'required' }}
                            value="{{ auth()->check() ? auth()->user()->name : '' }}" />
                        <input type="text" name="last_name" placeholder="Last Name" 
                            {{ auth()->check() ? '' : 'required' }} />
                    </div>
                    <div class="form-field">
                        <input type="email" name="email" placeholder="Email Address" 
                            value="{{ auth()->user()->email ?? '' }}"
                            {{ auth()->check() ? 'readonly style=opacity:0.7' : 'required' }} />
                    </div>
                    <div class="form-field">
                        <input type="tel" name="phone" placeholder="Phone Number"
                            value="{{ auth()->user()->phone_number ?? '' }}"
                            {{ auth()->check() && auth()->user()->phone_number ? 'readonly style=opacity:0.7' : 'required' }} />
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">Metode Pengiriman</div>
                    <div class="shipping-toggle">
                        <div class="toggle-options">
                            <button type="button" class="toggle-btn active" onclick="selectShipping('cod', this)">COD (Ambil Sendiri)</button>
                            <button type="button" class="toggle-btn" onclick="selectShipping('delivery', this)">Delivery</button>
                        </div>
                    </div>
                </div>

                <div class="form-section delivery-section" id="deliverySection">
                    <div class="form-section-title">Delivery</div>
                    <div class="form-field">
                        <select name="country">
                            <option value="" disabled selected>Country / Region</option>
                            <option>Indonesia</option>
                            <option>Malaysia</option>
                            <option>Singapore</option>
                        </select>
                    </div>
                    <div class="form-row form-field">
                        <input type="text" name="ship_first_name" placeholder="First Name" />
                        <input type="text" name="ship_last_name" placeholder="Last Name" />
                    </div>
                    <div class="form-field"><input type="text" name="address" placeholder="Address" /></div>
                    <div class="form-row form-field">
                        <input type="text" name="city" placeholder="City & Province" />
                        <input type="text" name="kode_pos" placeholder="Kode Pos" />
                    </div>
                    <label class="checkbox-row"><input type="checkbox" /> Save This Info For Future</label>
                </div>

                <div class="form-section">
                    <div class="form-section-title">Payment Method</div>
                    <p class="payment-instruction">
                        Make your payment directly into our bank account. Please use your Order ID as the payment reference.
                        Your order will not be shipped until the funds have cleared in our account.
                    </p>
                    <div class="payment-methods-grid">
                        <div class="payment-method-card selected" id="selectedCard">
                            <div class="pm-left">
                                <input type="radio" class="pm-radio" name="payment_method" id="mainPaymentMethod" value="Credit Card" checked />
                                <div>
                                    <div class="pm-label" id="selectedLabel">Credit Card</div>
                                    <div class="pm-sub" id="selectedSub">Visa, Mastercard, dll</div>
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div id="selectedLogoContainer">
                                    <svg width="50" height="25" viewBox="0 0 50 25" style="border:1px solid #e0e0e0;border-radius:4px;">
                                        <rect width="50" height="25" rx="3" fill="#1A1F71" />
                                        <text x="8" y="17" font-family="Poppins" font-size="10" fill="white" font-weight="bold">VISA</text>
                                    </svg>
                                </div>
                                <span id="pmChevron" onclick="event.stopPropagation(); toggleDropdown()" style="cursor:pointer;transition:transform 0.2s;display:inline-flex;align-items:center;">
                                    <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.53366 7.78781L0.193175 1.92106C-0.0643917 1.63811 -0.0643917 1.17938 0.193175 0.896463L0.816057 0.212204C1.07318 -0.0702607 1.48991 -0.0708043 1.74765 0.210996L6.00001 4.8605L10.2524 0.210996C10.5101 -0.0708043 10.9268 -0.0702607 11.1839 0.212204L11.8068 0.896463C12.0644 1.17941 12.0644 1.63814 11.8068 1.92106L6.46637 7.78781C6.2088 8.07073 5.79122 8.07073 5.53366 7.78781Z" fill="#484848" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div id="pmDropdown" style="display:none;flex-direction:column;gap:6px;margin-top:4px;">
                            <div class="payment-method-card" onclick="selectPayment('credit', 'Credit Card', 'Visa, Mastercard, dll', 'credit')">
                                <div class="pm-left"><input type="radio" class="pm-radio" name="dummy_pm" value="credit" />
                                    <div><div class="pm-label">Credit Card</div><div class="pm-sub">Visa, Mastercard, dll</div></div>
                                </div>
                                <svg width="50" height="25" viewBox="0 0 50 25" style="border:1px solid #e0e0e0;border-radius:4px;">
                                    <rect width="50" height="25" rx="3" fill="#1A1F71" />
                                    <text x="8" y="17" font-family="Poppins" font-size="10" fill="white" font-weight="bold">VISA</text>
                                </svg>
                            </div>
                            <div class="payment-method-card" onclick="selectPayment('qris', 'QRIS', 'Scan QR untuk bayar', 'qris')">
                                <div class="pm-left"><input type="radio" class="pm-radio" name="dummy_pm" value="qris" />
                                    <div><div class="pm-label">QRIS</div><div class="pm-sub">Scan QR untuk bayar</div></div>
                                </div>
                                <svg width="50" height="25" viewBox="0 0 50 25" style="border:1px solid #e0e0e0;border-radius:4px;">
                                    <image href="{{ asset('assets/img/logo qris.png') }}" width="50" height="25" />
                                </svg>
                            </div>
                            <div class="payment-method-card" onclick="selectPayment('transfer', 'Transfer Bank', 'BCA, Mandiri, BRI, BNI', 'transfer')">
                                <div class="pm-left"><input type="radio" class="pm-radio" name="dummy_pm" value="transfer" />
                                    <div><div class="pm-label">Transfer Bank</div><div class="pm-sub">BCA, Mandiri, BRI, BNI</div></div>
                                </div>
                                <svg width="50" height="25" viewBox="0 0 50 25" style="border:1px solid #e0e0e0;border-radius:4px;">
                                    <image href="{{ asset('assets/img/logo bank tf.png') }}" width="50" height="25" />
                                </svg>
                            </div>
                            <div class="payment-method-card" onclick="selectPayment('ewallet', 'E-Wallet', 'GoPay, OVO, ShopeePay, Dana', 'ewallet')">
                                <div class="pm-left"><input type="radio" class="pm-radio" name="dummy_pm" value="ewallet" />
                                    <div><div class="pm-label">E‑Wallet</div><div class="pm-sub">GoPay, OVO, ShopeePay, Dana</div></div>
                                </div>
                                <svg width="50" height="25" viewBox="0 0 50 25" style="border:1px solid #e0e0e0;border-radius:4px;">
                                    <image href="{{ asset('assets/img/logo e-wallet.png') }}" width="50" height="25" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="payment-panel active" id="panel-credit">
                        <div class="form-field card-field"><input type="text" placeholder="Card Number" /></div>
                        <div class="form-row form-field">
                            <input type="text" placeholder="Expiration Date (MM/YY)" />
                            <input type="text" placeholder="Security Code" />
                        </div>
                        <div class="form-field"><input type="text" placeholder="Card Holder Name" /></div>
                        <label class="checkbox-row"><input type="checkbox" /> Save This Info For Future</label>
                    </div>

                    <div class="payment-panel" id="panel-qris">
                        <div style="display:flex; gap:16px; align-items:flex-start;">
                            <img src="{{ asset('assets/img/qris kode.webp') }}" alt="QRIS Code" style="width:140px;height:140px;object-fit:contain;border:1px solid #e0e0e0;border-radius:4px;flex-shrink:0;" />
                            <div style="flex:1;display:flex;flex-direction:column;gap:10px;">
                                <div class="bank-row"><label>A/n</label><div class="value">SEWAIN</div></div>
                                <div class="bank-row"><label>Nominal</label><div class="value" id="qrisNominal">Rp 0</div></div>
                            </div>
                        </div>
                        <label class="checkbox-row" style="margin-top:12px;"><input type="checkbox" /> Save This Info For Future</label>
                    </div>

                    <div class="payment-panel" id="panel-transfer">
                        <div style="position:relative; margin-bottom:12px;">
                            <div onclick="toggleBankDropdown()" style="display:flex;justify-content:space-between;align-items:center;border:1px solid #e0e0e0;padding:10px 14px;cursor:pointer;background:#fff;">
                                <span id="selectedBankName" style="font-size:13px;font-weight:600;color:var(--dark);">BCA</span>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <img id="selectedBankLogo" src="{{ asset('assets/img/bca.png') }}" width="40" height="25" style="object-fit:contain;" />
                                    <svg width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M5.53366 7.78781L0.193175 1.92106C-0.0643917 1.63811 -0.0643917 1.17938 0.193175 0.896463L0.816057 0.212204C1.07318 -0.0702607 1.48991 -0.0708043 1.74765 0.210996L6.00001 4.8605L10.2524 0.210996C10.5101 -0.0708043 10.9268 -0.0702607 11.1839 0.212204L11.8068 0.896463C12.0644 1.17941 12.0644 1.63814 11.8068 1.92106L6.46637 7.78781C6.2088 8.07073 5.79122 8.07073 5.53366 7.78781Z" fill="#484848"/></svg>
                                </div>
                            </div>
                            <div id="bankDropdown" style="display:none;position:absolute;top:100%;left:0;right:0;background:#fff;border:1px solid #e0e0e0;border-top:none;z-index:10;">
                                <div onclick="selectBank2('BCA','0978 5634 21196','{{ asset('assets/img/bca.png') }}')" style="display:flex;justify-content:space-between;align-items:center;padding:10px 14px;cursor:pointer;">BCA<img src="{{ asset('assets/img/bca.png') }}" width="40" height="25" style="object-fit:contain;"/></div>
                                <div onclick="selectBank2('Mandiri','4321 8765 4321','{{ asset('assets/img/mandiri.png') }}')" style="display:flex;justify-content:space-between;align-items:center;padding:10px 14px;cursor:pointer;">Mandiri<img src="{{ asset('assets/img/mandiri.png') }}" width="40" height="25" style="object-fit:contain;"/></div>
                                <div onclick="selectBank2('BRI','8765 4321 8765','{{ asset('assets/img/bri.png') }}')" style="display:flex;justify-content:space-between;align-items:center;padding:10px 14px;cursor:pointer;">BRI<img src="{{ asset('assets/img/bri.png') }}" width="40" height="25" style="object-fit:contain;"/></div>
                                <div onclick="selectBank2('BNI','1234 9999 0011','{{ asset('assets/img/bni.png') }}')" style="display:flex;justify-content:space-between;align-items:center;padding:10px 14px;cursor:pointer;">BNI<img src="{{ asset('assets/img/bni.png') }}" width="40" height="25" style="object-fit:contain;"/></div>
                                <div onclick="selectBank2('BSI','1234 9999 0011','{{ asset('assets/img/bsi.png') }}')" style="display:flex;justify-content:space-between;align-items:center;padding:10px 14px;cursor:pointer;">BSI<img src="{{ asset('assets/img/bsi.png') }}" width="40" height="25" style="object-fit:contain;"/></div>
                            </div>
                        </div>
                        <div class="bank-row" style="margin-bottom:12px;">
                            <label>No Rekening</label>
                            <div class="value"><span id="bankRekening">0978 5634 21196</span>
                                <button type="button" class="copy-btn" onclick="copyText(document.getElementById('bankRekening').textContent)">
                                    <svg width="20" height="20" viewBox="0 0 30 30" fill="none"><path d="M5.5 18.8333H4.16667C3.45942 18.8333 2.78115 18.5524 2.28105 18.0523C1.78095 17.5522 1.5 16.8739 1.5 16.1667V4.16667C1.5 3.45942 1.78095 2.78115 2.28105 2.28105C2.78115 1.78095 3.45942 1.5 4.16667 1.5H16.1667C16.8739 1.5 17.5522 1.78095 18.0523 2.28105C18.5524 2.78115 18.8333 3.45942 18.8333 4.16667V5.5M13.5 10.8333H25.5C26.9728 10.8333 28.1667 12.0272 28.1667 13.5V25.5C28.1667 26.9728 26.9728 28.1667 25.5 28.1667H13.5C12.0272 28.1667 10.8333 26.9728 10.8333 25.5V13.5C10.8333 12.0272 12.0272 10.8333 13.5 10.8333Z" stroke="#8A8A8A" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                            </div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                            <div class="bank-row" style="margin:0;"><label>A/n</label><div class="value">SEWAIN</div></div>
                            <div class="bank-row" style="margin:0;"><label>Nominal</label><div class="value" id="transferNominal">Rp 0</div></div>
                        </div>
                        <label class="checkbox-row"><input type="checkbox" /> Save This Info For Future</label>
                    </div>

                    <div class="payment-panel" id="panel-ewallet">
                        <div style="position:relative;margin-bottom:12px;">
                            <div onclick="toggleWalletDropdown()" style="display:flex;justify-content:space-between;align-items:center;border:1px solid #e0e0e0;padding:10px 14px;cursor:pointer;background:#fff;">
                                <span id="selectedWalletName" style="font-size:13px;font-weight:600;color:var(--dark);">GoPay</span>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <img id="selectedWalletLogo" src="{{ asset('assets/img/gopay.png') }}" width="40" height="25" style="object-fit:contain;" />
                                    <svg width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M5.53366 7.78781L0.193175 1.92106C-0.0643917 1.63811 -0.0643917 1.17938 0.193175 0.896463L0.816057 0.212204C1.07318 -0.0702607 1.48991 -0.0708043 1.74765 0.210996L6.00001 4.8605L10.2524 0.210996C10.5101 -0.0708043 10.9268 -0.0702607 11.1839 0.212204L11.8068 0.896463C12.0644 1.17941 12.0644 1.63814 11.8068 1.92106L6.46637 7.78781C6.2088 8.07073 5.79122 8.07073 5.53366 7.78781Z" fill="#484848"/></svg>
                                </div>
                            </div>
                            <div id="walletDropdown" style="display:none;position:absolute;top:100%;left:0;right:0;background:#fff;border:1px solid #e0e0e0;border-top:none;z-index:10;">
                                <div onclick="selectWallet2('GoPay','0858 4619 7216','{{ asset('assets/img/gopay.png') }}')" style="display:flex;justify-content:space-between;align-items:center;padding:10px 14px;cursor:pointer;">GoPay<img src="{{ asset('assets/img/gopay.png') }}" width="40" height="25" style="object-fit:contain;"/></div>
                                <div onclick="selectWallet2('OVO','0858 4619 7216','{{ asset('assets/img/ovo.png') }}')" style="display:flex;justify-content:space-between;align-items:center;padding:10px 14px;cursor:pointer;">OVO<img src="{{ asset('assets/img/ovo.png') }}" width="40" height="25" style="object-fit:contain;"/></div>
                                <div onclick="selectWallet2('ShopeePay','0858 4619 7216','{{ asset('assets/img/spay.png') }}')" style="display:flex;justify-content:space-between;align-items:center;padding:10px 14px;cursor:pointer;">ShopeePay<img src="{{ asset('assets/img/spay.png') }}" width="40" height="25" style="object-fit:contain;"/></div>
                                <div onclick="selectWallet2('Dana','0858 4619 7216','{{ asset('assets/img/dana.png') }}')" style="display:flex;justify-content:space-between;align-items:center;padding:10px 14px;cursor:pointer;">Dana<img src="{{ asset('assets/img/dana.png') }}" width="40" height="25" style="object-fit:contain;"/></div>
                            </div>
                        </div>
                        <div class="bank-row" style="margin-bottom:12px;">
                            <label>Nomor</label>
                            <div class="value"><span id="walletNomor">0812‑xxxx‑xxxx</span>
                                <button type="button" class="copy-btn" onclick="copyText(document.getElementById('walletNomor').textContent)">
                                    <svg width="20" height="20" viewBox="0 0 30 30" fill="none"><path d="M5.5 18.8333H4.16667C3.45942 18.8333 2.78115 18.5524 2.28105 18.0523C1.78095 17.5522 1.5 16.8739 1.5 16.1667V4.16667C1.5 3.45942 1.78095 2.78115 2.28105 2.28105C2.78115 1.78095 3.45942 1.5 4.16667 1.5H16.1667C16.8739 1.5 17.5522 1.78095 18.0523 2.28105C18.5524 2.78115 18.8333 3.45942 18.8333 4.16667V5.5M13.5 10.8333H25.5C26.9728 10.8333 28.1667 12.0272 28.1667 13.5V25.5C28.1667 26.9728 26.9728 28.1667 25.5 28.1667H13.5C12.0272 28.1667 10.8333 26.9728 10.8333 25.5V13.5C10.8333 12.0272 12.0272 10.8333 13.5 10.8333Z" stroke="#8A8A8A" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                            </div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                            <div class="bank-row" style="margin:0;"><label>A/n</label><div class="value">SEWAIN</div></div>
                            <div class="bank-row" style="margin:0;"><label>Nominal</label><div class="value" id="ewalletNominal">Rp 0</div></div>
                        </div>
                        <label class="checkbox-row"><input type="checkbox" /> Save This Info For Future</label>
                    </div>
                </div>
            </div>

            <div class="summary-side" id="summarySide">
                @foreach($cartItems as $item)
                    @php
                        $tanggalMulai = \Carbon\Carbon::parse($item->tanggal_sewa);
                        $tanggalSelesai = \Carbon\Carbon::parse($item->tanggal_kembali_rencana);                        
                        $durasi = $tanggalMulai->diffInDays($tanggalSelesai);
                        $durasi = $durasi < 1 ? 1 : $durasi;
                        $price = $item->barang->harga_sewa ?? 0;
                        $subtotal = $price * $item->jumlah * $durasi;
                        $jaminan = round($price * $item->jumlah / 2);
                        $shipping = 20000; // biaya kirim flat per item (harus sama dengan CheckoutController)
                        $rowTotal = $subtotal + $jaminan + $shipping;
                    @endphp
                    <input type="hidden" name="prices[]" value="{{ $price }}" />
                    <div class="summary-product">
                        <div class="summary-product-header">
                            <div class="item-badge">{{ $item->jumlah }}</div>
                            <div class="sum-img"><img src="{{ $item->barang->foto_barang ? asset('storage/'.$item->barang->foto_barang) : 'https://placehold.co/60x60?text=Foto' }}" alt="{{ $item->barang->nama_barang }}" /></div>
                            <div class="sum-product-info">
                                <div class="sum-product-name">{{ $item->barang->nama_barang }}</div>
                                <div class="sum-price">Rp {{ number_format($item->barang->harga_sewa,0,',','.') }}/hari</div>
                            </div>
                        </div>
                        <div class="sum-dates">
                            <div class="sum-date-item"><div class="sum-date-label">Tanggal Mulai Penyewaan</div><div class="sum-date-val"><span class="date-text">{{ $tanggalMulai->locale('id')->translatedFormat('d F Y') }}</span></div></div>
                            <div class="sum-date-item"><div class="sum-date-label">Tanggal Selesai Penyewaan</div><div class="sum-date-val"><span class="date-text">{{ $tanggalSelesai->locale('id')->translatedFormat('d F Y') }}</span></div></div>
                        </div>
                        <div class="sum-rows">
                            <div class="sum-row"><span class="lbl">Durasi Sewa</span><span class="val">{{ $durasi }} Hari</span></div>
                            <div class="sum-row"><span class="lbl">Subtotal</span><span class="val">Rp {{ number_format($subtotal,0,',','.') }}</span></div>
                            <div class="sum-row"><span class="lbl">Shipping</span><span class="val">Rp {{ number_format($shipping,0,',','.') }}</span></div>
                            <div class="sum-row"><span class="lbl">Jaminan</span><span class="val">Rp {{ number_format($jaminan,0,',','.') }}</span></div>
                            <div class="sum-row"><span class="lbl" style="font-weight:700;">Total</span><span class="val" style="font-weight:700;">Rp {{ number_format($rowTotal,0,',','.') }}</span></div>
                        </div>
                    </div>
                @endforeach

                <div class="summary-total"><span class="lbl">Total</span><span class="val">Rp {{ number_format($cartTotal,0,',','.') }}</span></div>
                <p class="summary-note">Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy.</p>
                <div class="action-group">
                    <input type="hidden" name="checkout_cart" id="checkout_cart" />
                    <input type="hidden" name="total_price" value="{{ $cartTotal }}" />
                    <button type="submit" class="btn-pay" style="border:none; cursor:pointer;">Pay Now</button>
                    <p class="copyright-note">© {{ date('Y') }} SEWAIN · All Rights Reserved · Secure Payment</p>
                </div>
            </div>
        </main>
    </form>

    <x-slot:scripts>
        <script>
            // Passing grand total value dari Blade ke JavaScript variabel
            const grandTotalValue = {{ $cartTotal }};

            // Helper untuk memformat angka integer ke format mata uang Rupiah
            function formatRupiah(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
            }

            // Fungsi untuk menginisialisasi nominal pembayaran di panel interaktif
            function initPaymentNominals() {
                const formattedTotal = formatRupiah(grandTotalValue);
                
                const qrisNominalEl = document.getElementById('qrisNominal');
                const transferNominalEl = document.getElementById('transferNominal');
                const ewalletNominalEl = document.getElementById('ewalletNominal');

                if (qrisNominalEl) qrisNominalEl.textContent = formattedTotal;
                if (transferNominalEl) transferNominalEl.textContent = formattedTotal;
                if (ewalletNominalEl) ewalletNominalEl.textContent = formattedTotal;
            }

            // Jalankan inisialisasi nominal begitu dokumen HTML selesai dimuat
            document.addEventListener('DOMContentLoaded', initPaymentNominals);

            // ==================== UI Helpers ====================
            const pmLogos = {
                credit: `<svg width="50" height="25" viewBox="0 0 50 25" style="border:1px solid #e0e0e0;border-radius:4px;"><rect width="50" height="25" rx="3" fill="#1A1F71" /><text x="8" y="17" font-family="Poppins" font-size="10" fill="white" font-weight="bold">VISA</text></svg>`,
                qris:   `<svg width="50" height="25" viewBox="0 0 50 25" style="border:1px solid #e0e0e0;border-radius:4px;"><image href="{{ asset('assets/img/logo qris.png') }}" width="50" height="25"/></svg>`,
                transfer: `<svg width="50" height="25" viewBox="0 0 50 25" style="border:1px solid #e0e0e0;border-radius:4px;"><image href="{{ asset('assets/img/logo bank tf.png') }}" width="50" height="25"/></svg>`,
                ewallet: `<svg width="50" height="25" viewBox="0 0 50 25" style="border:1px solid #e0e0e0;border-radius:4px;"><image href="{{ asset('assets/img/logo e-wallet.png') }}" width="50" height="25"/></svg>`
            };
            function toggleDropdown() {
                const dd = document.getElementById('pmDropdown');
                const chev = document.getElementById('pmChevron');
                const isOpen = dd.style.display === 'flex';
                dd.style.display = isOpen ? 'none' : 'flex';
                chev.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            }
    function selectPayment(type, label, sub, logoKey) {
    // 1. Ubah teks display pada komponen utama kartu
    document.getElementById('selectedLabel').textContent = label;
    document.getElementById('selectedSub').textContent = sub;
    document.getElementById('selectedLogoContainer').innerHTML = pmLogos[logoKey] || pmLogos[type] || '';
    
    // 2. SINKRONISASI KRUSIAL: Update nilai value pada input radio utama agar terbaca oleh Controller
    const mainRadio = document.getElementById('mainPaymentMethod');
    if (mainRadio) {
        mainRadio.value = type; 
        mainRadio.checked = true;
    }

    // 3. Tampilkan panel detail pembayaran yang sesuai
    document.querySelectorAll('.payment-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('panel-' + type).classList.add('active');
    
    // 4. Tutup kembali container dropdown
    document.getElementById('pmDropdown').style.display = 'none';
    document.getElementById('pmChevron').style.transform = 'rotate(0deg)';
}
    
            // Shipping toggle
            function selectShipping(mode, el) {
                document.querySelectorAll('.shipping-toggle .toggle-btn').forEach(b => b.classList.remove('active'));
                el.classList.add('active');
                document.getElementById('deliverySection').style.display = mode === 'delivery' ? 'block' : 'none';
                // Set hidden shipping_method value
                const shippingInput = document.getElementById('shipping_method');
                if (shippingInput) {
                    shippingInput.value = mode;
                }
            }
            // Bank dropdown
            function toggleBankDropdown() {
                const dd = document.getElementById('bankDropdown');
                const current = document.getElementById('selectedBankName').textContent.trim();
                dd.querySelectorAll('div[onclick]').forEach(item => {
                    item.style.display = item.textContent.trim().startsWith(current) ? 'none' : 'flex';
                });
                dd.style.display = dd.style.display === 'block' ? 'none' : 'block';
            }
            function selectBank2(name, rekening, logoSrc) {
                document.getElementById('selectedBankName').textContent = name;
                document.getElementById('selectedBankLogo').src = logoSrc;
                document.getElementById('bankRekening').textContent = rekening;
                document.getElementById('bankDropdown').style.display = 'none';
            }
            // Wallet dropdown
            function toggleWalletDropdown() {
                const dd = document.getElementById('walletDropdown');
                const current = document.getElementById('selectedWalletName').textContent.trim();
                dd.querySelectorAll('div[onclick]').forEach(item => {
                    item.style.display = item.textContent.trim().startsWith(current) ? 'none' : 'flex';
                });
                dd.style.display = dd.style.display === 'block' ? 'none' : 'block';
            }
            function selectWallet2(name, nomor, logoSrc) {
                document.getElementById('selectedWalletName').textContent = name;
                document.getElementById('selectedWalletLogo').src = logoSrc;
                document.getElementById('walletNomor').textContent = nomor;
                document.getElementById('walletDropdown').style.display = 'none';
            }
            // Copy helper
            function copyText(text) { navigator.clipboard.writeText(text).then(() => alert('Disalin: '+text)); }

            // ===== VALIDASI: tombol "Pay Now" nonaktif selama masih ada kolom yang belum diisi =====
            (function () {
                const form = document.getElementById('checkoutForm');
                const payBtn = document.querySelector('.btn-pay');
                if (!form || !payBtn) return;

                function isVisible(el) {
                    return !!(el.offsetWidth || el.offsetHeight || el.getClientRects().length);
                }

                function validatePayButton() {
                    const fields = form.querySelectorAll(
                        'input[type=text], input[type=email], input[type=tel], input[type=date], input[type=number], select, textarea'
                    );
                    let semuaTerisi = true;
                    fields.forEach(function (el) {
                        // abaikan kolom tersembunyi / readonly / disabled
                        if (el.disabled || el.readOnly || el.type === 'hidden' || !isVisible(el)) return;
                        if (!el.value || el.value.trim() === '') semuaTerisi = false;
                    });
                    payBtn.disabled = !semuaTerisi;
                    payBtn.style.opacity = semuaTerisi ? '1' : '0.5';
                    payBtn.style.cursor = semuaTerisi ? 'pointer' : 'not-allowed';
                }

                form.addEventListener('input', validatePayButton);
                form.addEventListener('change', validatePayButton);
                // re-cek saat ganti panel metode pembayaran/pengiriman
                form.addEventListener('click', function () { setTimeout(validatePayButton, 50); });
                validatePayButton(); // cek saat halaman dimuat
            })();
         </script>
    </x-slot:scripts>
</x-layout>