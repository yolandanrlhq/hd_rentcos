<main class="profile-section">
  <div class="profile-card">

    <!-- Kiri: Foto Profil -->
    <div class="profile-left">
      <div class="profile-img-wrapper">
        <img
          src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('assets/default-profile.jpg') }}"
          alt="Foto Profil"
          id="previewImg"
        >

        <!-- Ikon kamera, sekarang terhubung ke input file yang ada di form -->
        <label for="uploadProfile" class="upload-btn" title="Ubah Foto">
          <i class="ri-camera-fill"></i>
        </label>
      </div>

      <h2 class="profile-name">{{ $user->name }}</h2>
    </div>

    <!-- Kanan: Form Edit Profil -->
    <div class="profile-right">
      <div class="profile-header">
        <h3>Edit Profil</h3>
        <a href="{{ route('user.profile') }}" class="edit-btn">
          <i class="ri-arrow-left-line"></i> Kembali
        </a>
      </div>

      <form
        id="updateProfileForm"
        action="{{ route('user.updateProfile') }}"
        method="POST"
        enctype="multipart/form-data"
        class="profile-form"
      >
        @csrf
        @method('PUT')

        <!-- Input file pindah ke dalam form, tapi posisi visual tetap di kiri -->
        <input type="file" id="uploadProfile" name="foto" accept="image/*" style="display:none;">

        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
          <label>No. Telepon</label>
          <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="form-group">
          <label>Alamat</label>
          <textarea name="address">{{ old('address', $user->address) }}</textarea>
        </div>

        <div class="form-buttons">
          <button type="reset" class="cancel-btn">Batal</button>
          <button type="submit" class="save-btn">Simpan</button>
        </div>
      </form>
    </div>

  </div>
</main>

<script>
const uploadProfile = document.getElementById('uploadProfile');
const previewImg = document.getElementById('previewImg');

uploadProfile.addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>
