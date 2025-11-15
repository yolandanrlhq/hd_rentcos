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
      </div>

      <h2 class="profile-name">{{ $user->name }}</h2>
      <p class="profile-location">{{ $user->address ?? 'Belum ada alamat' }}</p>
    </div>

    <!-- Kanan: Detail Profil -->
    <div class="profile-right">
      <div class="profile-header">
        <h3>Informasi Akun</h3>
        <a href="{{ route('user.editProfile') }}" class="edit-btn">
          <i class="ri-edit-line"></i> Edit
        </a>
      </div>

      <div class="profile-details">
        <p><span>Email :</span> {{ $user->email }}</p>
        <p><span>No. Telepon :</span> {{ $user->phone ?? '-' }}</p>
        <p><span>Alamat :</span> {{ $user->address ?? '-' }}</p>
        <p><span>Bergabung Sejak :</span> {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('F Y') }}</p>
      </div>
    </div>
  </div>
</main>
