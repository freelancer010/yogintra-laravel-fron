@push('styles')
<style>
  .landing-builder-shell { max-width: 1320px; margin: 28px auto; }
  .landing-builder-shell .card { border: 0; border-radius: 18px; box-shadow: 0 14px 40px rgba(31, 41, 55, .08); overflow: hidden; }
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
  @keyframes builder-card-in { from { opacity: 0; transform: translateY(14px) scale(.985); } to { opacity: 1; transform: translateY(0) scale(1); } }
  @keyframes builder-card-out { to { opacity: 0; transform: translateX(25px) scale(.98); } }
  @media (max-width: 767px) { .landing-builder-shell { margin: 0; } .landing-builder-shell > .card > .card-body { padding: 16px; } .section-palette .add-section { flex: 1; } }
  body.landing-builder-focus .main-sidebar { transform: translateX(-100%); transition: transform .25s ease; }
  body.landing-builder-focus .content-wrapper, body.landing-builder-focus .main-header, body.landing-builder-focus .main-footer { margin-left: 0 !important; }
  body.landing-builder-focus .landing-builder-shell { max-width: none; margin: 0; }
  body.landing-builder-focus .landing-builder-shell > .card { border-radius: 0; min-height: calc(100vh - 57px); box-shadow: none; }
  .builder-workspace { display: grid; grid-template-columns: minmax(280px, 330px) minmax(0, 1fr); gap: 22px; align-items: start; }
  .builder-inspector { position: sticky; top: 72px; max-height: calc(100vh - 90px); overflow-y: auto; background: #fff; border: 1px solid #dce8eb; border-radius: 14px; padding: 16px; box-shadow: 0 12px 30px rgba(25,62,71,.08); }
  .builder-inspector-title { display:flex; align-items:center; justify-content:space-between; color:#163e47; font-weight:800; margin-bottom:12px; }
  .builder-inspector .form-group { margin-bottom: 12px; }
  .builder-inspector .form-group[class*="col-"] { width: 100%; max-width: 100%; flex: 0 0 100%; padding-left: 0; padding-right: 0; }
  .builder-inspector .builder-field { margin-bottom: 0; }
  .builder-inspector .form-control { width: 100%; }
  .builder-canvas { min-height: calc(100vh - 160px); background: radial-gradient(circle at top right, #effafa, #f6f8fa 52%, #eef3f4); border: 1px solid #dbe6e9; border-radius: 16px; padding: 20px; }
  .builder-canvas-header { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:16px; }
  .builder-canvas-header h4 { color:#153f48; font-weight:800; margin:0; }
  .builder-canvas .builder-section-panel { margin-top: 0; }
  .live-preview { background:#fff; border:1px solid #d9e6e9; border-radius:14px; overflow:hidden; margin-bottom:18px; box-shadow:0 10px 26px rgba(22,64,72,.07); }
  .live-preview-toolbar { display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:#f5f9fa; border-bottom:1px solid #e2ecee; color:#527079; font-size:12px; font-weight:700; }
  .live-preview-toolbar .preview-dot { width:8px; height:8px; border-radius:50%; background:#30a46c; display:inline-block; margin-right:6px; }
  .live-preview-content { min-height:280px; padding:16px; background:#fff; }
  .preview-section { cursor:pointer; border:1px dashed transparent; border-radius:10px; padding:26px; transition:.2s ease; }
  .preview-section:hover, .preview-section.is-selected { border-color:#16717a; background:#effafa; box-shadow:0 0 0 3px rgba(22,113,122,.08); }
  .preview-section + .preview-section { margin-top:12px; }
  .preview-section-row { display:flex; gap:24px; align-items:center; }
  .preview-section-row.is-right { flex-direction:row-reverse; }
  .preview-section-image, .preview-image-empty { width:42%; min-height:150px; object-fit:cover; border-radius:8px; background:#e9eff1; }
  .preview-image-empty { display:flex; align-items:center; justify-content:center; color:#88a0a7; font-size:13px; }
  .preview-section-copy { flex:1; min-width:0; }
  .preview-section-copy h3 { font-size:22px; color:#183c45; margin:0 0 10px; font-weight:800; }
  .preview-section-copy p { color:#647b82; white-space:pre-line; margin:0; line-height:1.6; }
  .preview-cta { display:inline-block; background:#16717a; color:#fff; border-radius:7px; padding:9px 14px; margin-top:14px; font-size:13px; font-weight:700; }
  .section-layers { border-top:1px solid #e6edef; margin-top:16px; padding-top:14px; }
  .section-layer { width:100%; display:flex; justify-content:space-between; align-items:center; gap:8px; text-align:left; border:1px solid #e0eaed; background:#fff; border-radius:8px; padding:9px 10px; margin:7px 0; color:#355861; font-size:13px; transition:.15s ease; }
  .section-layer:hover, .section-layer.is-selected { border-color:#16717a; color:#0f5962; background:#effafa; }
  .section-layer small { color:#7f9297; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
  @media (max-width: 640px) { .preview-section-row, .preview-section-row.is-right { flex-direction:column; } .preview-section-image, .preview-image-empty { width:100%; } }
  .layout-tools { display:grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap:12px; background:#f7fafb; border-radius:10px; padding:12px; margin-top:6px; }
  .layout-tools label { font-size:11px !important; }
  .range-control { grid-column: span 2; }
  .range-control input[type=range] { width:100%; accent-color:#16717a; }
  .range-value { float:right; font-size:12px; color:#16717a; font-weight:800; }
  .focus-toggle { border: 1px solid rgba(255,255,255,.45); background:rgba(255,255,255,.12); color:#fff; border-radius:8px; padding:7px 11px; font-size:12px; font-weight:700; }
  @media (max-width: 991px) { .builder-workspace { grid-template-columns: 1fr; } .builder-inspector { position:relative; top:auto; max-height:none; } }
</style>
@endpush
