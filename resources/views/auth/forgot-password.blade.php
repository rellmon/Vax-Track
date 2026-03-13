<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password — VaxTrack</title>

{{-- Anti-flicker: stamp theme before first paint --}}
<script>
(function(){
  var t = localStorage.getItem('vaxtrack-theme') || 'light';
  var d = document.documentElement;
  d.setAttribute('data-theme', t);
  d.style.background = t === 'dark' ? '#0f1720' : '#d2dccd';
  d.style.colorScheme = t === 'dark' ? 'dark' : 'light';
})();
</script>

<link href="https://api.fontshare.com/v2/css?f[]=object-sans@300,400,500,700&f[]=instrument-serif@400,400i&display=swap" rel="stylesheet">

<style>
:root, [data-theme="light"] {
  --bg: #d2dccd;
  --surface: rgba(255,255,255,.72);
  --surface2: rgba(255,255,255,.50);
  --border: rgba(255,255,255,.70);
  --border2: rgba(202,210,197,.45);
  --text: #2f3e46;
  --text2: #52796f;
  --text3: #84a98c;
  --forest: #52796f;
  --forest-dark: #354f52;
  --red: #bf4040;
  --red-light: rgba(191,64,64,.10);
  --blur: blur(24px);
  --shadow: 0 8px 32px rgba(47,62,70,.12), 0 2px 8px rgba(47,62,70,.08);
}
[data-theme="dark"] {
  --bg: #0f1720;
  --surface: rgba(26,38,48,.78);
  --surface2: rgba(32,46,56,.64);
  --border: rgba(202,210,197,.11);
  --border2: rgba(202,210,197,.16);
  --text: #dce8e2;
  --text2: #84a98c;
  --text3: #5e8a7a;
  --forest: #84a98c;
  --forest-dark: #cad2c5;
  --red-light: rgba(191,64,64,.18);
  --blur: blur(24px);
  --shadow: 0 8px 32px rgba(0,0,0,.32), 0 2px 8px rgba(0,0,0,.22);
}

* { box-sizing: border-box; margin: 0; padding: 0; }

html, body {
  min-height: 100vh;
  font-family: 'Object Sans', sans-serif;
  background: var(--bg);
  color: var(--text);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

.dm-toggle {
  position: fixed;
  top: 20px;
  right: 20px;
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: var(--surface);
  border: 1px solid var(--border2);
  color: var(--text2);
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all .22s ease;
  z-index: 100;
}
.dm-toggle:hover {
  background: var(--surface2);
}

.login-card {
  position: relative;
  z-index: 1;
  background: var(--surface);
  backdrop-filter: var(--blur);
  -webkit-backdrop-filter: var(--blur);
  border: 1px solid var(--border);
  border-radius: 28px;
  padding: 40px 32px;
  width: 100%;
  max-width: 380px;
  box-shadow: var(--shadow);
}

@media (max-width: 480px) {
  .login-card {
    margin: 20px;
    padding: 32px 20px;
    border-radius: 24px;
    max-width: calc(100% - 40px);
  }
}

.login-logo {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 16px;
}

.logo-icon {
  width: 48px;
  height: 48px;
  border-radius: 14px;
  background: linear-gradient(135deg, #52796f 0%, #354f52 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  color: white;
}

.logo-name {
  font-family: 'Instrument Serif', serif;
  font-size: 27px;
  color: var(--forest-dark);
  line-height: 1.1;
}

.logo-sub {
  font-size: 11px;
  color: var(--text3);
  letter-spacing: .07em;
  text-transform: uppercase;
  margin-top: 2px;
}

.login-divider {
  height: 1px;
  background: var(--border2);
  margin: 22px 0 26px;
}

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: var(--text2);
  font-size: 13px;
  font-weight: 500;
  text-decoration: none;
  margin-bottom: 20px;
  transition: color .2s ease;
}

.back-link:hover {
  color: var(--forest);
}

.back-link svg {
  width: 14px;
  height: 14px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  font-size: 11.5px;
  font-weight: 600;
  color: var(--text2);
  margin-bottom: 7px;
  letter-spacing: .06em;
  text-transform: uppercase;
}

.input-wrap {
  position: relative;
}

.input-icon {
  position: absolute;
  left: 13px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--text3);
  pointer-events: none;
  display: flex;
}

.form-control {
  width: 100%;
  padding: 11px 14px 11px 40px;
  border: 1.5px solid var(--border2);
  border-radius: 12px;
  font-size: 14px;
  color: var(--text);
  background: var(--surface2);
  backdrop-filter: var(--blur);
  -webkit-backdrop-filter: var(--blur);
  transition: border-color .2s, box-shadow .2s;
  font-family: 'Object Sans', sans-serif;
  outline: none;
}

.form-control::placeholder {
  color: var(--text3);
}

.form-control:focus {
  border-color: var(--forest);
  box-shadow: 0 0 0 3px rgba(82,121,111,.15);
  background: var(--surface);
}

.btn-login {
  width: 100%;
  padding: 13px;
  background: linear-gradient(145deg, #52796f 0%, #354f52 100%);
  color: white;
  border-radius: 14px;
  font-size: 15px;
  font-weight: 600;
  letter-spacing: .02em;
  transition: all .22s ease;
  margin-top: 20px;
  border: none;
  cursor: pointer;
  font-family: 'Object Sans', sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  box-shadow: 0 4px 16px rgba(53,79,82,.35), 0 1px 0 rgba(255,255,255,.14) inset;
  position: relative;
  overflow: hidden;
}

.btn-login::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 50%;
  background: linear-gradient(180deg, rgba(255,255,255,.12) 0%, transparent 100%);
  border-radius: 14px 14px 0 0;
}

.btn-login:hover {
  transform: translateY(-1px);
  box-shadow: 0 8px 24px rgba(53,79,82,.42), 0 1px 0 rgba(255,255,255,.14) inset;
}

.btn-login:active {
  transform: translateY(0);
}

.alert {
  background: var(--red-light);
  border: 1px solid var(--red);
  color: var(--red);
  padding: 12px 14px;
  border-radius: 10px;
  font-size: 13px;
  display: flex;
  gap: 8px;
  align-items: flex-start;
  margin-bottom: 16px;
}

.alert svg {
  flex-shrink: 0;
  margin-top: 1px;
}

.form-hint {
  font-size: 13px;
  color: var(--text3);
  margin-top: 8px;
}

.tabs {
  display: flex;
  gap: 5px;
  background: var(--surface2);
  backdrop-filter: var(--blur);
  -webkit-backdrop-filter: var(--blur);
  padding: 5px;
  border-radius: 16px;
  border: 1px solid var(--border);
  margin-bottom: 26px;
}

.tab {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
  padding: 9px 10px;
  border-radius: 11px;
  background: transparent;
  color: var(--text3);
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  border: none;
  transition: all .22s ease;
  font-family: 'Object Sans', sans-serif;
  outline: none;
}

.tab.active {
  background: var(--surface);
  color: var(--forest-dark);
  box-shadow: 0 2px 8px rgba(47,62,70,.12), 0 1px 0 rgba(255,255,255,.5) inset;
  border: 1px solid var(--border);
}
</style>

</head>
<body>

<button class="dm-toggle" onclick="toggleDarkMode()" title="Toggle dark mode" id="dmBtn">
  <svg id="dmIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
  </svg>
</button>

<div class="login-card">

  <div class="login-logo">
    <div class="logo-icon">
      <svg width="30" height="30" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
        <path d="M24 40 C24 40 6 28 6 16.5 A8.5 8.5 0 0 1 20 10.2 L24 14 L28 10.2 A8.5 8.5 0 0 1 42 16.5 C42 28 24 40 24 40Z"
              stroke="white" stroke-width="2.2" fill="rgba(255,255,255,0.15)"/>
        <rect x="28" y="10" width="13" height="4.5" rx="2" fill="rgba(255,255,255,0.9)" stroke="none"/>
        <rect x="32.25" y="5.75" width="4.5" height="13" rx="2" fill="rgba(255,255,255,0.9)" stroke="none"/>
        <rect x="19.5" y="20" width="9" height="13" rx="2.5" fill="rgba(255,255,255,0.88)" stroke="none"/>
        <rect x="20.5" y="17" width="7" height="4" rx="1.5" fill="rgba(255,255,255,0.65)" stroke="none"/>
        <line x1="19.5" y1="27.5" x2="28.5" y2="27.5" stroke="rgba(82,121,111,0.55)" stroke-width="1.4"/>
        <line x1="22" y1="29.5" x2="26" y2="24.5" stroke="rgba(47,62,70,0.55)" stroke-width="1.2" stroke-linecap="round"/>
      </svg>
    </div>
    <div>
      <div class="logo-name">VaxTrack</div>
      <div class="logo-sub">Pediatric Wellness</div>
    </div>
  </div>

  <div class="login-divider"></div>

  <a href="{{ route('login') }}" class="back-link">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
    </svg>
    Back to Login
  </a>

  @if($errors->any())
    <div class="alert">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ $errors->first() }}
    </div>
  @endif

  <div class="tabs">
    <button type="button" class="tab active" id="tab-doctor" onclick="setRole('doctor')">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      Doctor / Staff
    </button>
    <button type="button" class="tab" id="tab-parent" onclick="setRole('parent')">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      Parent
    </button>
  </div>

  <form action="{{ route('auth.send-otp') }}" method="POST">
    @csrf
    <input type="hidden" name="role" id="role-input" value="doctor">

    <div class="form-group">
      <label>Email Address</label>
      <div class="input-wrap">
        <span class="input-icon">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
        </span>
        <input type="email" name="email" class="form-control" placeholder="your@email.com" value="{{ old('email') }}" required autocomplete="email">
      </div>
      <div class="form-hint">Enter your registered email address</div>
    </div>

    <button type="submit" class="btn-login">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      Send OTP Code
    </button>
  </form>

</div>

<script>
function setRole(role) {
  document.getElementById('role-input').value = role;
  document.getElementById('tab-doctor').classList.toggle('active', role === 'doctor');
  document.getElementById('tab-parent').classList.toggle('active', role === 'parent');
}

function toggleDarkMode() {
  const cur = document.documentElement.getAttribute('data-theme') || 'light';
  applyTheme(cur === 'dark' ? 'light' : 'dark');
}

function applyTheme(theme) {
  document.documentElement.setAttribute('data-theme', theme);
  localStorage.setItem('vaxtrack-theme', theme);
  const sunPath = '<circle cx="12" cy="12" r="4"/><line x1="12" y1="2" x2="12" y2="4"/><line x1="12" y1="20" x2="12" y2="22"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="2" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="22" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>';
  const moonPath = '<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>';
  document.getElementById('dmIcon').innerHTML = theme === 'dark' ? sunPath : moonPath;
}

(function(){
  const t = localStorage.getItem('vaxtrack-theme') || 'light';
  const sunPath = '<circle cx="12" cy="12" r="4"/><line x1="12" y1="2" x2="12" y2="4"/><line x1="12" y1="20" x2="12" y2="22"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="2" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="22" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>';
  if (t === 'dark') document.getElementById('dmIcon').innerHTML = sunPath;
})();
</script>
</body>
</html>
