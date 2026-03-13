<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — VaxTrack</title>

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
/* ══ TOKENS ══════════════════════════════════════ */
:root,
[data-theme="light"] {
  --bg:       #d2dccd;
  --bg-grad:  linear-gradient(150deg, #c8d5c3 0%, #d8e3d3 55%, #c5d2c0 100%);
  --surface:  rgba(255,255,255,.72);
  --surface2: rgba(255,255,255,.50);
  --border:   rgba(255,255,255,.70);
  --border2:  rgba(202,210,197,.45);
  --text:     #2f3e46;
  --text2:    #52796f;
  --text3:    #84a98c;
  --forest:   #52796f;
  --forest-dark: #354f52;
  --deep:     #2f3e46;
  --sage-mid: #84a98c;
  --sb-glass: rgba(26,40,48,.84);
  --blur:     blur(24px);
  --blur-lg:  blur(40px);
  --shadow:   0 8px 32px rgba(47,62,70,.12), 0 2px 8px rgba(47,62,70,.08);
  --shadow-lg:0 24px 80px rgba(47,62,70,.22), 0 8px 24px rgba(47,62,70,.12);
  --red:      #bf4040;
  --red-light:rgba(191,64,64,.10);
}
[data-theme="dark"] {
  --bg:       #0f1720;
  --bg-grad:  linear-gradient(150deg, #0c1218 0%, #141f28 55%, #0f1720 100%);
  --surface:  rgba(26,38,48,.78);
  --surface2: rgba(32,46,56,.64);
  --border:   rgba(202,210,197,.11);
  --border2:  rgba(202,210,197,.16);
  --text:     #dce8e2;
  --text2:    #84a98c;
  --text3:    #5e8a7a;
  --forest:   #84a98c;
  --forest-dark: #cad2c5;
  --deep:     #cad2c5;
  --sage-mid: #84a98c;
  --sb-glass: rgba(6,12,18,.90);
  --shadow:   0 8px 32px rgba(0,0,0,.32), 0 2px 8px rgba(0,0,0,.22);
  --shadow-lg:0 24px 80px rgba(0,0,0,.56), 0 8px 24px rgba(0,0,0,.30);
  --red-light:rgba(191,64,64,.18);
}

/* ══ RESET ════════════════════════════════════════ */
*,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }

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

/* ══ THEME-SPECIFIC BODY ════════════════════════ */
[data-theme="light"] body {
  background-color: #d2dccd !important;
}
[data-theme="dark"] body {
  background-color: #0f1720 !important;
}

/* ══ AMBIENT ORBS ════════════════════════════════ */
body::before, body::after {
  content: '';
  position: fixed;
  border-radius: 50%;
  pointer-events: none;
  z-index: 0;
  display: none;
}
body::before {
  width: 740px; height: 740px;
  top: -220px; right: 1%;
  background: radial-gradient(circle, rgba(132,169,140,.22) 0%, transparent 70%);
}
body::after {
  width: 580px; height: 580px;
  bottom: -130px; left: 14%;
  background: radial-gradient(circle, rgba(82,121,111,.16) 0%, transparent 70%);
}
[data-theme="dark"] body::before {
  background: radial-gradient(circle, rgba(82,121,111,.13) 0%, transparent 70%);
}
[data-theme="dark"] body::after {
  background: radial-gradient(circle, rgba(47,62,70,.28) 0%, transparent 70%);
}

/* ══ CARD ═════════════════════════════════════════ */
.login-card {
  position: relative;
  z-index: 1;
  width: 440px;
  background: var(--surface);
  backdrop-filter: var(--blur-lg);
  -webkit-backdrop-filter: var(--blur-lg);
  border-radius: 28px;
  border: 1px solid var(--border);
  padding: 44px 40px 40px;
  box-shadow: var(--shadow-lg);
  /* glass sheen */
}
.login-card::before {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 28px;
  background: linear-gradient(160deg, rgba(255,255,255,.18) 0%, rgba(255,255,255,.04) 50%, transparent 100%);
  pointer-events: none;
}

/* ══ LOGO ═════════════════════════════════════════ */
.login-logo {
  display: flex;
  align-items: center;
  gap: 13px;
  margin-bottom: 10px;
}
.logo-icon {
  width: 54px; height: 54px;
  background: linear-gradient(145deg, rgba(82,121,111,.82) 0%, rgba(47,62,70,.94) 100%);
  border-radius: 18px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  color: white;
  position: relative;
  overflow: hidden;
  box-shadow: 0 6px 20px rgba(82,121,111,.45), 0 1px 0 rgba(255,255,255,.18) inset;
}
.logo-icon::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 50%;
  background: linear-gradient(180deg, rgba(255,255,255,.18) 0%, transparent 100%);
  border-radius: 18px 18px 0 0;
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

/* ══ DIVIDER ══════════════════════════════════════ */
.login-divider {
  height: 1px;
  background: var(--border2);
  margin: 22px 0 26px;
}

/* ══ TABS ═════════════════════════════════════════ */
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
.tab svg { flex-shrink: 0; transition: color .22s; }
.tab.active {
  background: var(--surface);
  color: var(--forest-dark);
  box-shadow: 0 2px 8px rgba(47,62,70,.12), 0 1px 0 rgba(255,255,255,.5) inset;
  border: 1px solid var(--border);
}

/* ══ FORM ═════════════════════════════════════════ */
.form-group { margin-bottom: 15px; }
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
.form-control::placeholder { color: var(--text3); }
.form-control:focus {
  border-color: var(--forest);
  box-shadow: 0 0 0 3px rgba(82,121,111,.15);
  background: var(--surface);
}

/* ══ BUTTON ═══════════════════════════════════════ */
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
  margin-top: 10px;
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
.btn-login:active { transform: translateY(0); }

/* ══ ALERT ════════════════════════════════════════ */
.alert {
  display: flex;
  align-items: flex-start;
  gap: 9px;
  padding: 11px 14px;
  background: var(--red-light);
  color: var(--red);
  border-radius: 10px;
  font-size: 13px;
  margin-bottom: 16px;
  border: 1px solid rgba(191,64,64,.22);
}

/* ══ HINT ═════════════════════════════════════════ */
.hint {
  text-align: center;
  margin-top: 18px;
  font-size: 12px;
  color: var(--text3);
  line-height: 1.7;
}
.hint strong { color: var(--text2); font-weight: 600; }

/* ══ DARK MODE TOGGLE ════════════════════════════ */
.dm-toggle {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 10;
  width: 42px; height: 42px;
  border-radius: 50%;
  background: var(--surface);
  backdrop-filter: var(--blur);
  -webkit-backdrop-filter: var(--blur);
  border: 1px solid var(--border);
  box-shadow: var(--shadow);
  display: flex; align-items: center; justify-content: center;
  cursor: pointer;
  color: var(--text2);
  transition: all .2s;
}
.dm-toggle:hover { transform: scale(1.08); }
</style>
</head>

<body>

{{-- Dark mode toggle --}}
<button class="dm-toggle" onclick="toggleDarkMode()" title="Toggle dark mode" id="dmBtn">
  <svg id="dmIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
  </svg>
</button>

<div class="login-card">

  {{-- Logo --}}
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

  {{-- Error --}}
  @if($errors->has('login'))
    <div class="alert">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ $errors->first('login') }}
    </div>
  @endif

  {{-- Role tabs --}}
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

  {{-- Form --}}
  <form action="{{ route('login.post') }}" method="POST">
    @csrf
    <input type="hidden" name="role" id="role-input" value="doctor">

    <div class="form-group">
      <label>Username</label>
      <div class="input-wrap">
        <span class="input-icon">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </span>
        <input type="text" name="username" class="form-control" placeholder="Enter your username" value="{{ old('username') }}" required autocomplete="username">
      </div>
    </div>

    <div class="form-group">
      <label>Password</label>
      <div class="input-wrap">
        <span class="input-icon">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </span>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
      </div>
      <div style="font-size: 12px; margin-top: 8px; text-align: right;">
        <a href="{{ route('auth.forgot-password') }}" style="color: var(--text3); text-decoration: none; transition: color .2s;" onmouseover="this.style.color='var(--forest)'" onmouseout="this.style.color='var(--text3)'">Forgot password?</a>
      </div>
    </div>

    <button type="submit" class="btn-login">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Sign In to VaxTrack
    </button>
  </form>

</div>

<script>
// ── Role tab switching ──────────────────────────
function setRole(role) {
  document.getElementById('role-input').value = role;
  document.getElementById('tab-doctor').classList.toggle('active', role === 'doctor');
  document.getElementById('tab-parent').classList.toggle('active', role === 'parent');
}

// ── Dark mode (mirrors app_blade logic) ─────────
function makeSvg(path, size) {
  return `<svg width="${size}" height="${size}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">${path}</svg>`;
}
function applyTheme(theme) {
  document.documentElement.setAttribute('data-theme', theme);
  localStorage.setItem('vaxtrack-theme', theme);
  const moonPath = '<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>';
  const sunPath  = '<circle cx="12" cy="12" r="4"/><line x1="12" y1="2" x2="12" y2="4"/><line x1="12" y1="20" x2="12" y2="22"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="2" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="22" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>';
  document.getElementById('dmIcon').innerHTML = theme === 'dark' ? sunPath : moonPath;
}
function toggleDarkMode() {
  const cur = document.documentElement.getAttribute('data-theme') || 'light';
  applyTheme(cur === 'dark' ? 'light' : 'dark');
}
// Apply correct icon on load
(function(){
  const t = localStorage.getItem('vaxtrack-theme') || 'light';
  const sunPath = '<circle cx="12" cy="12" r="4"/><line x1="12" y1="2" x2="12" y2="4"/><line x1="12" y1="20" x2="12" y2="22"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="2" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="22" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>';
  if (t === 'dark') document.getElementById('dmIcon').innerHTML = sunPath;
})();
</script>
</body>
</html>