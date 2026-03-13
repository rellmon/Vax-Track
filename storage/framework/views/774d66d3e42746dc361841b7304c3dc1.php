<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo $__env->yieldContent('title', 'VaxTrack'); ?> — VaxTrack</title>

<script>
(function(){
  var t = localStorage.getItem('vaxtrack-theme') || 'light';
  var d = document.documentElement;
  d.setAttribute('data-theme', t);
  /* Stamp the correct background directly on <html> so the very first
     pixel the browser paints is already the right colour.
     These match --bg in the CSS token blocks below. */
  d.style.background = t === 'dark' ? '#0f1720' : '#d2dccd';
  d.style.colorScheme = t === 'dark' ? 'dark' : 'light';
})();
</script>
<link href="https://api.fontshare.com/v2/css?f[]=object-sans@300,400,500,700&f[]=instrument-serif@400,400i&display=swap" rel="stylesheet">
<style>
/* ══ TOKENS ══════════════════════════════════════ */
:root,
[data-theme="light"] {
  --sage-light:  #cad2c5;
  --sage-mid:    #84a98c;
  --forest:      #52796f;
  --forest-dark: #354f52;
  --deep:        #2f3e46;

  --bg:            #c8d6c2;
  --bg-grad:       linear-gradient(150deg, #b8ccb2 0%, #ccdcc6 40%, #c0d4ba 70%, #b4c8ae 100%);

  /* iOS Frosted Glass — light mode: warm white tint */
  --surface:       rgba(255,255,255,.58);
  --surface2:      rgba(255,255,255,.42);
  --surface3:      rgba(255,255,255,.28);
  --border:        rgba(255,255,255,.75);
  --border2:       rgba(202,210,197,.55);
  --border-solid:  #ccd5c8;

  /* Glass specular highlight (top-edge sheen like iOS) */
  --glass-sheen:   rgba(255,255,255,.80);
  --glass-sheen2:  rgba(255,255,255,.40);

  --text:  #2f3e46;
  --text2: #52796f;
  --text3: #84a98c;

  /* Sidebar — deep tinted glass */
  --sb-w:      300px;
  --sb-glass:  rgba(20,34,42,.82);
  --sb-tint:   rgba(30,52,50,.15);
  --sb-icon:   rgba(202,210,197,.55);
  --sb-hover:  rgba(202,210,197,.12);
  --sb-active: rgba(82,121,111,.80);
  --sb-border: rgba(255,255,255,.10);
  --sb-divider:rgba(202,210,197,.14);
  --sb-label:  rgba(202,210,197,.50);

  --red:         #bf4040;
  --red-light:   rgba(191,64,64,.11);
  --green-light: rgba(82,121,111,.10);
  --amber:       #a07030;
  --amber-light: rgba(160,112,48,.11);
  --blue:        #3d6b72;
  --blue-light:  rgba(61,107,114,.11);

  --radius:    22px;
  --radius-sm: 14px;
  --radius-xs: 10px;

  --shadow:       0 2px 8px rgba(47,62,70,.05),  0 8px 32px rgba(47,62,70,.07);
  --shadow-lg:    0 20px 70px rgba(47,62,70,.22);
  --shadow-sb:    0 28px 72px rgba(10,18,24,.40), 0 4px 20px rgba(10,18,24,.22),
                  inset 0 1px 0 rgba(255,255,255,.10);
  --glass-shadow: 0 8px 32px rgba(47,62,70,.12),  0 2px 8px rgba(47,62,70,.06),
                  inset 0 1px 0 rgba(255,255,255,.80);

  --blur:    blur(28px) saturate(180%);
  --blur-sm: blur(16px) saturate(160%);
  --blur-lg: blur(48px) saturate(200%);
  --blur-xl: blur(64px) saturate(220%);
}

[data-theme="dark"] {
  --bg:            #0d161f;
  --bg-grad:       linear-gradient(150deg, #0a1018 0%, #111c28 40%, #0d1820 70%, #0a1418 100%);

  /* iOS Frosted Glass — dark mode: deep tinted */
  --surface:       rgba(30,44,56,.72);
  --surface2:      rgba(24,36,46,.65);
  --surface3:      rgba(20,30,40,.55);
  --border:        rgba(255,255,255,.08);
  --border2:       rgba(202,210,197,.15);
  --border-solid:  #2a3c46;

  --glass-sheen:   rgba(255,255,255,.12);
  --glass-sheen2:  rgba(255,255,255,.06);

  --text:  #dce8e2;
  --text2: #84a98c;
  --text3: #5e8a7a;

  --sb-glass:  rgba(4,10,16,.88);
  --sb-tint:   rgba(20,40,36,.20);
  --sb-icon:   rgba(202,210,197,.45);
  --sb-hover:  rgba(202,210,197,.08);
  --sb-active: rgba(82,121,111,.65);
  --sb-border: rgba(255,255,255,.07);
  --sb-divider:rgba(202,210,197,.08);
  --sb-label:  rgba(202,210,197,.38);

  --red-light:   rgba(191,64,64,.18);
  --green-light: rgba(82,121,111,.18);
  --amber-light: rgba(160,112,48,.18);
  --blue-light:  rgba(61,107,114,.18);

  --shadow:       0 2px 8px rgba(0,0,0,.30), 0 8px 32px rgba(0,0,0,.26);
  --shadow-lg:    0 20px 70px rgba(0,0,0,.52);
  --shadow-sb:    0 28px 72px rgba(0,0,0,.62), 0 4px 20px rgba(0,0,0,.36),
                  inset 0 1px 0 rgba(255,255,255,.07);
  --glass-shadow: 0 8px 32px rgba(0,0,0,.32),  0 2px 8px rgba(0,0,0,.22),
                  inset 0 1px 0 rgba(255,255,255,.08);

  --blur:    blur(28px) saturate(160%);
  --blur-sm: blur(16px) saturate(140%);
  --blur-lg: blur(48px) saturate(180%);
  --blur-xl: blur(64px) saturate(200%);
}

/* ══ RESET ═══════════════════════════════════════ */
*,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'Object Sans', sans-serif;
  background: var(--bg);
  background-image: var(--bg-grad);
  background-attachment: fixed;
  color: var(--text);
  font-size: 15px;
  line-height: 1.65;
  min-height: 100vh;
  transition: background .3s, color .3s;
}
/* Ambient depth orbs — iOS glass depth */
body::before, body::after {
  content: '';
  position: fixed;
  border-radius: 50%;
  pointer-events: none;
  z-index: 0;
}
body::before {
  width: 900px; height: 900px;
  top: -280px; right: -80px;
  background: radial-gradient(circle, rgba(132,169,140,.30) 0%, rgba(100,148,120,.10) 40%, transparent 70%);
  filter: blur(2px);
}
body::after {
  width: 700px; height: 700px;
  bottom: -160px; left: 8%;
  background: radial-gradient(circle, rgba(82,121,111,.22) 0%, rgba(60,90,80,.08) 40%, transparent 70%);
  filter: blur(2px);
}
[data-theme="dark"] body::before {
  background: radial-gradient(circle, rgba(82,121,111,.16) 0%, rgba(50,80,70,.06) 40%, transparent 70%);
}
[data-theme="dark"] body::after {
  background: radial-gradient(circle, rgba(47,62,70,.30) 0%, rgba(30,45,55,.10) 40%, transparent 70%);
}

h1,h2,h3,h4 { font-family: 'Instrument Serif', serif; font-weight: 400; line-height: 1.2; }
button { font-family: 'Object Sans', sans-serif; cursor: pointer; border: none; outline: none; }
input, select, textarea { font-family: 'Object Sans', sans-serif; outline: none; }
a { text-decoration: none; color: inherit; }

/* ══ SVG ICON HELPERS ════════════════════════════ */
.icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  color: inherit;
}
.icon svg { display: block; }

/* ══ SIDEBAR — always visible, no collapse ═══════ */
.pill-sidebar {
  position: fixed;
  top: 50%;
  left: 20px;
  transform: translateY(-50%);
  z-index: 200;

  width: var(--sb-w);
  display: flex;
  flex-direction: column;

  /* iOS frosted glass — deep tinted dark panel */
  background: var(--sb-glass);
  backdrop-filter: var(--blur-xl);
  -webkit-backdrop-filter: var(--blur-xl);
  border-radius: 36px;
  padding: 26px 18px 22px;
  box-shadow: var(--shadow-sb);

  /* Specular highlight border — the key iOS glass detail */
  border: 1px solid var(--sb-border);
  /* Top-edge sheen using outline trick */
  outline: 1px solid rgba(255,255,255,.06);
  outline-offset: -2px;

  max-height: calc(100vh - 40px);
  overflow-y: auto;
  overflow-x: hidden;

  transition: background .3s, box-shadow .3s;
}

/* Specular top sheen — bright edge highlight like iOS panels */
.pill-sidebar::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg,
    transparent 0%,
    rgba(255,255,255,.22) 20%,
    rgba(255,255,255,.30) 50%,
    rgba(255,255,255,.22) 80%,
    transparent 100%
  );
  border-radius: 36px 36px 0 0;
  pointer-events: none;
  z-index: 1;
}

/* Subtle left-edge sheen */
.pill-sidebar::after {
  content: '';
  position: absolute;
  top: 12px; left: 0;
  width: 1px;
  height: calc(100% - 24px);
  background: linear-gradient(180deg,
    transparent 0%,
    rgba(255,255,255,.14) 30%,
    rgba(255,255,255,.14) 70%,
    transparent 100%
  );
  pointer-events: none;
  z-index: 1;
}

.pill-sidebar::-webkit-scrollbar { width: 0px; background: transparent; }
.pill-sidebar { scrollbar-width: none; -ms-overflow-style: none; }

/* ── Brand ── */
.pill-brand {
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 2px 10px 22px;
  border-bottom: 1px solid var(--sb-divider);
  margin-bottom: 14px;
  flex-shrink: 0;
}
.pill-logo-icon {
  width: 56px; height: 56px;
  background: linear-gradient(145deg, rgba(82,121,111,.75) 0%, rgba(47,62,70,.90) 100%);
  border-radius: 18px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  box-shadow: 0 6px 20px rgba(82,121,111,.5),
              0 1px 0 rgba(255,255,255,.18) inset;
  color: white;
  position: relative;
  overflow: hidden;
}
/* Glass sheen on logo */
.pill-logo-icon::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 50%;
  background: linear-gradient(180deg, rgba(255,255,255,.18) 0%, transparent 100%);
  border-radius: 18px 18px 0 0;
  pointer-events: none;
}
.pill-brand-name {
  font-family: 'Instrument Serif', serif;
  font-size: 23px;
  color: #cad2c5;
  line-height: 1.15;
}
.pill-brand-sub {
  font-size: 10.5px;
  color: var(--sb-label);
  letter-spacing: .08em;
  text-transform: uppercase;
  margin-top: 1px;
}

/* ── Section label ── */
.sidebar-section-label {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .12em;
  color: var(--sb-label);
  padding: 0 14px;
  margin: 4px 0 8px;
  flex-shrink: 0;
}

/* ── Nav ── */
.pill-nav {
  display: flex;
  flex-direction: column;
  gap: 4px;
  flex: 1;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 15px;
  height: 56px;
  padding: 0 16px;
  border-radius: 20px;
  color: var(--sb-icon);
  font-size: 15.5px;
  font-weight: 500;
  transition: background .2s, color .2s, box-shadow .2s;
  cursor: pointer;
  text-decoration: none;
  flex-shrink: 0;
  position: relative;
}
.nav-item:hover {
  background: var(--sb-hover);
  color: #cad2c5;
}
.nav-item.active {
  background: var(--sb-active);
  backdrop-filter: blur(20px) saturate(160%);
  -webkit-backdrop-filter: blur(20px) saturate(160%);
  color: #fff;
  box-shadow: 0 4px 20px rgba(82,121,111,.45),
              inset 0 1px 0 rgba(255,255,255,.22),
              inset 0 -1px 0 rgba(0,0,0,.10);
  border: 1px solid rgba(255,255,255,.15);
}
/* Specular dot on active icon */
.nav-item.active::before {
  content: '';
  position: absolute;
  top: 8px; left: 8px;
  width: 4px; height: 4px;
  background: rgba(255,255,255,.50);
  border-radius: 50%;
  pointer-events: none;
}
.nav-item .icon { color: inherit; }
.nav-item .nav-label { font-size: 15.5px; font-weight: 500; line-height: 1; }

/* ── Divider ── */
.pill-divider {
  height: 1px;
  background: var(--sb-divider);
  margin: 12px 8px;
  flex-shrink: 0;
}

/* ── Footer rows ── */
.pill-dm-row,
.pill-avatar-row,
.pill-logout-row {
  display: flex;
  align-items: center;
  gap: 15px;
  height: 54px;
  padding: 0 16px;
  border-radius: 20px;
  cursor: pointer;
  transition: background .2s, color .2s;
  flex-shrink: 0;
}

/* Dark-mode row */
.pill-dm-row {
  color: var(--sb-icon);
}
.pill-dm-row:hover {
  background: var(--sb-hover);
  color: #cad2c5;
}
.pill-dm-row .dm-label {
  font-size: 15.5px;
  font-weight: 500;
  flex: 1;
  color: inherit;
}

.dm-switch {
  width: 44px; height: 26px;
  background: rgba(202,210,197,.22);
  border-radius: 13px;
  position: relative;
  flex-shrink: 0;
  transition: background .22s;
}
.dm-switch::after {
  content: '';
  position: absolute;
  width: 20px; height: 20px;
  background: #cad2c5;
  border-radius: 50%;
  top: 3px; left: 3px;
  transition: transform .22s;
  box-shadow: 0 1px 5px rgba(0,0,0,.32);
}
[data-theme="dark"] .dm-switch { background: var(--forest); }
[data-theme="dark"] .dm-switch::after { transform: translateX(18px); }

/* Avatar row */
.pill-avatar-row {
  color: var(--sb-label);
  cursor: default;
}
.pill-avatar {
  width: 44px; height: 44px;
  background: linear-gradient(135deg, var(--forest-dark), var(--forest));
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 15px; font-weight: 700; color: white;
  border: 2px solid rgba(202,210,197,.22);
  flex-shrink: 0;
}
.pill-user-name {
  font-size: 14.5px;
  font-weight: 600;
  color: #cad2c5;
  line-height: 1.3;
}
.pill-user-role {
  font-size: 11px;
  color: var(--sb-label);
  line-height: 1.4;
}

/* Logout row */
.pill-logout-row {
  color: rgba(202,210,197,.35);
  border: none;
  background: none;
  font-family: 'Object Sans', sans-serif;
  width: 100%;
}
.pill-logout-row:hover {
  background: rgba(191,64,64,.16);
  color: #e07070;
}
.pill-logout-row .nav-label {
  font-size: 15.5px;
  font-weight: 500;
}

/* ══ MAIN CONTENT ════════════════════════════════ */
.main-content {
  margin-left: calc(var(--sb-w) + 40px);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  position: relative;
  z-index: 1;
}

/* ══ PILL TOPBAR ════════════════════════════════ */

.topbar-wrap {
  padding: 18px 24px 0;
}

.topbar {
  /* iOS frosted glass — matching sidebar tint for cohesion */
  background: var(--sb-glass);
  backdrop-filter: var(--blur-xl);
  -webkit-backdrop-filter: var(--blur-xl);
  border-radius: 60px;
  padding: 11px 14px 11px 26px;
  display: flex; align-items: center; justify-content: space-between;
  position: relative;

  /* Layered shadows */
  box-shadow: 0 8px 40px rgba(10,18,24,.28),
              0 2px 12px rgba(10,18,24,.18),
              inset 0 1px 0 rgba(255,255,255,.14),
              inset 0 -1px 0 rgba(0,0,0,.08);
  transition: background .3s;

  /* Glass border */
  border: 1px solid rgba(255,255,255,.09);
  overflow: hidden;
}

/* Top specular sheen on topbar */
.topbar::before {
  content: '';
  position: absolute;
  top: 0; left: 10%; right: 10%;
  height: 1px;
  background: linear-gradient(90deg,
    transparent 0%,
    rgba(255,255,255,.30) 30%,
    rgba(255,255,255,.40) 50%,
    rgba(255,255,255,.30) 70%,
    transparent 100%
  );
  pointer-events: none;
  z-index: 1;
}

/* Frosted glass inner glow */
.topbar::after {
  content: '';
  position: absolute;
  inset: 1px;
  border-radius: 60px;
  background: linear-gradient(180deg,
    rgba(255,255,255,.06) 0%,
    transparent 40%
  );
  pointer-events: none;
  z-index: 0;
}

.topbar-left  { display: flex; align-items: center; gap: 14px; }
.topbar-title {
  font-family: 'Instrument Serif', serif;
  font-size: 23px;
  color: #cad2c5;
  white-space: nowrap;
}
.topbar-role-pill {
  font-size: 10.5px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .09em;
  color: rgba(202,210,197,.55);
  padding: 4px 14px;
  background: rgba(202,210,197,.10);
  border: 1px solid rgba(202,210,197,.15);
  border-radius: 20px;
  white-space: nowrap;
}
.topbar-badge {
  padding: 6px 16px;
  background: rgba(82,121,111,.28);
  color: #b5cabc;
  border-radius: 20px;
  font-size: 13px; font-weight: 600;
  border: 1px solid rgba(82,121,111,.28);
  white-space: nowrap;
}
.topbar-sep {
  width: 1px; height: 24px;
  background: rgba(202,210,197,.15);
  flex-shrink: 0;
}
.topbar-user { display: flex; align-items: center; gap: 10px; }
.topbar-avatar {
  width: 40px; height: 40px;
  background: linear-gradient(135deg, var(--forest), var(--forest-dark));
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 14px; font-weight: 700; color: white;
  border: 2px solid rgba(202,210,197,.22);
}
.topbar-user-name { font-size: 14px; font-weight: 600; color: #cad2c5; line-height: 1.3; }
.topbar-user-role { font-size: 11.5px; color: rgba(202,210,197,.50); line-height: 1.3; }

.topbar-icon-btn {
  width: 40px; height: 40px;
  border-radius: 50%;
  background: rgba(202,210,197,.10);
  border: 1px solid rgba(202,210,197,.15);
  display: flex; align-items: center; justify-content: center;
  cursor: pointer;
  transition: background .2s, color .2s;
  color: rgba(202,210,197,.70);
  flex-shrink: 0;
}
.topbar-icon-btn:hover { background: rgba(82,121,111,.38); color: #cad2c5; }

.page-content { padding: 26px 24px 44px; flex: 1; }

/* ══ GLASS CARDS ════════════════════════════════ */
.card {
  background: var(--surface);
  backdrop-filter: var(--blur);
  -webkit-backdrop-filter: var(--blur);
  border-radius: var(--radius);

  /* iOS glass shadow: soft depth + specular top highlight */
  box-shadow: var(--glass-shadow);
  border: 1px solid var(--border);

  overflow: hidden;
  transition: background .3s, border-color .3s, transform .2s, box-shadow .2s;
  position: relative;
}

/* Specular top sheen on cards */
.card::before {
  content: '';
  position: absolute;
  top: 0; left: 5%; right: 5%;
  height: 1px;
  background: linear-gradient(90deg,
    transparent 0%,
    var(--glass-sheen) 30%,
    var(--glass-sheen) 70%,
    transparent 100%
  );
  pointer-events: none;
  z-index: 1;
  border-radius: var(--radius) var(--radius) 0 0;
}

/* Subtle inner frosted gradient */
.card::after {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 50%;
  background: linear-gradient(180deg,
    rgba(255,255,255,.06) 0%,
    transparent 100%
  );
  pointer-events: none;
  z-index: 0;
  border-radius: var(--radius) var(--radius) 0 0;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 18px 54px rgba(47,62,70,.16),
              0 4px 16px rgba(47,62,70,.10),
              inset 0 1px 0 rgba(255,255,255,.90);
  border-color: rgba(255,255,255,.85);
}
.card-header {
  padding: 20px 26px;
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
  background: rgba(255,255,255,.05);
  position: relative;
  z-index: 2;
}
.card-title { font-size: 16px; font-weight: 700; color: var(--text); letter-spacing: .01em; }
.card-body { padding: 24px 26px; position: relative; z-index: 2; }

/* ══ STATS ═══════════════════════════════════════ */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4,1fr);
  gap: 18px;
  margin-bottom: 28px;
}
.stat-card {
  background: var(--surface);
  backdrop-filter: var(--blur);
  -webkit-backdrop-filter: var(--blur);
  border-radius: var(--radius);
  padding: 24px;
  box-shadow: var(--glass-shadow);
  border: 1px solid var(--border);
  display: flex; align-items: flex-start; gap: 18px;
  transition: transform .2s, box-shadow .2s, background .3s;
  position: relative;
  overflow: hidden;
}

/* Specular sheen on stat cards */
.stat-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg,
    transparent 0%,
    var(--glass-sheen) 25%,
    var(--glass-sheen) 75%,
    transparent 100%
  );
  pointer-events: none;
  z-index: 1;
}
.stat-card::after {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 45%;
  background: linear-gradient(180deg, rgba(255,255,255,.05) 0%, transparent 100%);
  pointer-events: none;
  z-index: 0;
  border-radius: var(--radius) var(--radius) 0 0;
}

.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 18px 54px rgba(47,62,70,.18),
              0 4px 16px rgba(47,62,70,.10),
              inset 0 1px 0 rgba(255,255,255,.90);
  border-color: rgba(255,255,255,.85);
}
.stat-icon {
  width: 56px; height: 56px;
  border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  position: relative;
  z-index: 2;
}
.stat-icon.teal  { background: var(--green-light); color: var(--forest); }
.stat-icon.amber { background: var(--amber-light); color: var(--amber); }
.stat-icon.green { background: var(--green-light); color: var(--forest); }
.stat-icon.blue  { background: var(--blue-light);  color: var(--blue); }
.stat-icon.sage  { background: rgba(202,210,197,.14); color: var(--forest-dark); }
.stat-label { font-size: 11px; color: var(--text3); font-weight: 700; text-transform: uppercase; letter-spacing: .07em; }
.stat-value { font-family: 'Instrument Serif', serif; font-size: 36px; line-height: 1.15; margin: 4px 0; color: var(--text); position: relative; z-index: 2; }
.stat-sub { font-size: 12.5px; color: var(--text3); }

/* ══ BUTTONS ══════════════════════════════════════ */
.btn {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 10px 22px; border-radius: var(--radius-sm);
  font-size: 14px; font-weight: 600;
  transition: all .18s; border: none; cursor: pointer;
}
.btn-primary   { background: var(--forest); color: white; box-shadow: 0 4px 16px rgba(82,121,111,.38); }
.btn-primary:hover { background: var(--forest-dark); transform: translateY(-1px); }
.btn-secondary { background: var(--surface2); backdrop-filter: var(--blur-sm); -webkit-backdrop-filter: var(--blur-sm); color: var(--text2); border: 1px solid var(--border); }
.btn-secondary:hover { background: var(--surface); color: var(--text); }
.btn-danger    { background: var(--red-light); backdrop-filter: var(--blur-sm); -webkit-backdrop-filter: var(--blur-sm); color: var(--red); border: 1px solid rgba(191,64,64,.2); }
.btn-danger:hover { background: var(--red); color: white; }
.btn-success   { background: var(--green-light); backdrop-filter: var(--blur-sm); -webkit-backdrop-filter: var(--blur-sm); color: var(--forest); border: 1px solid rgba(82,121,111,.22); }
.btn-success:hover { background: var(--forest); color: white; }
.btn-accent    { background: var(--forest-dark); color: white; }
.btn-accent:hover { background: var(--deep); }
.btn-sm { padding: 6px 14px; font-size: 13px; }

/* ══ TABLES ═══════════════════════════════════════ */
.table-wrapper { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
thead th {
  padding: 13px 20px;
  background: rgba(202,210,197,.07);
  backdrop-filter: var(--blur-sm); -webkit-backdrop-filter: var(--blur-sm);
  border-bottom: 1px solid var(--border);
  font-size: 11px; font-weight: 700; color: var(--text3);
  text-transform: uppercase; letter-spacing: .08em; text-align: left; white-space: nowrap;
}
tbody td { padding: 15px 20px; border-bottom: 1px solid var(--border); font-size: 14.5px; vertical-align: middle; }
tbody tr:last-child td { border-bottom: none; }
tbody tr:hover { background: rgba(202,210,197,.06); }

/* ══ BADGES ═══════════════════════════════════════ */
.badge {
  display: inline-flex; align-items: center; gap: 4px;
  padding: 4px 12px; border-radius: 20px;
  font-size: 12px; font-weight: 700; letter-spacing: .03em;
  backdrop-filter: var(--blur-sm); -webkit-backdrop-filter: var(--blur-sm);
}
.badge-green  { background: var(--green-light); color: var(--forest);         border: 1px solid rgba(82,121,111,.22); }
.badge-red    { background: var(--red-light);   color: var(--red);            border: 1px solid rgba(191,64,64,.22); }
.badge-amber  { background: var(--amber-light); color: var(--amber);          border: 1px solid rgba(160,112,48,.22); }
.badge-blue   { background: var(--blue-light);  color: var(--blue);           border: 1px solid rgba(61,107,114,.22); }
.badge-teal   { background: var(--green-light); color: var(--forest);         border: 1px solid rgba(82,121,111,.22); }
.badge-gray   { background: var(--surface2);    color: var(--text3);          border: 1px solid var(--border); }
.badge-purple { background: rgba(109,40,217,.1); color: #7c3aed;              border: 1px solid rgba(109,40,217,.2); }
.badge-sage   { background: rgba(202,210,197,.14); color: var(--forest-dark); border: 1px solid var(--border); }
[data-theme="dark"] .badge-purple { background: rgba(109,40,217,.18); color: #b48ef0; border-color: rgba(109,40,217,.3); }

/* ══ FORMS ════════════════════════════════════════ */
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--text2); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .06em; }
.form-control {
  width: 100%; padding: 12px 16px;
  border: 1.5px solid var(--border-solid); border-radius: var(--radius-sm);
  font-size: 14.5px; color: var(--text);
  background: var(--surface); backdrop-filter: var(--blur-sm); -webkit-backdrop-filter: var(--blur-sm);
  transition: border-color .2s, box-shadow .2s, background .3s;
}
.form-control:focus { border-color: var(--forest); box-shadow: 0 0 0 4px rgba(82,121,111,.12); }
select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2384a98c' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 15px center; padding-right: 38px; }
textarea.form-control { resize: vertical; min-height: 94px; }
.form-row   { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
.toggle-wrap { display: flex; align-items: center; gap: 10px; margin-top: 4px; }
.toggle-input { display: none; }
.toggle-label-ui { width: 48px; height: 26px; background: var(--border-solid); border-radius: 13px; position: relative; cursor: pointer; transition: background .2s; display: block; }
.toggle-label-ui::after { content: ''; position: absolute; width: 20px; height: 20px; background: white; border-radius: 10px; top: 3px; left: 3px; transition: transform .2s; box-shadow: 0 2px 6px rgba(0,0,0,.25); }
.toggle-input:checked+.toggle-label-ui { background: var(--forest); }
.toggle-input:checked+.toggle-label-ui::after { transform: translateX(22px); }

/* ══ ALERTS ═══════════════════════════════════════ */
.alert { padding: 14px 20px; border-radius: var(--radius-sm); font-size: 14.5px; margin-bottom: 20px; backdrop-filter: var(--blur-sm); -webkit-backdrop-filter: var(--blur-sm); }
.alert-success { background: var(--green-light); color: var(--forest-dark); border: 1px solid rgba(82,121,111,.22); }
.alert-error   { background: var(--red-light);   color: #7f2020;            border: 1px solid rgba(191,64,64,.22); }

/* ══ TOOLBAR & SEARCH ════════════════════════════ */
.page-toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 26px; gap: 14px; }
.page-toolbar-left { display: flex; align-items: center; gap: 12px; flex: 1; }
.search-bar {
  display: flex; align-items: center; gap: 10px; padding: 11px 20px;
  border: 1.5px solid var(--border); border-radius: 32px;
  background: var(--surface); backdrop-filter: var(--blur); -webkit-backdrop-filter: var(--blur);
  transition: border-color .2s, box-shadow .2s;
}
.search-bar:focus-within { border-color: var(--forest); box-shadow: 0 0 0 4px rgba(82,121,111,.1); }
.search-bar input { border: none; font-size: 14.5px; color: var(--text); background: none; flex: 1; }
.search-bar input::placeholder { color: var(--text3); }

/* ══ CALENDAR ════════════════════════════════════ */
.calendar-grid { display: grid; grid-template-columns: repeat(7,1fr); gap: 3px; }
.cal-day-header { text-align: center; font-size: 11px; font-weight: 700; color: var(--text3); padding: 7px 0; text-transform: uppercase; letter-spacing: .07em; }
.cal-day { aspect-ratio: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 12px; cursor: pointer; font-size: 14px; font-weight: 500; transition: all .15s; position: relative; text-decoration: none; color: var(--text); }
.cal-day:hover { background: var(--green-light); color: var(--forest); }
.cal-day.today { background: var(--forest); color: white; font-weight: 700; box-shadow: 0 4px 14px rgba(82,121,111,.4); }
.cal-day.has-event::after { content: ''; position: absolute; bottom: 4px; width: 5px; height: 5px; background: var(--amber); border-radius: 3px; }
.cal-day.today.has-event::after { background: white; }
.cal-day.other-month { color: var(--text3); }
.cal-day.other-month:hover { background: var(--surface2); }
.cal-nav { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
.cal-nav-btn { background: var(--surface2); backdrop-filter: var(--blur-sm); border: 1px solid var(--border); width: 32px; height: 32px; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text2); text-decoration: none; transition: all .15s; }
.cal-nav-btn:hover { background: var(--green-light); border-color: var(--forest); color: var(--forest); }
.cal-month-label { font-weight: 700; font-size: 15px; color: var(--text); }

/* ══ QUICK ACTIONS ═══════════════════════════════ */
.quick-actions-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 13px; }
.quick-action {
  display: flex; align-items: center; gap: 14px; padding: 16px 18px;
  border-radius: var(--radius-sm); border: 1.5px solid var(--border);
  background: var(--surface); backdrop-filter: var(--blur); -webkit-backdrop-filter: var(--blur);
  cursor: pointer; transition: all .2s; text-align: left; text-decoration: none; width: 100%;
}
.quick-action:hover { border-color: var(--forest); background: var(--green-light); transform: translateY(-2px); box-shadow: var(--glass-shadow); }
.qa-icon { width: 42px; height: 42px; border-radius: 13px; background: var(--green-light); display: flex; align-items: center; justify-content: center; color: var(--forest); flex-shrink: 0; }
.qa-text { font-size: 14px; font-weight: 600; color: var(--text); }
.qa-sub  { font-size: 12px; color: var(--text3); }

/* ══ SCHEDULE ITEMS ══════════════════════════════ */
.schedule-item { display: flex; align-items: center; gap: 13px; padding: 13px 0; border-bottom: 1px solid var(--border); }
.schedule-item:last-child { border-bottom: none; }
.sched-time { font-size: 12px; color: var(--forest); font-weight: 700; white-space: nowrap; min-width: 64px; }
.sched-name { font-size: 14px; font-weight: 600; color: var(--text); }
.sched-vaccine { font-size: 12px; color: var(--text3); }

/* ══ SECTION GRIDS ═══════════════════════════════ */
.section-grid      { display: grid; grid-template-columns: 1fr 1fr;  gap: 22px; margin-bottom: 26px; }
.section-grid-main { display: grid; grid-template-columns: 3fr 2fr;  gap: 22px; margin-bottom: 26px; }
.section-grid-3    { display: grid; grid-template-columns: 2fr 1fr;  gap: 22px; margin-bottom: 26px; }

/* ══ PAYMENTS ════════════════════════════════════ */
.pay-stats-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 18px; margin-bottom: 26px; }
.pay-stat {
  background: var(--surface);
  backdrop-filter: var(--blur);
  -webkit-backdrop-filter: var(--blur);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 24px;
  box-shadow: var(--glass-shadow);
  position: relative;
  overflow: hidden;
}
.pay-stat::before {
  content: '';
  position: absolute;
  top: 0; left: 5%; right: 5%;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--glass-sheen) 30%, var(--glass-sheen) 70%, transparent);
  pointer-events: none;
  z-index: 1;
}
.pay-stat-label { font-size: 11px; text-transform: uppercase; letter-spacing: .07em; color: var(--text3); font-weight: 700; position: relative; z-index: 2; }
.pay-stat-val { font-family: 'Instrument Serif', serif; font-size: 32px; margin-top: 6px; color: var(--text); position: relative; z-index: 2; }

/* ══ SMS LOG ══════════════════════════════════════ */
.sms-log { background: rgba(10,15,20,.86); backdrop-filter: var(--blur); -webkit-backdrop-filter: var(--blur); border-radius: 14px; padding: 16px 20px; font-family: monospace; font-size: 13px; color: var(--sage-mid); max-height: 190px; overflow-y: auto; }
.sms-entry { margin-bottom: 7px; padding-bottom: 7px; border-bottom: 1px solid rgba(202,210,197,.08); }
.sms-entry:last-child { border-bottom: none; margin-bottom: 0; }
.sms-time { color: var(--sage-light); }
.sms-ok   { color: #81c784; }
.sms-type { color: #ffb74d; }

/* ══ INFO GRID ════════════════════════════════════ */
.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
.info-item label { font-size: 11px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .07em; display: block; margin-bottom: 3px; }
.info-item p { font-size: 15px; font-weight: 500; color: var(--text); }

/* ══ PARENT HEADER ════════════════════════════════ */
.parent-header {
  background: linear-gradient(135deg, rgba(47,62,70,.88) 0%, rgba(82,121,111,.82) 100%);
  backdrop-filter: var(--blur); -webkit-backdrop-filter: var(--blur);
  padding: 36px 32px; color: white; border-radius: var(--radius);
  margin-bottom: 28px; position: relative; overflow: hidden;
  border: 1px solid rgba(202,210,197,.13); box-shadow: var(--glass-shadow);
}
.parent-header::before { content: ''; position: absolute; top: -50%; right: -5%; width: 320px; height: 320px; background: rgba(202,210,197,.07); border-radius: 50%; }
.parent-header h2 { font-size: 30px; margin-bottom: 6px; }
.parent-header p { opacity: .75; font-size: 15px; }

/* ══ TABS ═════════════════════════════════════════ */
.tab-bar { display: flex; gap: 5px; border-bottom: 2px solid var(--border); margin-bottom: 24px; }
.tab-btn { padding: 10px 20px; font-size: 14px; font-weight: 600; background: none; color: var(--text3); border: none; border-bottom: 2px solid transparent; margin-bottom: -2px; cursor: pointer; transition: all .15s; }
.tab-btn.active { color: var(--forest); border-bottom-color: var(--forest); }

/* ══ REPORTS ══════════════════════════════════════ */
.report-preview { background: var(--surface); backdrop-filter: var(--blur); -webkit-backdrop-filter: var(--blur); border: 1px solid var(--border); border-radius: var(--radius); padding: 36px; }
.report-header { text-align: center; margin-bottom: 26px; padding-bottom: 22px; border-bottom: 2px solid var(--forest); }
.report-header h1 { font-family: 'Instrument Serif', serif; font-size: 28px; color: var(--forest-dark); }
.report-section { margin-bottom: 24px; }
.report-section h3 { font-size: 11.5px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 12px; padding-bottom: 7px; border-bottom: 1px solid var(--border); }

/* ══ SECTION HINT ════════════════════════════════ */
.section-hint { padding: 13px 18px; background: var(--green-light); backdrop-filter: var(--blur-sm); -webkit-backdrop-filter: var(--blur-sm); border-radius: var(--radius-sm); font-size: 13.5px; color: var(--forest-dark); border: 1px solid rgba(82,121,111,.22); margin-bottom: 18px; }

/* ══ EMPTY STATE ══════════════════════════════════ */
.empty-state { text-align: center; padding: 56px 28px; color: var(--text3); }
.empty-icon { margin-bottom: 14px; opacity: .6; }
.empty-state p { font-size: 15px; }

/* ══ MODAL ════════════════════════════════════════ */
.modal-overlay { position: fixed; inset: 0; background: rgba(8,14,20,.60); z-index: 1000; display: none; align-items: center; justify-content: center; padding: 24px; }
.modal-overlay.open { display: flex; }
.modal {
  background: var(--surface);
  backdrop-filter: var(--blur-xl);
  -webkit-backdrop-filter: var(--blur-xl);
  border-radius: 28px;
  box-shadow: 0 32px 80px rgba(0,0,0,.28),
              0 8px 24px rgba(0,0,0,.16),
              inset 0 1px 0 var(--glass-sheen);
  width: 100%;
  animation: modalIn .24s cubic-bezier(.32,.72,0,1);
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  border: 1px solid var(--border);
  position: relative;
  overflow: hidden;
}
/* Modal top specular sheen */
.modal::before {
  content: '';
  position: absolute;
  top: 0; left: 5%; right: 5%;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--glass-sheen) 30%, var(--glass-sheen) 70%, transparent);
  z-index: 1;
  pointer-events: none;
}
@keyframes modalIn { from { opacity:0; transform: scale(.96) translateY(18px); } to { opacity:1; transform: none; } }
.modal-sm { max-width: 460px; } .modal-md { max-width: 600px; } .modal-lg { max-width: 800px; }
.modal-header { padding: 26px 30px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: relative; z-index: 2; }
.modal-title { font-family: 'Instrument Serif', serif; font-size: 24px; color: var(--text); }
.modal-close { background: var(--surface2); backdrop-filter: var(--blur-sm); -webkit-backdrop-filter: var(--blur-sm); color: var(--text3); font-size: 18px; padding: 7px 11px; border-radius: 10px; cursor: pointer; border: 1px solid var(--border); }
.modal-close:hover { background: var(--red-light); color: var(--red); }
.modal-body { padding: 24px 30px; overflow-y: auto; flex: 1; max-height: calc(90vh - 180px); position: relative; z-index: 2; }
.modal-footer { padding: 20px 30px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 12px; flex-shrink: 0; position: relative; z-index: 2; }

/* ══ UTILITY ══════════════════════════════════════ */
.flex{display:flex}.items-center{align-items:center}.justify-between{justify-content:space-between}
.gap-2{gap:9px}.gap-3{gap:15px}
.mt-2{margin-top:9px}.mt-4{margin-top:18px}.mb-4{margin-bottom:18px}
.text-sm{font-size:13px}.text-muted{color:var(--text3)}
.font-bold{font-weight:700}.font-medium{font-weight:500}
.hidden{display:none!important}.w-full{width:100%}

::-webkit-scrollbar{width:10px;height:10px}
::-webkit-scrollbar-track{background:rgba(132,169,140,.1);border-radius:10px}
::-webkit-scrollbar-thumb{background:rgba(82,121,111,.5);border-radius:10px}
::-webkit-scrollbar-thumb:hover{background:var(--sage-mid)}

@media print {
  .no-print{display:none!important}
  .pill-sidebar,.topbar-wrap,.topbar{display:none!important}
  .main-content{margin-left:0!important}
  body::before,body::after{display:none}
}
</style>
<?php echo $__env->yieldContent('head'); ?>







<style>

/* ═══════════════════════════════════════════════════════════
   1. MOBILE TOP NAV BAR  (hidden on desktop)
   — A fixed header that holds the hamburger + brand logo
   ═══════════════════════════════════════════════════════════ */
.mobile-topnav {
  display: none; /* hidden on desktop */
}

@media (max-width: 768px) {
  /* ── Mobile top nav ── */
  .mobile-topnav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1100;
    height: 60px;
    padding: 0 16px;
    background: var(--sb-glass);
    backdrop-filter: var(--blur-xl);
    -webkit-backdrop-filter: var(--blur-xl);
    border-bottom: 1px solid var(--sb-border);
    box-shadow: 0 2px 20px rgba(0,0,0,.28);
  }

  .mobile-topnav-brand {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .mobile-topnav-brand-name {
    font-family: 'Instrument Serif', serif;
    font-size: 20px;
    color: #cad2c5;
    line-height: 1;
  }

  .mobile-hamburger {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: rgba(202,210,197,.12);
    border: 1px solid rgba(202,210,197,.18);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    cursor: pointer;
    transition: background .2s;
    flex-shrink: 0;
  }

  .mobile-hamburger:active,
  .mobile-hamburger.active {
    background: rgba(82,121,111,.40);
  }

  .mobile-hamburger span {
    display: block;
    width: 20px;
    height: 2px;
    background: #cad2c5;
    border-radius: 2px;
    transition: transform .25s, opacity .2s;
    transform-origin: center;
  }

  /* Animate hamburger → X when open */
  .mobile-hamburger.active span:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
  }
  .mobile-hamburger.active span:nth-child(2) {
    opacity: 0;
    transform: scaleX(0);
  }
  .mobile-hamburger.active span:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
  }
}


/* ═══════════════════════════════════════════════════════════
   2. SIDEBAR — becomes a full-height drawer on mobile
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  /* Reset pill-sidebar from its desktop centered-pill style */
  .pill-sidebar {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    bottom: 0 !important;
    transform: translateX(-110%) !important;
    width: min(300px, 85vw) !important;
    max-width: 300px !important;
    height: 100dvh !important;
    max-height: 100dvh !important;
    border-radius: 0 28px 28px 0 !important;
    padding: 80px 18px 28px !important; /* top padding clears mobile nav bar */
    z-index: 1050 !important;
    transition: transform .3s cubic-bezier(.32,.72,0,1) !important;
    overflow-y: auto;
    overflow-x: hidden;
  }

  .pill-sidebar.mobile-open {
    transform: translateX(0) !important;
  }

  /* Backdrop overlay */
  .mobile-sidebar-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.52);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 1040;
    opacity: 0;
    transition: opacity .3s ease;
  }

  .mobile-sidebar-backdrop.active {
    display: block;
    opacity: 1;
  }
}


/* ═══════════════════════════════════════════════════════════
   3. MAIN CONTENT — remove desktop left-margin, add top offset
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .main-content {
    margin-left: 0 !important;
    padding-top: 60px !important; /* offset for fixed mobile nav bar */
    min-height: 100dvh;
  }

  /* Hide desktop topbar on mobile — we have the mobile-topnav instead */
  .topbar-wrap {
    display: none !important;
  }

  .page-content {
    padding: 16px 14px 40px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   4. STATS GRID — stack to 2 columns then 1 column
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .stats-grid {
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 12px !important;
    margin-bottom: 18px !important;
  }

  .stat-card {
    padding: 16px !important;
    gap: 12px !important;
  }

  .stat-icon {
    width: 44px !important;
    height: 44px !important;
  }

  .stat-value {
    font-size: 28px !important;
  }

  .stat-label {
    font-size: 10px !important;
  }

  .stat-sub {
    font-size: 11px !important;
  }
}

@media (max-width: 420px) {
  .stats-grid {
    grid-template-columns: 1fr !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   5. SECTION GRIDS — collapse to single column
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .section-grid,
  .section-grid-main,
  .section-grid-3 {
    grid-template-columns: 1fr !important;
    gap: 14px !important;
    margin-bottom: 14px !important;
  }

  .pay-stats-grid {
    grid-template-columns: 1fr !important;
    gap: 12px !important;
    margin-bottom: 18px !important;
  }

  /* Dashboard right column: remove flex gap compression */
  .section-grid-main > div[style*="flex-direction:column"] {
    gap: 14px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   6. TABLES — horizontal scroll + condensed cells
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  /* Force table wrapper to allow scrolling */
  .table-wrapper {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
    border-radius: 0 0 var(--radius) var(--radius);
  }

  table {
    min-width: 560px; /* prevents collapse — scroll instead */
    font-size: 13px !important;
  }

  thead th {
    padding: 10px 12px !important;
    font-size: 10px !important;
    white-space: nowrap;
  }

  tbody td {
    padding: 10px 12px !important;
    font-size: 13px !important;
    white-space: nowrap;
  }

  /* Action button groups in table cells */
  tbody td .flex {
    flex-wrap: nowrap;
    gap: 5px !important;
  }

  /* Status select in table */
  tbody td select.form-control {
    font-size: 12px !important;
    padding: 4px 8px !important;
    min-height: 34px !important;
    width: 110px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   7. CARDS — full-width, tighter padding
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .card {
    border-radius: 18px !important;
    margin-bottom: 14px !important;
  }

  .card-header {
    padding: 14px 16px !important;
    flex-wrap: wrap;
    gap: 8px;
  }

  .card-title {
    font-size: 14px !important;
  }

  .card-body {
    padding: 14px 16px !important;
  }

  /* Pay stat cards */
  .pay-stat-card {
    border-radius: 16px !important;
    padding: 18px !important;
  }

  .pay-stat-val-new {
    font-size: 26px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   8. PAGE TOOLBAR — stack search & buttons vertically
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .page-toolbar {
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 10px !important;
    margin-bottom: 16px !important;
  }

  .page-toolbar-left {
    width: 100%;
  }

  .page-toolbar-left form {
    width: 100% !important;
    flex-direction: column !important;
    gap: 8px !important;
  }

  .search-bar {
    width: 100% !important;
  }

  .page-toolbar > .flex,
  .page-toolbar > div:last-child,
  .toolbar-improved > div:last-child {
    display: flex !important;
    flex-direction: column !important;
    gap: 8px !important;
    width: 100%;
  }

  .toolbar-improved {
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 10px !important;
    margin-bottom: 16px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   9. BUTTONS — touch-friendly size, full-width primaries
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .btn {
    min-height: 44px !important;
    font-size: 14px !important;
    padding: 11px 18px !important;
    border-radius: 12px !important;
    justify-content: center;
  }

  .btn-sm {
    min-height: 36px !important;
    font-size: 12px !important;
    padding: 7px 12px !important;
  }

  /* Primary action buttons stretch full width in toolbar */
  .page-toolbar .btn-primary,
  .toolbar-improved .btn-primary {
    width: 100% !important;
  }

  .page-toolbar .btn-secondary,
  .toolbar-improved .btn-secondary {
    width: 100% !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   10. FORMS — single column, iOS-safe font sizes
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .form-row,
  .form-row-3 {
    grid-template-columns: 1fr !important;
    gap: 12px !important;
  }

  .form-group {
    margin-bottom: 14px !important;
  }

  .form-control {
    min-height: 46px !important;
    font-size: 16px !important; /* prevents iOS auto-zoom */
    padding: 12px 14px !important;
    border-radius: 12px !important;
  }

  textarea.form-control {
    min-height: 90px !important;
  }

  select.form-control {
    font-size: 16px !important;
    min-height: 46px !important;
  }

  input,
  textarea,
  select {
    font-size: 16px !important; /* iOS zoom prevention */
  }

  .form-control:focus {
    font-size: 16px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   11. MODALS — bottom sheet, scrollable body, footer always visible
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  /* Overlay: zero padding, align to bottom */
  .modal-overlay {
    padding: 0 !important;
    align-items: flex-end !important;
  }

  /* Modal: full width, capped height, flex column so footer is never cut off */
  .modal {
    border-radius: 24px 24px 0 0 !important;
    max-height: 90dvh !important;
    height: auto !important;
    width: 100% !important;
    display: flex !important;
    flex-direction: column !important;
    /* Prevent the modal itself from scrolling — only .modal-body scrolls */
    overflow: hidden !important;
  }

  .modal-sm,
  .modal-md,
  .modal-lg {
    max-width: 100% !important;
  }

  /* Header stays fixed at top of the sheet */
  .modal-header {
    padding: 18px 20px 14px !important;
    flex-shrink: 0 !important;
    overflow: hidden !important;
  }

  .modal-title {
    font-size: 19px !important;
  }

  /* Body scrolls, fills remaining space between header and footer */
  .modal-body {
    padding: 16px 20px !important;
    overflow-y: scroll !important;           /* force scroll even when content barely overflows */
    -webkit-overflow-scrolling: touch !important; /* iOS momentum scrolling */
    overscroll-behavior: contain !important; /* prevent page scroll bleed-through */
    flex: 1 1 auto !important;
    max-height: none !important;
    min-height: 0 !important;               /* critical: lets flexbox shrink this below content size */
  }

  /* Footer always pinned at bottom of sheet — never clipped */
  .modal-footer {
    padding: 12px 20px 20px !important;
    flex-direction: column !important;
    gap: 8px !important;
    flex-shrink: 0 !important;
    border-top: 1px solid var(--border) !important;
    background: var(--surface) !important;  /* ensure it has a background, not transparent */
  }

  .modal-footer .btn {
    width: 100% !important;
    justify-content: center !important;
  }

  /* Custom modals (add past vaccine on children-show page) */
  .custom-modal {
    align-items: flex-end !important;
    padding: 0 !important;
  }

  .custom-modal-content {
    width: 100% !important;
    max-width: 100% !important;
    max-height: 90dvh !important;
    border-radius: 24px 24px 0 0 !important;
    display: flex !important;
    flex-direction: column !important;
    overflow: hidden !important;
  }

  .custom-modal-content .card-body {
    overflow-y: scroll !important;
    -webkit-overflow-scrolling: touch !important;
    overscroll-behavior: contain !important;
    flex: 1 1 auto !important;
    min-height: 0 !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   12. INFO GRID — stack to one column
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .info-grid {
    grid-template-columns: 1fr !important;
    gap: 10px !important;
  }

  .info-item p {
    font-size: 14px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   13. QUICK ACTIONS GRID — 2 col on mobile, 1 col on tiny screens
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .quick-actions-grid {
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 10px !important;
  }

  .quick-action {
    padding: 12px !important;
    gap: 10px !important;
  }

  .qa-icon {
    width: 36px !important;
    height: 36px !important;
  }

  .qa-text {
    font-size: 13px !important;
  }

  .qa-sub {
    font-size: 11px !important;
  }
}

@media (max-width: 360px) {
  .quick-actions-grid {
    grid-template-columns: 1fr !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   14. PARENT HEADER BANNER — compact on mobile
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .parent-header {
    padding: 22px 18px !important;
    margin-bottom: 16px !important;
    border-radius: 18px !important;
  }

  .parent-header h2 {
    font-size: 22px !important;
    margin-bottom: 4px !important;
  }

  .parent-header p {
    font-size: 13px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   15. SCHEDULE ITEMS — readable on small screens
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .schedule-item {
    gap: 10px !important;
    padding: 11px 0 !important;
  }

  .sched-time {
    min-width: 52px !important;
    font-size: 11px !important;
  }

  .sched-name {
    font-size: 13px !important;
  }

  .sched-vaccine {
    font-size: 11px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   16. BADGES — comfortable padding on mobile
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .badge {
    font-size: 11px !important;
    padding: 4px 9px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   17. CALENDAR — slightly smaller cells
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .cal-day {
    font-size: 13px !important;
    border-radius: 10px !important;
  }

  .cal-day-header {
    font-size: 10px !important;
    padding: 5px 0 !important;
  }

  .cal-month-label {
    font-size: 14px !important;
  }

  .calendar-grid {
    gap: 2px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   18. ALERTS — tighter spacing
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .alert {
    padding: 12px 14px !important;
    font-size: 13px !important;
    border-radius: 12px !important;
    margin-bottom: 14px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   19. TAB BAR — scrollable on mobile
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .tab-bar {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    gap: 2px !important;
    padding-bottom: 0;
    flex-wrap: nowrap;
  }

  .tab-bar::-webkit-scrollbar {
    display: none;
  }

  .tab-btn {
    white-space: nowrap;
    padding: 10px 14px !important;
    font-size: 13px !important;
    flex-shrink: 0;
  }
}


/* ═══════════════════════════════════════════════════════════
   20. SMS LOG — full width
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .sms-log {
    font-size: 11.5px !important;
    padding: 12px 14px !important;
    max-height: 160px !important;
    border-radius: 12px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   20b. REPORT PREVIEW — scrollable table, full content visible
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  /* The report-preview card body should not clip content */
  .report-preview {
    padding: 20px 16px !important;
    overflow: visible !important;
  }

  /* Report header text: center, no overflow */
  .report-header {
    padding-bottom: 16px !important;
    margin-bottom: 18px !important;
  }

  .report-header h1 {
    font-size: 22px !important;
  }

  .report-header p {
    font-size: 13px !important;
    line-height: 1.6 !important;
  }

  /* Report section headings */
  .report-section h3 {
    font-size: 10px !important;
    margin-bottom: 10px !important;
  }

  /* Wrap the table in a horizontal scroll container */
  .report-section {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
  }

  /* Let the table be as wide as it needs to be — scroll, don't clip */
  .report-section table {
    min-width: 500px !important;
    font-size: 12px !important;
  }

  .report-section table th,
  .report-section table td {
    padding: 8px 10px !important;
    white-space: nowrap !important;
  }

  /* Financial total line */
  .report-section > p {
    font-size: 14px !important;
    margin-top: 10px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   21. TYPOGRAPHY — scale down headings
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  body {
    font-size: 14px !important;
  }

  h1 { font-size: 22px !important; }
  h2 { font-size: 19px !important; }
  h3 { font-size: 16px !important; }
  h4 { font-size: 14px !important; }
}


/* ═══════════════════════════════════════════════════════════
   22. LANDSCAPE ORIENTATION — condensed
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) and (orientation: landscape) {
  .mobile-topnav {
    height: 52px;
  }

  .main-content {
    padding-top: 52px !important;
  }

  .pill-sidebar {
    padding-top: 60px !important;
  }

  .stat-card {
    padding: 12px !important;
  }

  .card-body {
    padding: 12px 14px !important;
  }
}


/* ═══════════════════════════════════════════════════════════
   23. iOS SAFE AREA SUPPORT
   ═══════════════════════════════════════════════════════════ */
@supports (padding: max(0px)) {
  @media (max-width: 768px) {
    .mobile-topnav {
      padding-left: max(16px, env(safe-area-inset-left));
      padding-right: max(16px, env(safe-area-inset-right));
    }

    .pill-sidebar {
      padding-bottom: max(28px, env(safe-area-inset-bottom)) !important;
    }

    .page-content {
      padding-left: max(14px, env(safe-area-inset-left)) !important;
      padding-right: max(14px, env(safe-area-inset-right)) !important;
      padding-bottom: max(40px, env(safe-area-inset-bottom)) !important;
    }
  }
}


/* ═══════════════════════════════════════════════════════════
   24. UTILITY CLASSES (mobile-only visibility)
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .mobile-only  { display: block !important; }
  .desktop-only { display: none  !important; }
}

@media (min-width: 769px) {
  .mobile-only  { display: none  !important; }
  .desktop-only { display: block !important; }
}

</style>
</head>
<body>



<div class="mobile-topnav no-print" id="mobileTopnav">
  <button
    class="mobile-hamburger"
    id="mobileHamburger"
    aria-label="Toggle navigation"
    aria-expanded="false"
    onclick="toggleMobileSidebar()"
  >
    <span></span>
    <span></span>
    <span></span>
  </button>

  <div class="mobile-topnav-brand">
    <svg width="26" height="26" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
      <path d="M24 40 C24 40 6 28 6 16.5 A8.5 8.5 0 0 1 20 10.2 L24 14 L28 10.2 A8.5 8.5 0 0 1 42 16.5 C42 28 24 40 24 40Z"
            stroke="#cad2c5" stroke-width="2.2" fill="rgba(202,210,197,0.15)"/>
      <rect x="28" y="10" width="13" height="4.5" rx="2" fill="rgba(202,210,197,0.9)" stroke="none"/>
      <rect x="32.25" y="5.75" width="4.5" height="13" rx="2" fill="rgba(202,210,197,0.9)" stroke="none"/>
      <rect x="19.5" y="20" width="9" height="13" rx="2.5" fill="rgba(202,210,197,0.88)" stroke="none"/>
      <rect x="20.5" y="17" width="7" height="4" rx="1.5" fill="rgba(202,210,197,0.65)" stroke="none"/>
    </svg>
    <span class="mobile-topnav-brand-name">VaxTrack</span>
  </div>

  <button
    class="mobile-hamburger"
    id="mobileDmBtn"
    aria-label="Toggle dark mode"
    onclick="toggleDarkMode()"
    style="background:rgba(202,210,197,.08);"
  >
    <svg id="mobileDmIcon" width="18" height="18" viewBox="0 0 24 24" fill="none"
         stroke="#cad2c5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
    </svg>
  </button>
</div>

<div class="mobile-sidebar-backdrop no-print" id="mobileSidebarBackdrop" onclick="closeMobileSidebar()"></div>


<nav class="pill-sidebar no-print" id="mainSidebar">

  
  <div class="pill-brand">
    <div class="pill-logo-icon">
      <svg width="32" height="32" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
        <!-- Heart -->
        <path d="M24 40 C24 40 6 28 6 16.5 A8.5 8.5 0 0 1 20 10.2 L24 14 L28 10.2 A8.5 8.5 0 0 1 42 16.5 C42 28 24 40 24 40Z"
              stroke="white" stroke-width="2.2" fill="rgba(255,255,255,0.15)"/>
        <!-- Medical cross -->
        <rect x="28" y="10" width="13" height="4.5" rx="2" fill="rgba(255,255,255,0.9)" stroke="none"/>
        <rect x="32.25" y="5.75" width="4.5" height="13" rx="2" fill="rgba(255,255,255,0.9)" stroke="none"/>
        <!-- Vial body -->
        <rect x="19.5" y="20" width="9" height="13" rx="2.5" fill="rgba(255,255,255,0.88)" stroke="none"/>
        <!-- Vial cap -->
        <rect x="20.5" y="17" width="7" height="4" rx="1.5" fill="rgba(255,255,255,0.65)" stroke="none"/>
        <!-- Vial liquid line -->
        <line x1="19.5" y1="27.5" x2="28.5" y2="27.5" stroke="rgba(82,121,111,0.55)" stroke-width="1.4"/>
        <!-- Mini syringe inside vial -->
        <line x1="22" y1="29.5" x2="26" y2="24.5" stroke="rgba(47,62,70,0.55)" stroke-width="1.2" stroke-linecap="round"/>
      </svg>
    </div>
    <div>
      <div class="pill-brand-name">VaxTrack</div>
      <div class="pill-brand-sub">Pediatric Wellness</div>
    </div>
  </div>

  
  <div class="sidebar-section-label">Navigation</div>
  <div class="pill-nav">
    <?php echo $__env->yieldContent('sidebar-nav'); ?>
  </div>

  <div class="pill-divider"></div>

  
  <div class="pill-dm-row" onclick="toggleDarkMode()" title="Toggle dark mode">
    <span class="icon" id="dmIcon">
      
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
      </svg>
    </span>
    <span class="dm-label">Dark Mode</span>
    <div class="dm-switch"></div>
  </div>

  
  <div class="pill-avatar-row">
    <div class="pill-avatar"><?php echo $__env->yieldContent('user-initials', 'DR'); ?></div>
    <div>
      <div class="pill-user-name"><?php echo $__env->yieldContent('user-name', 'User'); ?></div>
      <div class="pill-user-role"><?php echo $__env->yieldContent('user-role', ''); ?></div>
    </div>
  </div>

  
  <form action="<?php echo e(route('logout')); ?>" method="POST" style="margin:0;">
    <?php echo csrf_field(); ?>
    <button type="submit" class="pill-logout-row">
      <span class="icon">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/>
          <line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
      </span>
      <span class="nav-label">Logout</span>
    </button>
  </form>

</nav>


<div class="main-content" id="mainContent">

  
  <div class="topbar-wrap no-print" id="topbarWrap">
    <div class="topbar">
      <div class="topbar-left">
        <div class="topbar-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></div>
        <span class="topbar-role-pill"><?php echo $__env->yieldContent('sidebar-role', 'Dashboard'); ?></span>
      </div>
      <div class="flex items-center gap-3">
        <span class="topbar-badge"><?php echo e(now()->format('D, M j, Y')); ?></span>
        <div class="topbar-sep"></div>
        <button class="topbar-icon-btn" onclick="toggleDarkMode()" id="topbarDmBtn" title="Toggle dark mode">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" id="topbarDmSvg">
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
          </svg>
        </button>
        <div class="topbar-sep"></div>
        <div class="topbar-user">
          <div class="topbar-avatar"><?php echo $__env->yieldContent('user-initials', 'DR'); ?></div>
          <div>
            <div class="topbar-user-name"><?php echo $__env->yieldContent('user-name', 'User'); ?></div>
            <div class="topbar-user-role"><?php echo $__env->yieldContent('user-role', ''); ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <div class="page-content">
    <?php if(session('success')): ?>
      <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
      <div class="alert alert-error"><?php echo e(session('error')); ?></div>
    <?php endif; ?>
    <?php if($errors->has('login')): ?>
      <div class="alert alert-error"><?php echo e($errors->first('login')); ?></div>
    <?php endif; ?>
    <?php echo $__env->yieldContent('content'); ?>
  </div>
</div>

<?php echo $__env->yieldContent('modals'); ?>

<script>
/* ── Dark Mode ───────────────────────────────────── */
const html = document.documentElement;

const moonPath = `<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>`;
const sunPath  = `<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>`;

function makeSvg(path, size) {
  return `<svg width="${size}" height="${size}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">${path}</svg>`;
}

applyTheme(localStorage.getItem('vaxtrack-theme') || 'light');

function toggleDarkMode() {
  applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
}

function applyTheme(theme) {
  html.setAttribute('data-theme', theme);
  localStorage.setItem('vaxtrack-theme', theme);
  const dark = theme === 'dark';
  const path = dark ? sunPath : moonPath;
  const dmIcon       = document.getElementById('dmIcon');
  const topbarBtn    = document.getElementById('topbarDmBtn');
  const mobileDmIcon = document.getElementById('mobileDmIcon');
  if (dmIcon)       dmIcon.innerHTML       = makeSvg(path, 22);
  if (topbarBtn)    topbarBtn.innerHTML    = makeSvg(path, 18);
  if (mobileDmIcon) mobileDmIcon.innerHTML = (dark ? sunPath : moonPath);
}

/* ── Mobile Sidebar ──────────────────────────────── */
(function () {
  var sidebar   = document.getElementById('mainSidebar');
  var backdrop  = document.getElementById('mobileSidebarBackdrop');
  var hamburger = document.getElementById('mobileHamburger');
  var _open     = false;

  function openMobileSidebar() {
    if (!sidebar) return;
    _open = true;
    sidebar.classList.add('mobile-open');
    if (backdrop)  backdrop.classList.add('active');
    if (hamburger) { hamburger.classList.add('active'); hamburger.setAttribute('aria-expanded', 'true'); }
    document.body.style.overflow = 'hidden';
  }

  function closeMobileSidebar() {
    if (!sidebar) return;
    _open = false;
    sidebar.classList.remove('mobile-open');
    if (backdrop)  backdrop.classList.remove('active');
    if (hamburger) { hamburger.classList.remove('active'); hamburger.setAttribute('aria-expanded', 'false'); }
    document.body.style.overflow = '';
  }

  function toggleMobileSidebar() {
    _open ? closeMobileSidebar() : openMobileSidebar();
  }

  /* Close when a nav link is tapped on mobile */
  if (sidebar) {
    sidebar.querySelectorAll('.nav-item').forEach(function (link) {
      link.addEventListener('click', function () {
        if (window.innerWidth <= 768) closeMobileSidebar();
      });
    });
  }

  /* Escape key closes drawer */
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && _open) closeMobileSidebar();
  });

  /* Clean up on resize to desktop */
  window.addEventListener('resize', function () {
    if (window.innerWidth > 768) {
      closeMobileSidebar();
      document.body.style.overflow = '';
    }
  });

  /* Expose globally for onclick="" attributes */
  window.toggleMobileSidebar = toggleMobileSidebar;
  window.closeMobileSidebar  = closeMobileSidebar;
  window.openMobileSidebar   = openMobileSidebar;
})();
</script>

<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH D:\vacctrack\resources\views/layouts/app.blade.php ENDPATH**/ ?>