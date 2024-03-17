@if(isset($brands))
<div class="aside">
  <h3 class="aside-title">{{__('app.Filter_by_brand')}}</h3>
  <div class="filt-by-brands">
    <input type="checkbox"> <b>{{__('app.Check_all')}}</b><b style="display:none;">{{__('app.Uncheck_all')}}</b> <br>
    @for($k=0;$k<count($brands);$k++)
    <input type="checkbox" name="brand" value="{{$brands[$k]}}"> {{$brands[$k]}}<br>
    @endfor
  </div>
</div>
@endif
<div class="aside">
  <h3 class="aside-title">{{__('app.Filter_by_price')}} </h3>
  <div id="price-slider" data-min="1" data-max="10000" data-c="{{$currency}}"></div>
  <input type="hidden" class="filt_min" value="1">
  <input type="hidden" class="filt_max" value="10000">
  <hr>
  <button class="cust-btn-danger reset-filter">{{__('app.Reset')}}</button>
  <button class="cust-btn filter-btn pull-right" id="nav_filter">{{__('app.Filter')}}</button>
</div>
