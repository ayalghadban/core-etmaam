<div class="hero-area lazy" data-bg="{{asset('assets/front/img/'.$bs->hero_bg)}}" style="background-size: cover;">
   <div class="container">
      <div class="hero-txt">
         <div class="row">
            <div class="col-12">
               <span>{!! convertUtf8($bs->hero_section_title) !!}</span>
               <h3 style="font-weight:400!important" class="slider-des">{{convertUtf8($bs->hero_section_text)}}</h3>
               @if (!empty($bs->hero_section_button_url) && !empty($bs->hero_section_button_text))
               <a href="{{$bs->hero_section_button_url}}" class="hero-boxed-btn">{{convertUtf8($bs->hero_section_button_text)}}</a>
               @endif
            </div>
         </div>
      </div>
   </div>
   <div class="hero-area-overlay" style="background-color: #{{$be->hero_overlay_color}};opacity: {{$be->hero_overlay_opacity}};"></div>
</div>
