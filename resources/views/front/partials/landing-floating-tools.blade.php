<style>
  .landing-float{position:fixed;right:20px;display:grid;place-items:center;width:54px;height:54px;border:0;border-radius:50%;color:#fff!important;text-decoration:none;box-shadow:0 5px 16px rgba(0,0,0,.28);z-index:9999;cursor:pointer}
  .landing-float-enquiry{bottom:88px;background:#1677ea;font-size:21px}.landing-float-whatsapp{bottom:20px;background:#16be45}.landing-float-whatsapp i{font-size:26px}.landing-float-whatsapp .sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
  .landing-float:hover{transform:translateY(-2px)}
  .tooltip-popup{position:fixed;right:82px;bottom:98px;padding:10px 14px;border-radius:7px;background:#263238;color:#fff;font:600 13px/1.2 Arial,sans-serif;opacity:0;pointer-events:none;transition:opacity .2s;z-index:9998}.tooltip-popup.show{opacity:1}
  #messagePopup{position:fixed;right:20px;bottom:154px;display:none;width:min(410px,calc(100vw - 32px));max-height:calc(100vh - 180px);overflow:auto;padding:26px;background:#fff;border-radius:14px;box-shadow:0 12px 38px rgba(0,0,0,.3);z-index:10000;color:#183c45;font-family:Arial,sans-serif}
  #messagePopup .close-btn{position:absolute;top:8px;right:12px;border:0;background:transparent;font-size:28px;line-height:1;cursor:pointer}#messagePopup .popup-title{margin:0 0 18px;text-align:center;font-size:23px;font-weight:600}
  #messagePopup .form-step{display:none}#messagePopup .form-step.active{display:block}#messagePopup .form-group{margin-bottom:14px}#messagePopup label{display:block;margin-bottom:5px;font-size:14px;font-weight:600}
  #messagePopup .form-control{display:block;width:100%;min-height:44px;padding:9px 11px;border:1px solid #cbd8d9;border-radius:7px;background:#fff;color:#183c45;font:14px/1.4 Arial,sans-serif}#messagePopup textarea.form-control{min-height:90px;resize:vertical}
  #messagePopup .btn{min-height:42px;padding:9px 17px;border:1px solid #0b6970;border-radius:7px;font-weight:700;cursor:pointer}#messagePopup .btn-primary{background:#0b6970;color:#fff}#messagePopup .btn-light{margin-right:8px;background:#fff;color:#183c45}
  #messagePopup .d-flex{display:flex}#messagePopup .justify-content-end{justify-content:flex-end}#messagePopup .is-invalid{border-color:#c9302c}.invalid-feedback{color:#c9302c;font-size:12px}
  @media(max-width:680px){.landing-float{right:16px;width:50px;height:50px}.landing-float-enquiry{bottom:82px}.landing-float-whatsapp{bottom:18px}#messagePopup{right:16px;bottom:144px;max-height:calc(100vh - 165px);padding:22px 18px}}
</style>

<button id="messageIcon" class="landing-float landing-float-enquiry" type="button" aria-label="Open enquiry form"><i class="fa fa-comment" aria-hidden="true"></i></button>
<div class="tooltip-popup">Enquire with us!</div>
<a class="landing-float landing-float-whatsapp" href="https://wa.me/919867291573" target="_blank" rel="noopener noreferrer" aria-label="Chat with YogIntra on WhatsApp" title="Chat with YogIntra on WhatsApp"><i class="fa fa-whatsapp" aria-hidden="true"></i><span class="sr-only">Chat with YogIntra on WhatsApp</span></a>

<div id="messagePopup" role="dialog" aria-modal="true" aria-labelledby="landingEnquiryTitle">
  <button class="close-btn" type="button" onclick="toggleMessagePopup()" aria-label="Close enquiry form">&times;</button>
  <div class="popup-content">
    <div id="landingEnquiryTitle" class="popup-title">Get In Touch</div>
    <x-multi-step-form :form-type="'embed'" :source="$source" />
  </div>
</div>
