<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $status
 * @property string|null $delivery_method Delivery method chosen by user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CartItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sewa> $sewas
 * @property-read int|null $sewas_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereDeliveryMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereUserId($value)
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $cart_id
 * @property int $id_produk
 * @property string|null $ukuran
 * @property int $jumlah
 * @property int $harga_satuan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_checked_out
 * @property-read \App\Models\Cart $cart
 * @property-read mixed $subtotal
 * @property-read \App\Models\Produk $produk
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereIdProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereIsCheckedOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereUkuran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem whereUpdatedAt($value)
 */
	class CartItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_event
 * @property string $nama_event
 * @property string $tempat_event
 * @property string $tgl_event
 * @property string $htm
 * @property string $kontak_panitia
 * @property string|null $gambar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereHtm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereIdEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereKontakPanitia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereNamaEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereTempatEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereTglEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereUpdatedAt($value)
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_kategori
 * @property string $nama_kategori
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Produk> $produk
 * @property-read int|null $produk_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereIdKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereNamaKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereUpdatedAt($value)
 */
	class Kategori extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $sewa_id
 * @property int $sender_id
 * @property int $receiver_id
 * @property string $message
 * @property bool $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $receiver
 * @property-read \App\Models\User $sender
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereSewaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereUpdatedAt($value)
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $judul
 * @property string $pesan
 * @property string|null $ikon
 * @property int $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIkon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification wherePesan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserId($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_produk
 * @property int $id_kategori
 * @property string $nama_produk
 * @property numeric $harga_produk
 * @property int $stok_produk
 * @property numeric $rating
 * @property string|null $deskripsi
 * @property string|null $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $jumlah_ulasan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProdukFoto> $fotos
 * @property-read int|null $fotos_count
 * @property-read mixed $total_stok
 * @property-read \App\Models\Kategori $kategori
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sewa> $sewa
 * @property-read int|null $sewa_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UkuranProduk> $ukuran
 * @property-read int|null $ukuran_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereHargaProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereIdKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereIdProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereJumlahUlasan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereNamaProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereStokProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereUpdatedAt($value)
 */
	class Produk extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $id_produk
 * @property string $foto_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Produk $produk
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProdukFoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProdukFoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProdukFoto query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProdukFoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProdukFoto whereFotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProdukFoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProdukFoto whereIdProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProdukFoto whereUpdatedAt($value)
 */
	class ProdukFoto extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int|null $cart_id
 * @property string $status
 * @property int $total_harga
 * @property string|null $tanggal_sewa
 * @property string|null $tanggal_kembali
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cart|null $cart
 * @property-read mixed $kode_pesanan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SewaItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sewa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sewa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sewa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sewa whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sewa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sewa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sewa whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sewa whereTanggalKembali($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sewa whereTanggalSewa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sewa whereTotalHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sewa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sewa whereUserId($value)
 */
	class Sewa extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $sewa_id
 * @property int $produk_id
 * @property string $ukuran
 * @property int $jumlah
 * @property int $harga_satuan
 * @property int $subtotal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Produk $produk
 * @property-read \App\Models\Sewa $sewa
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SewaItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SewaItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SewaItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SewaItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SewaItem whereHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SewaItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SewaItem whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SewaItem whereProdukId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SewaItem whereSewaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SewaItem whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SewaItem whereUkuran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SewaItem whereUpdatedAt($value)
 */
	class SewaItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $id_produk
 * @property string $nama_ukuran
 * @property int $stok
 * @property int $is_rented Indicates if the size is currently rented
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Produk $produk
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UkuranProduk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UkuranProduk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UkuranProduk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UkuranProduk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UkuranProduk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UkuranProduk whereIdProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UkuranProduk whereIsRented($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UkuranProduk whereNamaUkuran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UkuranProduk whereStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UkuranProduk whereUpdatedAt($value)
 */
	class UkuranProduk extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $foto
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

