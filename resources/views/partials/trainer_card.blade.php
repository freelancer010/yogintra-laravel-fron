<div class="col-xs-12 col-sm-6 col-md-3 sm-text-center mb-30 mb-sm-30">
  <div class="team-members text-center maxwidth400">
    <div class="team-thumb">
      <img class="img-fullwidth" id="imageresource_{{ $i }}" style="height: 200px; width: auto" alt="YogIntra" src="{{ $api }}/{{ $trainer['profile_image'] }}">
    </div>
    <div class="team-details">
      <div class="p-10" style="background-color: #01AEB7;">
        <h4 class="team-title text-uppercase mt-0 mb-0">
          <a href="{{ route('trainer.show', $trainer['id']) }}"> {{ $trainer['name'] }} </a>
        </h4>
        <p class="team-subtitle mt-0 mb-0">Age - {{ $age }}</p>
      </div>
      <div class="p-20 bg-white d-none">
        <input type="hidden" value="{{ $trainer['Education'] }}" id="Education_{{ $i }}">
        <input type="hidden" value="{{ $trainer['experience'] }}" id="experience_{{ $i }}">
        <input type="hidden" value="{{ $trainer['city'] }}, {{ $trainer['state'] }}" id="address_{{ $i }}">
        <input type="hidden" value="{{ $trainer['name'] }}" id="name_{{ $i }}">
        <input type="hidden" value="{{ $age }}" id="age_{{ $i }}">
        <input type="hidden" value="{{ $trainer['package'] }}" id="package_{{ $i }}">
      </div>
    </div>
  </div>
</div>
