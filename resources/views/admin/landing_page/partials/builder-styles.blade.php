@push('styles')
<style>
  .landing-builder-shell { max-width: 1320px; margin: 28px auto; }
  .builder-toast { position:fixed; z-index:1060; right:26px; top:76px; background:#16717a; color:#fff; border-radius:10px; padding:12px 17px; font-weight:700; box-shadow:0 12px 28px rgba(15,89,98,.28); transition:opacity .3s ease, transform .3s ease; }
  .builder-toast.is-hidden { opacity:0; transform:translateY(-10px); pointer-events:none; }
  .builder-toast-error { background:#b63b47; }
  .landing-builder-shell .card { border: 0; border-radius: 18px; box-shadow: 0 14px 40px rgba(31, 41, 55, .08); overflow: visible; }
  .landing-builder-shell > .card > .card-header { background: linear-gradient(135deg, #132a3a, #1f6a75); color: #fff; padding: 22px 26px; }
  .landing-builder-shell > .card > .card-header h3 { font-size: 21px; font-weight: 700; letter-spacing: -.02em; }
  .landing-builder-shell > .card > .card-body { padding: 28px; background: #f7fafc; }
  .builder-field { background: #fff; border: 1px solid #e7edf2; border-radius: 12px; padding: 15px; margin-bottom: 16px; transition: .2s ease; }
  .builder-field:focus-within { border-color: #38a3a5; box-shadow: 0 0 0 4px rgba(56, 163, 165, .12); }
  .builder-field label { display: block; color: #344054; font-size: 12px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; margin-bottom: 8px; }
  .builder-field .form-control { border: 0; padding: 0; min-height: 30px; box-shadow: none !important; background: transparent; color: #101828; }
  .builder-field textarea.form-control { min-height: 82px; }
  .builder-hero-label { color: #1f6a75; font-size: 12px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; margin: 10px 0 14px; }
  .builder-section-panel { border: 1px solid #d8e5e8; border-radius: 16px; background: #fff; overflow: hidden; margin-top: 26px; }
  .builder-section-panel > .card-header { background: linear-gradient(90deg, #effafa, #fff); padding: 18px 20px; border-bottom: 1px solid #d8e5e8; }
  .builder-section-panel > .card-body { background: #f8fbfc; padding: 20px; min-height: 100px; }
  .section-palette { display: flex; flex-wrap: wrap; gap: 9px; }
  .section-palette .add-section { border: 1px solid #b9dfe0; color: #14616b; background: #fff; padding: 9px 13px; border-radius: 9px; font-weight: 700; font-size: 13px; transition: .2s ease; }
  .section-palette .add-section:hover { transform: translateY(-2px); background: #16717a; border-color: #16717a; color: #fff; box-shadow: 0 8px 16px rgba(22,113,122,.2); }
  .page-builder-section { border: 1px solid #dbe7eb !important; border-radius: 14px !important; overflow: hidden; box-shadow: 0 5px 15px rgba(31,41,55,.05) !important; animation: builder-card-in .35s cubic-bezier(.2,.85,.4,1) both; }
  .page-builder-section > .card-header { background: #fff; border-bottom: 1px solid #edf2f4; padding: 12px 16px; color: #174e59; }
  .page-builder-section > .card-body { background: #fff; padding: 16px; }
  .page-builder-section .btn { border-radius: 7px; }
  .page-builder-section.is-removing { animation: builder-card-out .22s ease forwards; }
  .section-empty { color: #7d8a92; text-align: center; padding: 20px 10px; font-size: 14px; }
  .builder-submit { border: 0; border-radius: 10px; padding: 11px 22px; font-weight: 800; background: linear-gradient(135deg, #16717a, #0f5962); box-shadow: 0 8px 18px rgba(15,89,98,.22); }
  .floating-update-button { position:fixed; right:20px; bottom:20px; z-index:1050; padding:8px 14px; border-radius:999px; font-size:12px; box-shadow:0 8px 18px rgba(15,89,98,.28); }
  @media (max-width:640px) { .floating-update-button { right:16px; bottom:16px; } }
  @keyframes builder-card-in { from { opacity: 0; transform: translateY(14px) scale(.985); } to { opacity: 1; transform: translateY(0) scale(1); } }
  @keyframes builder-card-out { to { opacity: 0; transform: translateX(25px) scale(.98); } }
  @media (max-width: 767px) { .landing-builder-shell { margin: 0; } .landing-builder-shell > .card > .card-body { padding: 16px; } .section-palette .add-section { flex: 1; } }
  body.landing-builder-focus .main-sidebar { transform: translateX(-100%); transition: transform .25s ease; }
  body.landing-builder-focus .content-wrapper, body.landing-builder-focus .main-header, body.landing-builder-focus .main-footer { margin-left: 0 !important; }
  body.landing-builder-focus .landing-builder-shell { max-width: none; margin: 0; }
  body.landing-builder-focus .landing-builder-shell > .card { border-radius: 0; min-height: calc(100vh - 57px); box-shadow: none; }
  .builder-workspace { display: grid; grid-template-columns: minmax(0, 1fr) 280px; gap: 18px; align-items: start; }
  .builder-inspector { position: sticky; top: 72px; height: calc(100vh - 92px); min-height: 0; overflow-y: auto; overflow-x: hidden; scrollbar-gutter: stable; background: #fff; border: 1px solid #dce8eb; border-radius: 14px; padding: 16px; box-shadow: 0 12px 30px rgba(25,62,71,.08); }
  .builder-inspector::-webkit-scrollbar { width:7px; }
  .builder-inspector::-webkit-scrollbar-thumb { background:#aac5ca; border-radius:999px; }
  .builder-inspector-title { display:flex; align-items:center; justify-content:space-between; color:#163e47; font-weight:800; margin-bottom:12px; }
  .builder-inspector-title .builder-inspector-submit { position:static; margin-left:auto; padding:7px 10px; border-radius:7px; font-size:12px; box-shadow:none; }
  .builder-inspector .form-group { margin-bottom: 12px; }
  .builder-inspector .form-group[class*="col-"] { width: 100%; max-width: 100%; flex: 0 0 100%; padding-left: 0; padding-right: 0; }
  .builder-inspector .builder-field { margin-bottom: 0; }
  .builder-inspector .form-control { width: 100%; }
  .builder-canvas { min-height: calc(100vh - 160px); background: radial-gradient(circle at top right, #effafa, #f6f8fa 52%, #eef3f4); border: 1px solid #dbe6e9; border-radius: 16px; padding: 20px; }
  .hero-editor { margin:0 0 18px; padding:16px; border:1px solid #c5e1e4; border-radius:13px; background:linear-gradient(135deg,#fff,#eefafa); }
  .hero-editor-heading { display:flex; justify-content:space-between; align-items:start; gap:12px; margin-bottom:13px; color:#163e47; }
  .hero-editor-heading strong { display:block; font-size:16px; }
  .hero-editor-heading small { display:block; margin-top:3px; color:#607b83; }
  .hero-editor-heading > span { border-radius:999px; padding:4px 9px; color:#14616b; background:#dff4f4; font-size:11px; font-weight:800; text-transform:uppercase; }
  .hero-editor-fields { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:12px; }
  .hero-persistence-fields { display:none; }
  .hero-canvas-stage { min-height:330px; position:relative; display:flex; align-items:center; justify-content:flex-end; padding:34px; background:#173e47 center/cover no-repeat; border-radius:10px; overflow:hidden; color:#fff; }
  .hero-image-action { position:absolute; z-index:1; left:16px; bottom:16px; border:0; border-radius:999px; padding:8px 12px; background:rgba(0,0,0,.7); color:#fff; cursor:pointer; font-size:11px; font-weight:700; }
  .hero-canvas-copy { width:min(54%, 560px); display:flex; flex-direction:column; justify-content:center; padding:28px; background:rgba(28,23,19,.84); border-radius:10px; text-align:center; }
  .hero-canvas-copy small { color:#a9d2d5; margin-bottom:8px; }
  .hero-canvas-copy h2 { margin:0 0 10px; color:#fff; font-size:30px; font-weight:800; }
  .hero-canvas-copy p { margin:0; color:#d8eaeb; font-size:16px; }
  .hero-canvas-copy [contenteditable]:focus { outline:2px solid #64c6cc; outline-offset:4px; border-radius:4px; }
  @media (max-width:640px) { .hero-canvas-stage { min-height:280px; padding:20px; } .hero-canvas-copy { width:100%; } }
  .hero-editor-fields .form-group { margin:0; padding:0; max-width:none; }
  .hero-editor-fields .form-group:first-child { grid-column:span 2; text-align:left !important; border-bottom:1px solid #d9e9eb; padding-bottom:12px; }
  .hero-editor-fields #preview-image { max-width:260px; width:auto !important; max-height:150px; object-fit:cover; border-radius:8px; display:block; margin:0 0 9px !important; }
  .hero-editor-fields input[type=file] { width:100% !important; margin:0 !important; }
  .canvas-add-bar { display:flex; justify-content:center; padding:12px 10px; margin-bottom:12px; }
  .canvas-add-bar button { border:1px solid #16717a; color:#fff; background:#16717a; border-radius:999px; padding:10px 18px; font-size:13px; font-weight:800; box-shadow:0 7px 16px rgba(22,113,122,.18); }
  .canvas-add-bar button:hover { background:#0f5962; transform:translateY(-1px); }
  .template-picker { display:none; position:fixed; z-index:2000; inset:0; align-items:center; justify-content:center; padding:20px; }
  .template-picker.is-open { display:flex; }
  .template-picker-backdrop { position:absolute; inset:0; background:rgba(11,37,43,.52); backdrop-filter:blur(3px); }
  .template-picker-dialog { position:relative; z-index:1; width:min(720px,100%); padding:25px; border-radius:16px; background:#fff; box-shadow:0 24px 70px rgba(0,0,0,.25); }
  .template-picker-dialog h3 { margin:0 0 5px; color:#153f48; font-size:22px; }
  .template-picker-dialog > p { margin:0 0 20px; color:#6a8086; }
  .template-picker-close { position:absolute; top:11px; right:13px; border:0; background:none; color:#5d7278; font-size:28px; line-height:1; }
  .template-picker-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:12px; }
  .template-picker-grid button { min-height:132px; display:flex; flex-direction:column; align-items:flex-start; gap:5px; border:1px solid #d5e5e8; border-radius:11px; padding:15px; background:#fff; color:#153f48; text-align:left; transition:.18s ease; }
  .template-picker-grid button:hover { border-color:#16717a; background:#effafa; transform:translateY(-2px); box-shadow:0 10px 18px rgba(22,113,122,.11); }
  .template-picker-grid b { color:#16717a; font-size:25px; line-height:1; }
  .template-picker-grid strong { font-size:14px; }
  .template-picker-grid small { color:#71878c; font-size:11px; }
  @media(max-width:600px) { .template-picker-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } }
  .visual-style-panel { border-top:1px solid #dce8eb; margin-top:14px; padding-top:14px; }
  .visual-style-panel label { display:block; color:#506a72; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:.05em; margin:13px 0 5px; }
  .delete-selected-section { width:100%; border:1px solid #ef9ca2; background:#fff; color:#c63b48; border-radius:7px; padding:7px 10px; font-size:12px; font-weight:700; }
  .delete-selected-section:hover { background:#fff1f2; }
  .apply-section-spacing { width:100%; margin-top:16px; border:1px solid #8bc7cb; background:#effafa; color:#14616b; border-radius:7px; padding:8px 10px; font-size:12px; font-weight:800; }
  .apply-section-spacing:hover { background:#dff4f4; }
  .visual-style-panel label span { float:right; color:#16717a; }
  .visual-style-panel input[type=color] { width:100%; height:34px; border:1px solid #d9e6e9; border-radius:7px; padding:3px; background:#fff; }
  .visual-style-panel select { width:100%; min-height:34px; border:1px solid #d9e6e9; border-radius:7px; padding:5px 7px; background:#fff; font-size:12px; }
  .visual-style-panel input[type=range] { width:100%; accent-color:#16717a; }
  .builder-canvas-header { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:16px; }
  .builder-canvas-header h4 { color:#153f48; font-weight:800; margin:0; }
  .builder-settings-button { display:inline-flex; align-items:center; gap:8px; border:0; border-radius:9px; padding:10px 14px; background:linear-gradient(135deg,#0f7a84,#14616c); color:#fff; font-weight:800; box-shadow:0 7px 16px rgba(15,122,132,.24); transition:transform .18s ease, box-shadow .18s ease, background .18s ease; }
  .builder-settings-button:hover, .builder-settings-button:focus { color:#fff; background:linear-gradient(135deg,#116a74,#0b5660); box-shadow:0 10px 22px rgba(15,122,132,.32); transform:translateY(-1px); outline:0; }
  .builder-settings-button .fa { font-size:15px; }
  .builder-canvas .builder-section-panel { margin-top: 0; }
  .live-preview { background:#fff; border:1px solid #d9e6e9; border-radius:14px; overflow:hidden; margin-bottom:18px; box-shadow:0 10px 26px rgba(22,64,72,.07); }
  .live-preview-toolbar { display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:#f5f9fa; border-bottom:1px solid #e2ecee; color:#527079; font-size:12px; font-weight:700; }
  .live-preview-toolbar .preview-dot { width:8px; height:8px; border-radius:50%; background:#30a46c; display:inline-block; margin-right:6px; }
  .live-preview-toolbar .is-dirty .preview-dot { background:#e59b28; }
  .builder-device-controls { display:flex; gap:4px; }
  .builder-device-controls button { border:1px solid #d6e5e8; border-radius:5px; background:#fff; color:#587178; padding:4px 7px; font-size:11px; }
  .builder-device-controls button.is-active { border-color:#16717a; background:#eaf6f7; color:#12626c; font-weight:700; }
  .live-preview[data-device="tablet"] { max-width:820px; margin:0 auto; }
  .live-preview[data-device="mobile"] { max-width:430px; margin:0 auto; }
  .live-preview[data-device="mobile"] .preview-section-row, .live-preview[data-device="tablet"] .preview-section-row { flex-direction:column; }
  .live-preview[data-device="mobile"] .preview-feature-grid { grid-template-columns:1fr !important; }
  .builder-element-toolbar { display:none; position:fixed; z-index:2100; gap:2px; padding:4px; border:1px solid #cfe0e3; border-radius:8px; background:#173e47; box-shadow:0 6px 18px rgba(16,47,54,.25); }
  .builder-element-toolbar.is-open { display:flex; }
  .builder-element-toolbar button { border:0; border-radius:5px; padding:5px 7px; background:transparent; color:#fff; font-size:11px; cursor:pointer; }
  .builder-element-toolbar button:hover { background:#286773; }
  .live-preview-content { min-height:280px; display:flex; flex-direction:column; gap:0; padding:0; background:#fff; overflow:hidden; }
  .preview-section { cursor:pointer; position:relative; border:1px dashed transparent; border-radius:10px; padding:26px; transition:.2s ease; min-height:72px; }
  .preview-section:hover, .preview-section.is-selected { border-color:#16717a; background:#effafa; box-shadow:0 0 0 3px rgba(22,113,122,.18); }
  .preview-section + .preview-section { margin-top:0; }
  .preview-section-row { display:flex; gap:24px; align-items:center; }
  .preview-section-row.is-right { flex-direction:row-reverse; }
  .preview-image-frame { position:relative; flex:0 0 auto; min-height:150px; }
  .preview-image-frame::after { content:""; position:absolute; inset:0; border-radius:8px; background:rgba(8,32,38,.46); opacity:0; transition:opacity .18s ease; pointer-events:none; }
  .preview-image-frame:hover::after { opacity:1; }
  .preview-image-frame.is-selected-target { outline:3px solid #16717a; outline-offset:4px; border-radius:8px; }
  .preview-section-image, .preview-image-empty { width:100%; height:100%; min-height:150px; object-fit:cover; border-radius:8px; background:#e9eff1; }
  .preview-image-empty { display:flex; align-items:center; justify-content:center; border:0; color:#88a0a7; font-size:13px; cursor:pointer; }
  .preview-image-empty:hover { background:#dcecee; color:#16717a; }
  .preview-image-action { position:absolute; z-index:1; left:50%; top:50%; opacity:0; transform:translate(-50%,-45%); border:0; border-radius:999px; padding:8px 12px; background:rgba(12,47,55,.9); color:#fff; font-size:12px; font-weight:800; transition:.18s ease; white-space:nowrap; }
  .preview-image-frame:hover .preview-image-action { opacity:1; transform:translate(-50%,-50%); }
  .preview-section-copy { flex:1; min-width:0; }
  .live-preview .preview-section-copy, .live-preview .preview-grid-heading, .live-preview .preview-section [data-preview-field] { text-align: inherit !important; }
  .preview-swap-button { position:absolute; z-index:3; top:12px; right:12px; opacity:0; transform:translateY(-5px); border:0; border-radius:999px; padding:7px 11px; color:#fff; background:#14616b; box-shadow:0 6px 14px rgba(15,89,98,.26); font-size:12px; font-weight:800; transition:.18s ease; }
  .preview-section:hover .preview-swap-button, .preview-section.is-selected .preview-swap-button { opacity:1; transform:translateY(0); }
  .preview-swap-button:hover { background:#0f5962; }
  .preview-section-copy h3 { font-size:22px; color:#183c45; margin:0 0 10px; font-weight:800; }
  .preview-section-copy p { white-space:pre-line; margin:0; line-height:1.6; }
  .preview-section [contenteditable]:focus, .preview-section [contenteditable].is-editing { outline:2px solid #35a5b0; outline-offset:4px; border-radius:4px; }
  .preview-section [contenteditable]:hover { outline:1px dashed #35a5b0; outline-offset:4px; border-radius:4px; }
  .preview-section [data-preview-field], .preview-section [data-preview-extra], .preview-section [data-preview-extra-list], .preview-section [data-preview-column-target] { cursor:pointer; transition:outline-color .15s ease, background .15s ease; }
  .preview-section [data-preview-field]:hover, .preview-section [data-preview-extra]:hover, .preview-section [data-preview-extra-list]:hover, .preview-section [data-preview-column-target]:hover { outline:1px dashed #16717a; outline-offset:5px; border-radius:5px; background:rgba(22,113,122,.06); }
  .preview-section .is-selected-target { outline:2px solid #16717a !important; outline-offset:5px; border-radius:5px; background:rgba(22,113,122,.09); }
  .builder-link-popup { display:none; position:absolute; z-index:1100; width:290px; padding:12px; border:1px solid #b9dfe0; border-radius:10px; background:#fff; box-shadow:0 14px 32px rgba(14,60,68,.22); }
  .builder-link-popup.is-open { display:grid; gap:8px; }
  .builder-link-popup label { display:grid; gap:4px; font-size:12px; font-weight:800; color:#355861; }
  .builder-link-popup input[type=url] { width:100%; border:1px solid #c9dde1; border-radius:6px; padding:7px 8px; font-size:12px; }
  .builder-link-popup .builder-link-new-tab { display:block; font-weight:600; }
  .builder-link-popup button { border:0; border-radius:6px; padding:7px 9px; font-size:12px; font-weight:800; background:#16717a; color:#fff; }
  .builder-link-popup .builder-link-cancel { background:#e8f0f2; color:#355861; }
  ::highlight(builder-link-selection) { background:rgba(31, 122, 137, .28); color:inherit; }
  .builder-link-actions { display:none; position:fixed; z-index:1101; }
  .builder-link-actions.is-open { display:block; }
  .builder-link-actions button { display:inline-flex; align-items:center; gap:5px; border:0; border-radius:6px; padding:6px 9px; background:#b83d4c; color:#fff; box-shadow:0 6px 14px rgba(94,24,34,.24); font-size:11px; font-weight:800; white-space:nowrap; }
  .builder-link-actions button:hover { background:#982c3a; }
  .live-preview-content [contenteditable] a { color:#147bd1; text-decoration:underline; text-decoration-thickness:1px; text-underline-offset:2px; }
  .section-background-media { display:grid; gap:7px; margin:10px 0; padding:10px; border:1px solid #d8e7e9; border-radius:8px; background:#f7fbfc; }
  .section-background-media small { color:#668087; font-size:11px; }
  .background-mode-toggle { display:grid; grid-template-columns:1fr 1fr; gap:4px; padding:3px; border-radius:8px; background:#deecee; }
  .background-image-options input[data-background-image] { width:100%; padding:4px; border:1px dashed #7bb1b7; border-radius:8px; background:#fff; color:#496b73; font-size:12px; cursor:pointer; }
  .background-image-options input[data-background-image]::file-selector-button { margin-right:9px; border:0; border-radius:6px; padding:8px 11px; background:#16717a; color:#fff; font-weight:800; font-size:12px; cursor:pointer; transition:.16s ease; }
  .background-image-options input[data-background-image]::file-selector-button:hover { background:#0f5962; }
  .background-upload-error { display:block; margin-top:5px; color:#b63845 !important; font-size:11px; font-weight:700; }
  .background-mode-toggle button { border:0; border-radius:6px; padding:7px; background:transparent; color:#47666d; font-size:12px; font-weight:800; }
  .background-mode-toggle button.is-active { background:#16717a; color:#fff; box-shadow:0 3px 8px rgba(15,89,98,.2); }
  .background-image-options { display:grid; gap:7px; }
  .background-image-options.is-hidden { display:none; }
  .builder-toggle { display:flex !important; align-items:center; gap:7px; font-size:12px !important; }
  .builder-switch { display:flex !important; align-items:center; gap:8px; margin:4px 0 0 !important; color:#31545c; font-size:12px !important; cursor:pointer; }
  .builder-switch input { position:absolute; opacity:0; pointer-events:none; }
  .builder-switch-track { position:relative; width:38px; height:22px; border-radius:999px; background:#b7c8cc; box-shadow:inset 0 0 0 1px rgba(15,76,86,.12); transition:.18s ease; }
  .builder-switch-track::after { content:''; position:absolute; top:3px; left:3px; width:16px; height:16px; border-radius:50%; background:#fff; box-shadow:0 1px 3px rgba(0,0,0,.22); transition:.18s ease; }
  .builder-switch input:checked + .builder-switch-track { background:#16717a; }
  .builder-switch input:checked + .builder-switch-track::after { transform:translateX(16px); }
  .preview-image-hero .preview-section-image { display:block; width:100%; height:auto; min-height:0; object-fit:contain; }
  .preview-image-hero .preview-image-empty { width:100%; min-height:260px; }
  .preview-image-hero { display:flex; justify-content:center; }
  .preview-image-hero .preview-image-frame { max-width:100%; }
  .visual-style-panel input[type=file] { width:100%; font-size:12px; }
  .image-help { display:block; margin-top:5px; color:#6b7f85; font-size:11px; }
  .image-size-progress { height:7px; overflow:hidden; margin:8px 0 4px; border-radius:999px; background:#dce9eb; }
  .image-size-progress span { display:block; height:100%; border-radius:inherit; background:linear-gradient(90deg,#16717a,#49afb2); transition:width .12s ease; }
  .text-format-controls { display:flex; align-items:center; gap:6px; margin:14px 0 4px; padding-top:12px; border-top:1px solid #e4edef; }
  .text-format-controls span { margin-right:auto; color:#56727a; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:.04em; }
  .text-format-controls button { width:32px; height:30px; border:1px solid #cbdde1; border-radius:6px; background:#fff; color:#174b55; }
  .text-format-controls button:hover, .text-format-controls button.is-active { border-color:#16717a; color:#fff; background:#16717a; }
  .block-editor { border-top:1px solid #e4edef; margin-top:14px; padding-top:2px; }
  .feature-block-control { display:grid; grid-template-columns:42px 1fr; gap:6px; padding:9px; margin-bottom:8px; background:#f6fafb; border:1px solid #dfebed; border-radius:8px; }
  .feature-block-image { grid-column:span 2; display:flex; align-items:center; gap:8px; }
  .feature-block-image img, .feature-block-image b { width:38px; height:38px; object-fit:cover; border-radius:7px; background:#e5f0f2; color:#16717a; display:grid; place-items:center; }
  .feature-block-image button { width:auto; padding:5px 8px; }
  .feature-block-control input, .feature-block-control textarea { width:100%; border:1px solid #cfdfe3; border-radius:5px; padding:6px; font-size:12px; }
  .feature-block-control textarea, .feature-block-control button { grid-column:span 2; }
  .column-control { grid-template-columns:1fr; }
  .column-control > * { grid-column:1 !important; min-width:0; }
  .column-control input, .column-control textarea, .column-control select { width:100%; }
  .column-support-controls { display:grid; gap:5px; margin-top:4px; }
  .column-support-controls label { margin:3px 0 0; color:#58757d; font-size:10px; font-weight:800; text-transform:uppercase; }
  .extra-element-control label { margin:3px 0 -3px; color:#58757d; font-size:10px; font-weight:800; text-transform:uppercase; }
  .extra-element-actions { display:flex; gap:8px; margin-top:8px; flex-wrap:wrap; }
  .extra-element-actions button { flex:1 1 120px; border:1px solid #16717a; border-radius:7px; padding:8px; background:#fff; color:#14616b; font-size:12px; font-weight:800; }
  .extra-element-actions button:hover { background:#16717a; color:#fff; }
  .feature-block-control button, .add-feature-block { border:1px solid #9cc9ce; color:#14616b; background:#fff; border-radius:6px; font-size:11px; padding:5px 7px; }
  .preview-grid-heading { text-align:center; max-width:900px; margin:0 auto 24px; }
  .preview-grid-heading h3 { margin:0 0 10px; font-weight:800; }
  .preview-grid-heading p { margin:0; }
  .preview-builder-list { padding-left:1.4em; margin:10px 0; line-height:1.6; }
  .preview-builder-list li + li { margin-top:var(--list-item-gap, 8px); }
  .preview-feature-grid { display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); gap:20px 34px; }
  .preview-feature { display:flex; gap:13px; align-items:flex-start; padding:12px; border-radius:8px; }
  .preview-feature.is-stacked { flex-direction:column; align-items:center; text-align:center; }
  /* Empty-column sections inherit the selected section alignment. Unlike feature
     cards, their list and supporting text must stretch across the column so the
     editor matches the public page's normal left-aligned flow. */
  .preview-custom-columns .preview-feature.is-stacked { align-items:stretch; }
  .preview-custom-columns .preview-builder-list,
  .preview-custom-columns .preview-column-support { align-self:stretch; }
  .preview-custom-columns .preview-cta { align-self:center; width:auto; border:0; border-radius:6px; padding:16px 29px; background:#f5a12b; color:#fff; cursor:pointer; font-size:15px; font-weight:700; box-shadow:0 5px 12px rgba(167,97,7,.22); }
  .preview-custom-columns-wrap { position:relative; }
  .preview-column-divider { position:absolute; z-index:3; top:50%; right:8px; width:30px; height:30px; transform:translateY(-50%); border:1px solid #16717a; border-radius:50%; background:#fff; color:#16717a; font-size:21px; line-height:1; box-shadow:0 3px 11px rgba(22,113,122,.18); opacity:0; cursor:pointer; transition:.16s ease; }
  .preview-custom-columns-wrap:hover .preview-column-divider, .preview-section:focus-within .preview-column-divider { opacity:1; }
  .preview-section-actions { position:absolute; z-index:5; right:14px; bottom:12px; opacity:0; transform:translateY(5px); transition:.16s ease; }
  .preview-section:hover .preview-section-actions, .preview-section:focus-within .preview-section-actions, .preview-section-actions.is-open { opacity:1; transform:translateY(0); }
  .preview-section-delete { position:absolute; z-index:6; top:9px; right:9px; width:28px; height:28px; border:1px solid #e6a7ae; border-radius:50%; background:#fff; color:#bd3542; font-size:19px; line-height:1; opacity:0; cursor:pointer; transition:.16s ease; }
  .preview-section:hover .preview-section-delete, .preview-section.is-selected .preview-section-delete { opacity:1; }
  .preview-section-delete:hover { border-color:#bd3542; background:#bd3542; color:#fff; }
  .preview-section-add { border:0; border-radius:999px; padding:8px 12px; background:#16717a; color:#fff; font-size:12px; font-weight:700; cursor:pointer; box-shadow:0 4px 12px rgba(22,113,122,.24); }
  .preview-section-add-menu { display:none; position:absolute; right:0; bottom:calc(100% + 8px); min-width:150px; padding:7px; border:1px solid #d5e4e7; border-radius:9px; background:#fff; box-shadow:0 10px 24px rgba(22,60,69,.16); }
  .preview-section-actions.is-open .preview-section-add-menu { display:grid; gap:4px; }
  .preview-section-add-menu small { padding:4px 6px; color:#71868c; font-size:11px; }
  .preview-section-add-menu button { border:0; border-radius:5px; padding:7px 8px; background:transparent; color:#244b54; text-align:left; font-size:12px; cursor:pointer; }
  .preview-section-add-menu button:hover { background:#eaf6f7; color:#12626c; }
  .preview-column-stack { position:relative; min-height:100px; }
  .preview-column-add { align-self:flex-start; border:1px dashed #91bbc0; border-radius:6px; padding:5px 7px; background:#fff; color:#16717a; font-size:11px; opacity:0; cursor:pointer; transition:.16s ease; }
  .preview-column-stack:hover .preview-column-add, .preview-column-stack:focus-within .preview-column-add { opacity:1; }
  .preview-column-remove { position:absolute; top:7px; right:7px; width:24px; height:24px; border:1px solid #e3aeb4; border-radius:50%; background:#fff; color:#bc3744; font-size:17px; line-height:1; opacity:0; cursor:pointer; transition:.16s ease; }
  .preview-column-stack:hover .preview-column-remove, .preview-column-stack:focus-within .preview-column-remove { opacity:1; }
  .preview-column-remove:hover { background:#bc3744; color:#fff; }
  .preview-empty-column-wrap { position:relative; min-height:94px; display:grid; place-items:center; }
  .preview-empty-column { border:1px dashed #5a9fa8; border-radius:7px; padding:9px 12px; background:#fff; color:#16717a; font-size:12px; font-weight:700; cursor:pointer; }
  .preview-empty-column-menu { display:none; position:absolute; top:calc(50% + 28px); z-index:6; grid-template-columns:repeat(3,auto); gap:4px; padding:5px; border:1px solid #d4e4e6; border-radius:8px; background:#fff; box-shadow:0 8px 18px rgba(22,60,69,.16); }
  .preview-empty-column-wrap.is-open .preview-empty-column-menu { display:grid; }
  .preview-empty-column-menu button { border:0; border-radius:5px; padding:6px 8px; background:#edf7f8; color:#17636d; font-size:11px; cursor:pointer; }
  .column-spacing-controls { display:grid; gap:6px; margin-top:12px; padding-top:10px; border-top:1px solid #dce8ea; }
  .column-spacing-controls strong { color:#42636b; font-size:12px; }
  .builder-range-number { display:grid; grid-template-columns:minmax(0,1fr) 58px; gap:7px; align-items:center; }
  .builder-range-number input[type="number"] { min-width:0; padding:5px; text-align:center; }
  /* Column content is edited directly on the canvas. The inspector only keeps
     the structural Section division control to avoid duplicating every column. */
  .visual-style-panel .column-control { display:none; }
  .preview-feature:hover { background:rgba(22,113,122,.06); }
  .preview-feature b { font-size:38px; line-height:1; color:#16717a; }
  .preview-feature img { width:82px; height:82px; object-fit:contain; border-radius:8px; }
  .preview-feature h4 { margin:0 0 5px; color:#183c45; font-size:17px; }
  .preview-feature p { margin:0; color:#647b82; line-height:1.5; }
  .preview-cta { display:inline-block; background:#16717a; color:#fff; border-radius:7px; padding:9px 14px; margin-top:14px; font-size:13px; font-weight:700; }
  .section-layers { border-top:1px solid #e6edef; margin-top:16px; padding-top:14px; }
  .section-layer { width:100%; display:flex; justify-content:space-between; align-items:center; gap:8px; text-align:left; border:1px solid #e0eaed; background:#fff; border-radius:8px; padding:9px 10px; margin:7px 0; color:#355861; font-size:13px; transition:.15s ease; }
  .section-layer:hover, .section-layer.is-selected { border-color:#16717a; color:#0f5962; background:#effafa; }
  .section-tree.is-dragging { opacity:.45; }
  .section-tree.is-drag-over .section-layer { border-style:dashed; border-color:#16717a; background:#e2f4f5; box-shadow:0 0 0 2px rgba(22,113,122,.18); }
  .section-layer[draggable="true"] { cursor:grab; }
  .section-layer[draggable="true"]:active { cursor:grabbing; }
  .section-layer small { color:#7f9297; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
  .section-tree { margin:7px 0; }
  .section-tree-header { display:flex; align-items:stretch; gap:5px; }
  .section-tree-header .section-layer { flex:1; }
  .section-tree-toggle { width:32px; border:1px solid #e0eaed; border-radius:8px; background:#fff; color:#41656d; font-size:15px; }
  .section-tree-duplicate, .section-tree-delete { width:28px; border:1px solid #e0eaed; border-radius:8px; background:#fff; color:#41656d; font-size:14px; }
  .section-tree-duplicate:hover { color:#16717a; border-color:#16717a; }
  .section-tree-delete:hover { color:#c63842; border-color:#c63842; }
  .section-tree-toggle:hover { border-color:#16717a; color:#16717a; }
  .section-tree.is-collapsed .section-tree-children { display:none; }
  .section-tree .section-layer { margin:0; }
  .section-tree-children { margin:5px 0 0 19px; padding-left:10px; border-left:1px solid #d7e5e8; }
  .section-tree-child { display:block; width:100%; border:0; padding:5px 2px; background:transparent; color:#668087; text-align:left; font-size:12px; }
  .section-tree-child:hover, .section-tree-child.is-selected { color:#14616b; font-weight:700; }
  @media (max-width: 640px) { .preview-section-row, .preview-section-row.is-right { flex-direction:column; } .preview-section-image, .preview-image-empty { width:100%; } .preview-feature-grid { grid-template-columns:1fr; } }
  .layout-tools { display:grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap:12px; background:#f7fafb; border-radius:10px; padding:12px; margin-top:6px; }
  .layout-tools label { font-size:11px !important; }
  .range-control { grid-column: span 2; }
  .range-control input[type=range] { width:100%; accent-color:#16717a; }
  .range-value { float:right; font-size:12px; color:#16717a; font-weight:800; }
  .focus-toggle { border: 1px solid rgba(255,255,255,.45); background:rgba(255,255,255,.12); color:#fff; border-radius:8px; padding:7px 11px; font-size:12px; font-weight:700; }
  .landing-page-header { width:100%; }
  .landing-page-header-actions { margin-left:auto; white-space:nowrap; }
  @media (max-width: 767px) { .landing-page-header { align-items:flex-start !important; flex-direction:column; gap:10px; } .landing-page-header-actions { width:100%; flex-wrap:wrap; justify-content:flex-start !important; white-space:normal; gap:7px; } .landing-page-header-actions .mr-2 { margin-right:0 !important; } }
  @media (max-width: 991px) { .builder-workspace { grid-template-columns: 1fr; } .builder-inspector { position:relative; top:auto; height:auto; min-height:0; max-height:none; overflow:visible; } }
</style>
@endpush
