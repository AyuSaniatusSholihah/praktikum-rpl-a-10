<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEWAIN - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="navbar">
        <div class="logo">SEWA<span>IN</span></div>
        <nav class="nav-links">
            <a href="#">Home</a>
            <a href="#" class="active">Rentals</a>
            <a href="#">My Katalogs</a>
        </nav>
        <div class="nav-icons">
            <i class="fa-regular fa-user"></i>
            <i class="fa-regular fa-bell"></i>
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
    </header>

    <main class="dashboard-container">
        
        <aside class="sidebar">
            <div class="profile-selector">
                <div class="avatar-mini"></div>
                <div>
                    <h4>Camping Groups Bandung</h4>
                    <span class="dropdown-arrow">▼</span>
                </div>
            </div>
            
            <ul class="sidebar-menu">
                <li><a href="#"><i class="fa-solid fa-border-all"></i> Profile</a></li>
                <li class="active"><a href="#"><i class="fa-solid fa-retweet"></i> My Rentals</a></li>
                <li><a href="#"><i class="fa-solid fa-store"></i> Rentals Owner</a></li>
                <li><a href="#"><i class="fa-solid fa-wallet"></i> My Wallet</a></li>
                <hr class="sidebar-divider">
                <li><a href="#"><i class="fa-solid fa-gear"></i> Settings</a></li>
            </ul>

            <div class="sidebar-footer">
                <img src="https://via.placeholder.com/40" alt="Avatar" class="footer-avatar">
                <div>
                    <h5>Camping Groups Bandung</h5>
                    <p>Free Account</p>
                </div>
                <i class="fa-solid fa-right-from-bracket logout-icon"></i>
            </div>
        </aside>

        <section class="main-content">
            <div class="welcome-section">
                <h2>Hello, Camping Groups Bandung!</h2>
                <p>Here is your quick overview</p>
            </div>

            <div class="content-grid">
                <form class="profile-form">
                    <div class="form-group">
                        <label>Name Account User:</label>
                        <input type="text" value="Camping Groups Bandung">
                    </div>
                    
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" value="campinggroups.bandung1@gmail.com">
                    </div>

                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" value="************">
                    </div>

                    <div class="form-group">
                        <label>Nomor Telepon:</label>
                        <input type="text" value="0853-9017-6483">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir:</label>
                        <div class="select-wrapper">
                            <select>
                                <option>Bandung, 17 September 1995</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin:</label>
                        <input type="text" value="-">
                    </div>

                    <div class="form-group">
                        <label>Alamat:</label>
                        <textarea rows="4">Jl. Ir. H. Juanda No. 50 (Dago), Tamansari, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40116</textarea>
                    </div>
                </form>

                <div class="stats-panel">
                    <div class="profile-pic-large">
                        <img src="https://via.placeholder.com/80" alt="Profile Large">
                    </div>

                    <div class="saldo-card">
                        <div class="saldo-header">
                            <span class="badge">+2.3%</span>
                            <span class="saldo-title">Saldo</span>
                        </div>
                        <h3>Rp 1.872.000,00</h3>
                        <div class="currency-icon">$</div>
                    </div>

                    <div class="stat-box">
                        <label>Total DiSewa:</label>
                        <div class="stat-value">5 kali</div>
                    </div>

                    <div class="stat-box">
                        <label>Jumlah Katalog Barang:</label>
                        <div class="stat-value">7 Barang</div>
                    </div>

                    <button type="button" class="btn-save">SAVE</button>
                </div>
            </div>

            <div class="my-rentals-section">
                <h3>My Rentals</h3>
                <div class="rentals-preview-grid">
                    <div class="rental-card">
                        <span class="status-badge upcoming">UpComing Rent</span>
                        <div class="card-placeholder-img"></div>
                    </div>
                    <div class="rental-card">
                        <span class="status-badge active-rent">Active Rent</span>
                        <div class="card-placeholder-img"></div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="main-footer">
        <div class="footer-left">
            <div class="logo">SEWA<span>IN</span></div>
            <p>We help you find and rent what you need easily</p>
            <div class="social-icons">
                <a href="#"><i class="fa-solid fa-phone"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-solid fa-globe"></i></a>
                <a href="#"><i class="fa-regular fa-envelope"></i></a>
            </div>
        </div>
        <div class="footer-links-container">
            <div class="footer-column">
                <h4>Information</h4>
                <a href="#">About</a>
                <a href="#">Product</a>
                <a href="#">Blog</a>
            </div>
            <div class="footer-column">
                <h4>Company</h4>
                <a href="#">Community</a>
                <a href="#">Career</a>
                <a href="#">Our story</a>
            </div>
            <div class="footer-column">
                <h4>Contact</h4>
                <a href="#">Getting Started</a>
                <a href="#">Pricing</a>
                <a href="#">Resources</a>
            </div>
        </div>
    </footer>

</body>
</html>