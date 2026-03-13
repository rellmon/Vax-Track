{{-- ╔══════════════════════════════════════════════════════╗ --}}
{{-- ║   MOBILE RESPONSIVE ENHANCEMENTS — VAXTRACK          ║ --}}
{{-- ║   Scoped to @media (max-width: 768px) only           ║ --}}
{{-- ║   Desktop / tablet UI is completely untouched        ║ --}}
{{-- ╚══════════════════════════════════════════════════════╝ --}}
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
   11. MODALS — full-screen on small phones
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .modal-overlay {
    padding: 12px !important;
    align-items: flex-end !important; /* sheet slides up from bottom */
  }

  .modal {
    border-radius: 24px 24px 16px 16px !important;
    max-height: 92dvh !important;
    width: 100% !important;
  }

  .modal-sm,
  .modal-md,
  .modal-lg {
    max-width: 100% !important;
  }

  .modal-header {
    padding: 20px 20px 16px !important;
  }

  .modal-title {
    font-size: 20px !important;
  }

  .modal-body {
    padding: 16px 20px !important;
    max-height: calc(92dvh - 160px) !important;
  }

  .modal-footer {
    padding: 14px 20px !important;
    flex-direction: column !important;
    gap: 8px !important;
  }

  .modal-footer .btn {
    width: 100% !important;
  }

  /* Custom modals (records page) */
  .custom-modal-content {
    width: 95% !important;
    max-width: 95% !important;
    border-radius: 22px !important;
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