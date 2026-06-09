package com.l0124005.sewain_rpl.network

import retrofit2.Response
import retrofit2.http.*

interface ApiService {

    // ═══════════════════════════════════════
    // AUTHENTIKASI
    // ═══════════════════════════════════════

    @POST("register")
    suspend fun register(
        @Body request: RegisterRequest
    ): Response<RegisterResponse>

    @POST("login")
    suspend fun login(
        @Body request: LoginRequest
    ): Response<LoginResponse>

    @POST("logout")
    suspend fun logout(
        @Header("Authorization") token: String
    ): Response<LogoutResponse>


    // ═══════════════════════════════════════
    // PRODUK / KATALOG
    // ═══════════════════════════════════════

    // Ditambahkan parameter query untuk search / filter produk (UC5)
    @GET("katalog-publik")
    suspend fun getKatalogPublik(
        @Query("search") search: String? = null,
        @Query("kategori") kategori: String? = null
    ): Response<KatalogListResponse>


    // ═══════════════════════════════════════
    // KERANJANG (Add to Cart / Rent Now)
    // ═══════════════════════════════════════

    @GET("keranjang")
    suspend fun getKeranjang(
        @Header("Authorization") token: String
    ): Response<KeranjangResponse>

    @POST("keranjang/items")
    suspend fun addToKeranjang(
        @Header("Authorization") token: String,
        @Body request: AddToKeranjangRequest
    ): Response<KeranjangResponse>

    @DELETE("keranjang/items/{id}")
    suspend fun removeKeranjangItem(
        @Header("Authorization") token: String,
        @Path("id") id: Int
    ): Response<KeranjangResponse>


    // ═══════════════════════════════════════
    // TRANSAKSI & PEMBAYARAN
    // ═══════════════════════════════════════

    @POST("checkout")
    suspend fun checkout(
        @Header("Authorization") token: String
    ): Response<CheckoutResponse>

    @POST("transaksi/bayar")
    suspend fun bayar(
        @Header("Authorization") token: String,
        @Body request: BayarRequest
    ): Response<BayarResponse>


    // ═══════════════════════════════════════
    // PROFIL
    // ═══════════════════════════════════════

    @GET("profile")
    suspend fun getProfile(
        @Header("Authorization") token: String
    ): Response<ProfileResponse>

    @POST("profile")
    suspend fun updateProfile(
        @Header("Authorization") token: String,
        @Body request: UpdateProfileRequest
    ): Response<ProfileResponse>
}

// ════════════════════════════════════════════════════════════
// DATA CLASSES (DTO)
// ════════════════════════════════════════════════════════════

// Auth DTOs
data class RegisterRequest(
    val first_name: String, 
    val last_name: String, 
    val email: String, 
    val phone: String?, 
    val password: String, 
    val password_confirmation: String
)
data class RegisterResponse(val success: Boolean, val message: String, val email: String?)

data class LoginRequest(val email: String, val password: String)
data class LoginResponse(
    val success: Boolean, 
    val message: String, 
    val access_token: String?, 
    val token_type: String?, 
    val user: UserData?
)
data class LogoutResponse(val success: Boolean, val message: String)

// User / Profile DTOs
data class UserData(
    val id: Int, 
    val name: String, 
    val email: String, 
    val phone_number: String?, 
    val email_verified_at: String?
)
data class ProfileResponse(val success: Boolean, val message: String?, val user: UserData)
data class UpdateProfileRequest(val name: String?, val nomor_telepon: String?, val alamat: String?)

// Produk / Katalog DTOs
data class CatalogData(
    val id: Int, 
    val nama_barang: String, 
    val deskripsi: String?, 
    val harga_sewa: Double, 
    val harga_jaminan: Double,
    val harga_denda_perjam: Double,
    val stok: Int,
    val lokasi: String,
    val foto_barang: String?,
    val status: String
)
data class KatalogListResponse(val status: String, val data: List<CatalogData>)

// Keranjang DTOs
data class AddToKeranjangRequest(val barang_id: Int, val tanggal_mulai: String, val tanggal_selesai: String, val jumlah: Int)
data class KeranjangResponse(val status: String, val message: String?, val data: KeranjangData?)
data class KeranjangData(val id: Int, val user_id: Int, val items: List<KeranjangItem>)
data class KeranjangItem(
    val id: Int, 
    val barang_id: Int, 
    val barang: CatalogData, 
    val tanggal_mulai: String, 
    val tanggal_selesai: String, 
    val jumlah: Int, 
    val total_harga: Double
)

// Transaksi DTOs
data class TransaksiData(
    val id: Int, 
    val user_id: Int, 
    val barang_id: Int, 
    val status: String, 
    val tanggal_sewa: String, 
    val tanggal_kembali: String?, 
    val total_harga: Double
)
data class CheckoutResponse(val status: String, val message: String, val transactions: List<TransaksiData>)
data class BayarRequest(val transaksi_ids: List<Int>, val jumlah_bayar: Double, val metode_pembayaran: String)
data class BayarResponse(val status: String, val message: String)