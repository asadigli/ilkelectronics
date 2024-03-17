@php($nws = App\News::where('status',1)->orderBy('created_at','desc')->take(3)->get())
@if(count($nws) > 0)
<div class="home-news-section">
  <div class="section-title"><h2 class="title">{{__('app.News')}}</h2></div>
  @foreach($nws as $news)
  <div class="hc-news">
    <div class="hcn-img">
      @php($img = App\Images::where('news_id',$news->id)->orderBy('order','asc')->first())
      @if(!empty($img))<img src="/uploads/news/{{$img->image}}" alt="{{$news->title}}"> @else <img src="/uploads/news/default.png" alt="{{$news->title}}"> @endif
    </div>
    <div class="hcn-body">
      <span class="comments"> {{App\Comments::where('news_id',$news->id)->count()}} <i class="fa fa-comments"></i> </span>
      <span class="date"> {{\Carbon\Carbon::parse($news->created_at)->format('d M, Y')}} <i class="fa fa-calendar"></i></span>
      <p><a href="/news/{{$news->slug}}">{{str_limit($news->title,$limit = 100,$end = "...")}}</a> </p>
    </div>
  </div>
  @endforeach
</div>
@endif
