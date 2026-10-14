<button id="messageIcon" class="landing-float landing-float-enquiry" type="button" aria-label="Open enquiry form"><i class="fa fa-comment" aria-hidden="true"></i></button>
<div class="tooltip-popup">Enquire with us!</div>
<a class="landing-float landing-float-whatsapp" href="https://api.whatsapp.com/send/?phone=919867291573&amp;text&amp;type=phone_number&amp;app_absent=0" target="_blank" rel="noopener noreferrer" aria-label="Chat with YogIntra on WhatsApp" title="Chat with YogIntra on WhatsApp"><i class="fa fa-whatsapp" aria-hidden="true"></i><span class="sr-only">Chat with YogIntra on WhatsApp</span></a>

<div id="messagePopup" role="dialog" aria-modal="true" aria-labelledby="landingEnquiryTitle">
  <button class="close-btn" type="button" onclick="toggleMessagePopup()" aria-label="Close enquiry form">&times;</button>
  <div class="popup-content">
    <div id="landingEnquiryTitle" class="popup-title">Get In Touch</div>
    <x-multi-step-form :form-type="'embed'" :source="$source" />
  </div>
</div>
