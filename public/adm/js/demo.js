$(function () {
    // skinChanger();
    activateNotificationAndTasksScroll();
    // setSkinListHeightAndScroll(true);
    // setSettingListHeightAndScroll(true);
    // $(window).resize(function () {
    //     setSkinListHeightAndScroll(false);
    //     setSettingListHeightAndScroll(false);
    // });
});
var icons = ['move_to_inbox','comment','person_add','add_shopping_cart','delete_forever','mode_edit','cached','settings'];
var not_colors = ['bg-light-green','bg-cyan','bg-red','bg-orange','bg-blue-grey','bg-light-green','bg-purple'];
const ucheck = (data) => {
  return document.URL.indexOf(data) > 0 ? true : false;
}
const $header = $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
$db = $(document.body);
// function skinChanger() {
//     $('.right-sidebar .demo-choose-skin li').on('click', function () {
//         var $body = $('body');
//         var $this = $(this);
//         var existTheme = $('.right-sidebar .demo-choose-skin li.active').data('theme');
//         $('.right-sidebar .demo-choose-skin li').removeClass('active');
//         $body.removeClass('theme-' + existTheme);
//         $this.addClass('active');
//
//         $body.addClass('theme-' + $this.data('theme'));
//     });
// }
//
// function setSkinListHeightAndScroll(isFirstTime) {
//     var height = $(window).height() - ($('.navbar').innerHeight() + $('.right-sidebar .nav-tabs').outerHeight());
//     var $el = $('.demo-choose-skin');
//
//     if (!isFirstTime){
//       // $el.slimScroll({ destroy: true }).height('auto');
//       $el.parent().find('.slimScrollBar, .slimScrollRail').remove();
//     }
//
//     // $el.slimscroll({
//     //     height: height + 'px',
//     //     color: 'rgba(0,0,0,0.5)',
//     //     size: '6px',
//     //     alwaysVisible: false,
//     //     borderRadius: '0',
//     //     railBorderRadius: '0'
//     // });
// }

//Setting tab content set height and show scroll
// function setSettingListHeightAndScroll(isFirstTime) {
//     var height = $(window).height() - ($('.navbar').innerHeight() + $('.right-sidebar .nav-tabs').outerHeight());
//     var $el = $('.right-sidebar .demo-settings');
//
//     if (!isFirstTime){
//       // $el.slimScroll({ destroy: true }).height('auto');
//       $el.parent().find('.slimScrollBar, .slimScrollRail').remove();
//     }
//
//     // $el.slimscroll({
//     //     height: height + 'px',
//     //     color: 'rgba(0,0,0,0.5)',
//     //     size: '6px',
//     //     alwaysVisible: false,
//     //     borderRadius: '0',
//     //     railBorderRadius: '0'
//     // });
// }

function activateNotificationAndTasksScroll() {
    $('.navbar-right .dropdown-menu .body .menu').slimscroll({
        height: '254px',
        color: 'rgba(0,0,0,0.5)',
        size: '4px',
        alwaysVisible: false,
        borderRadius: '0',
        railBorderRadius: '0'
    });
}
const padZero = (str, len) => {
    len = len || 2;
    var zeros = new Array(len).join('0');
    return (zeros + str).slice(-len);
}
const tsuggs = [];
const tb_suggestions = () => {
  $.ajax({
    url: '/admin/get-tab-suggestions',
    type: 'GET',
    success:function(d){
      for (let i = 0; i < d.length; i++) {
        tsuggs.push(d[i].title);
      }
    }
  });
}
tb_suggestions();
const invertColor = (hex) => {
    if (hex.indexOf('#') === 0) {
        hex = hex.slice(1);
    }
    if (hex.length === 3) {
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }
    if (hex.length !== 6) {
        throw new Error('Invalid HEX color.');
    }
    var r = (255 - parseInt(hex.slice(0, 2), 16)).toString(16),
        g = (255 - parseInt(hex.slice(2, 4), 16)).toString(16),
        b = (255 - parseInt(hex.slice(4, 6), 16)).toString(16);
    return '#' + padZero(r) + padZero(g) + padZero(b);
}

const isHexColor = (hex) => {
  return typeof hex === 'string'
      && hex.length === 6
      && !isNaN(Number('0x' + hex))
}
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
  // const notify_once = (mess,type) => {
  //   // Expected "success", "error", "warning", "info" or "question", got "danger"
  //   Toast.fire({
  //     type: type,
  //     title: mess
  //   });
  // }
const notify = (message,type) => {
  // let len = $(".notify").length;
  // for (var i = 0; i < len; i++) {
  //   let bt = 90 + 75 * i;
  //   let op = 0.6 + 0.4/i;
  //   $(".notify:eq("+(len - i - 1)+")").animate({bottom: bt+"px",opacity:op});
  // }
  Toast.fire({
    type: type,
    title: message
  });
  // $("body").append("<div class='notify notify_"+(len - $(this).index())+" notify-"+type+"' data-index='"+(len - $(this).index())+"'><a class='close'>&times;</a>"+message+"</div>");
}
$db.on("click",".notify .close",function(){
  close_notify($(this).parent().data("index"));
  let len = $(".notify:not(:last-child)").length;
  for (var k = 0; k < len; k++) {
    let bt = 20 + 75 * k;
    $(".notify:eq("+(len - k - 1)+")").animate({bottom: bt+"px"});
  }
});
const autocomplete = (inp, arr) => {
  var currentFocus;
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      this.parentNode.appendChild(a);
      for (i = 0; i < arr.length; i++) {
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          b = document.createElement("DIV");
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          b.addEventListener("click", function(e) {
              inp.value = this.getElementsByTagName("input")[0].value;
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        currentFocus++;
        addActive(x);
      } else if (e.keyCode == 38) {
        currentFocus--;
        addActive(x);
      } else if (e.keyCode == 13) {
        e.preventDefault();
        if (currentFocus > -1) {
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    if (!x) return false;
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}
// autocomplete(document.getElementById("myInput"), countries);

setInterval(function(){
  let len = $(".notify").length;
  for (var i = 0; i < len; i++) {
    close_notify($(".notify:eq(0)").data("index"));
  }
},6000);
function close_notify(id){
  $(".notify_"+id).fadeOut(700, function() { $(this).remove(); });
}
function change_pimg(){
  for (var i = 0; i < $(".pimg img").length; i++) {
    $(".pimg:eq("+i+") img").attr("src",$(".pimg:eq("+i+") img").data("src"));
  }
}
change_pimg();
const setCookie = function(name,value,days) {
  var expires = "";
  if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days*24*60*60*1000));
      expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
const getCookie = function(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
let parseText = function(text, limit){
  if (text.length > limit){
      for (let i = limit; i > 0; i--){
          if(text.charAt(i) === ' ' && (text.charAt(i-1) != ','||text.charAt(i-1) != '.'||text.charAt(i-1) != ';')) {
              return text.substring(0, i) + '...';
          }
      }
       return text.substring(0, limit) + '...';
  }
  else
      return text;
};
const eraseCookie = function(name) {
    document.cookie = name+'=; Max-Age=-99999999;';
}
$(".switch > label > input").change(function(){
  let $sb = $(this).parents("label").siblings("input");
  if ($sb.val() == 1) {
    $sb.val(0)
  }else{
    $sb.val(1)
  }
});
function get_notify_list(){
  $.ajax({
    type: 'GET',
    url: '/admin/get-notification',
    success:function(t){
      let h = "";
      for (var i = 0; i < t.data.length; i++) {
        let v = t.data[i];
        h += "<li style='padding:7px 12px'><a class='waves-effect waves-block not_item' data-type='"+v['type']+"' data-id='"+v['main_id']+"'><div class='icon-circle "+not_colors[parseInt(v['type'])]+"'><i class='material-icons'>"+icons[parseInt(v['type'])]+"</i></div><div class='menu-info'><h4>"+parseText(v['body'],20)+"</h4><p><i class='material-icons'>access_time</i> "+v['time']+"</p></div></a></li>";
      }
      $("#navbar-collapse .label-count").html(t.data.length);
      $("#notify_section").html(h);
    }
  });
}
get_notify_list();
$("#show_more_notification").on("click",function(){
  console.log("you clicked show_more_notification button");
});
$db.on("click",".not_item",function(){
  console.log("type: " + $(this).data("type") + ", id: " + $(this).data("id"));
});
$(document).mousemove(function (e) {
  if ($("#navbar-collapse > ul > li").hasClass("open")) {
    $("body").addClass("lock-scroll");
  }else{
    $("body").removeClass("lock-scroll");
  }
});
$db.on("click",".dlt_category",function(){
  let wrds = $(this).data("words").split(",");
  let html = "<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>"+wrds[0]+"</h4></div><div class='modal-body'><p>"+$(this).data("text")+"</p></div><div class='modal-footer'><a class='btn btn-default' data-dismiss='modal'>"+wrds[2]+"</a><a href='/admin/delete-category/"+$(this).data("id")+"' class='btn btn-danger'>"+wrds[1]+"</a></div></div></div>";
  $("#deletemodal").html(html);
});
if (typeof page !== 'undefined') {
  if (page === 'slide_control') {
    function reorder(){
      for (var i = 0; i < $("tbody tr").length; i++) {
        $("tbody tr:eq("+i+") th:eq(0)").html((i + 1) + ".");
      }
    }
    $db.on("click",".list-btns > .delete",function(){
      let wrds = $(".list-btns > .btn-danger").data("words").split(",");
      let html = "<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>"+wrds[0]+"</h4></div><div class='modal-body'><p>"+$(this).data("text")+"</p></div><div class='modal-footer'><a class='btn btn-default' data-dismiss='modal'>"+wrds[2]+"</a><a href='/admin/delete-poster/"+$(this).data("id")+"' class='btn btn-danger'>"+wrds[1]+"</a></div></div></div>";
      $("#slide_modal").html(html);
    });
    // $db.on("click",".dlt_poster",function(){
    //   $header;
    //   $.ajax({
    //     type: 'DELETE',
    //     url: '/admin/delete-poster',
    //     data:{id:$(this).data("id")},
    //     success:function(data){
    //       notify(data.mess,"danger");
    //       location.reload();
    //     }
    //   });
    // });
    $("#save_order").on("click",function(){
      let arr = [];let idd = "#poster_id tr";
      for (var i = 0; i < $(idd).length; i++) {
        let val = $(idd+":eq("+i+")").data("id");
        arr.push({key: i, value: val});
      }
      console.log(arr);
      $header;
      $.ajax({
        url: '/admin/update-slide-status',
        type: 'POST',
        data:{id:$(this).data("poster"),array:arr},
        success:function(data){
          notify(data.mess,"success");
        }
      });
    });
    $(function() {
        var isDragging = false;
        $("tbody tr")
        .mousedown(function() {
            reorder();
            isDragging = false;
        })
        .mouseup(function() {
            reorder();
            var wasDragging = isDragging;
            isDragging = false;
            if (!wasDragging) {
                $("#throbble").toggle();
            }
        });
        $("tbody").sortable();
    });
    $("#dependent").on("change",function(){
        $("#value").parent().remove();
        $(this).parent().after('<div class="col-sm-12"><select class="form-control" id="value"></select></div>');
        if ($(this).val() !== "") {
          $.ajax({
            type: 'GET',
            url: '/admin/get-slide-type-id',
            data: {type: $(this).val()},
            success:function(t){
              html = "";
              for (var i = 0; i < t.data.length; i++) {
                let pid = "";
                if (t.data[i].prod_id !== null && t.data[i].prod_id !== undefined) {
                  pid = `${t.data[i].prod_id}:`;
                }
                html += `<option value='${t.data[i].id}'>${pid} ${t.data[i].name}</option>`;
              }
              console.log(t.data);
              $("#value").append(html);
            }
        });
      }
    });
    $("#poster_change").on("click",function(){
      $header;
      $.ajax({
        url: '/admin/update-slide-status',
        type: 'POST',
        data:{id:$(this).data("poster")},
        success:function(data){
          notify(data.mess,"success");
        }
      });
    });
    $("#btn_active").on("input",function(){
      console.log("ok");
      $('.btdet').remove();
      if ($("#btn_active").val()) {
        let clrs = ['#2da8ff','#45e645','#e31e25','#e8cd09','#d0d0d0'];
        $(this).closest(".form-group").after("<div class='row clearfix btdet'><div class='col-sm-12'><input type='hidden' name='button_type'><span class='btn_t' value='0' style='background:"+clrs[0]+"'>Primary </span> <span class='btn_t' value='1' style='background:"+clrs[1]+"'>Success</span><span class='btn_t' value='2' style='background:"+clrs[2]+"'>Danger</span><span class='btn_t' value='3' style='background:"+clrs[3]+"'>Warning</span><span class='btn_t' value='4' style='background:"+clrs[4]+"'>Info</span></div><div class='col-sm-12'><div class='form-group'><label for='button_href'>"+$(this).data("word")+"</label><div class='form-line'><input type='text' name='button_href' class='form-control' placeholder='"+$(this).data("word")+"...'/></div></div></div></div>");
      }else{
        $('.btdet').remove();
      }
    });
    $db.on("click",".btn_t",function(){
      if (!$(this).hasClass("active")) {
        $(this).addClass("active").siblings(".btn_t").removeClass("active");
      }
      $("input[name='button_type']").val($(this).attr("value"))
    });

  }else if(page === 'profile'){
    $(".nav-tabs > li > a").on("click",function(){window.location.hash = $(this).attr("href");});
    $(document).ready(function(){
        if (!window.location.hash) {
          window.location.hash = $(".profile-set-section > li:eq(0) > a").attr("href");
        }
        var pg = window.location.hash;
        var index = $(".profile-set-section > li > a[href='"+pg+"']").parent().index();
        $(".nav-tabs > li:eq("+index+")").addClass("active");
        $(".nav-tabs > li:not(:eq("+index+"))").removeClass("active");
        $(pg).addClass("active");
        $("#img_up_form").on("submit",function(e){
          e.preventDefault();
          $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
          $.ajax({
            url: '/change-user-profile',
            type: 'POST',dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            data:new FormData(this),
            success:function(data){notify(data.success,"success");
            for (var i = 0; i < $(".pimg img").length; i++) {
              $(".pimg:eq("+i+") img").data("src",data.image);
            }
            $("input[name='user_image']").val("");
            change_pimg();}
          })
        });
    });
  }else if(page === 'static'){
    $(document).ready(function(){
      const go_to_bottom = function(){
        let $target = $('html,body');
        $target.animate({scrollTop: $target.height()}, 1000);
      }
      let td_0,td_1,td_2,td_3;
      if (document.URL.indexOf("translation") >= 0) {
        var folder = "";
        var fl = "";
        function get_tr_folder(folder){
          $.ajax({
            url: '/admin/translation',
            type: 'GET',
            data:{folder:folder},
            success:function(data){
              let files = "";
              for (var i = 0; i < data.length; i++) {
                files += "<a class='file_name' data-id='"+data[i]+"'>"+folder+"/"+data[i].replace(".php", "")+"</a>";
              }
              $(".header > h2 > small > b:eq(0)").html('/'+folder);
              $("#exist_files").html(files);
            }
          });
        }
        function get_tr_file(folder,fl){
          $.ajax({
            url: '/admin/translation',
            type: 'GET',
            data:{file:fl,fld:folder},
            success:function(data){
              let string = "";
              for (var i = 0; i < data.length; i++) {
                let btns = "<a class='btn btn-danger delete_word' data-key='"+Object.keys(data[i])+"'><i class='fa fa-trash'></i></a><a><i></i></a>";
                string += "<tr><th scope='row' data-index='"+(i + 1)+"'>"+(i+1)+"</th><td>"+Object.keys(data[i])+"</td><td><textarea name='"+Object.keys(data[i])+"'>"+Object.values(data[i])+"</textarea> </td><td>"+btns+"</td></tr>";
              }
              $(".header > h2 > small > b:eq(0)").html('/'+folder + '/' + fl);
              $(".words").html(string);
              td_0 = $(".words tr:eq(0) th:eq(0)").width();
              td_1 = $(".words tr:eq(0) td:eq(0)").width();
              td_2 = $(".words tr:eq(0) td:eq(1)").width();
              td_3 = $(".words tr:eq(0) td:eq(2)").width();
              $("#search_id").css("display","");
              $("a.add_new_w").css("display","");
              $("#save_files").css("display","");
              $("#file_link").attr("folder",folder).attr("file",fl);
            }
          });
        }
        $db.on("click",".delete_word",function(){
          var list = [];
          for (var i = 0; i < $(".words > tr").length; i++) {
            if ($(".words > tr:eq("+i+") > td:eq(0)").text() !== $(this).data("key")) {
              let key = $(".words > tr:eq("+i+") > td:eq(0)").text();
              let val = $(".words > tr:eq("+i+") > td:eq(1) > textarea").val();
              list.push({key, val});
            }
          }
          load_words(folder,fl,list);
        });
        $(".folder_name").on("click",function(){$(this).addClass("active").siblings().removeClass("active");folder = $(this).data("id");get_tr_folder(folder);});
        $db.on("click",".file_name",function(){$(this).addClass("active").siblings().removeClass("active");fl = $(this).data("id");get_tr_file(folder,fl);});
        $("#save_files").on("click",function(){
          var list = [];
          for (var i = 0; i < $(".words > tr").length; i++) {
            let key = $(".words > tr:eq("+i+") > td:eq(0)").text();
            let val = $(".words > tr:eq("+i+") > td:eq(1) > textarea").val();
            list.push({key, val});
          }
          $(this).html('<i class="fa fa-refresh fa-spin"></i>');
          load_words(folder,fl,list);
        });
        function load_words(folder,fl,list){
          $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
          $.ajax({
            url: '/admin/save-tr-file',
            type: 'POST',
            data:{folder: folder,file:fl,list:list},
            success:function(data){
              // console.log(data.message);
              notify(data.message,"success");
              $('#addNewWord').modal('hide');
              $('#addNewWord textarea,#addNewWord input').val("");
              get_tr_file(folder,fl);
              go_to_bottom();
            },
            complete:function(){
              $("#save_files .fa-spin").remove();
              $("#save_files").html('<i class="fa fa-save"></i>');
            }
          });
        }
        $(".addnew_w").on("click",function(){
          $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
          var list = [];
          for (var i = 0; i < $(".words > tr").length; i++) {
            let key = $(".words > tr:eq("+i+") > td:eq(0)").text();
            let val = $(".words > tr:eq("+i+") > td:eq(1) > textarea").val();
            list.push({key, val});
          }
          let key = $("#index").val();
          let val = $("#word_translate").val();
          list.push({key, val});
          load_words(folder,fl,list);
        });
      }else if(document.URL.indexOf("configuration") >= 0){
        function get_configuration(){
          $.ajax({
            url: '/admin/configuration',
            type: 'GET',
            data:{get_data:0},
            success:function(data){
              let tr = "";
              let len = Object.keys(data).length;
              for (var i = 0; i < len; i++) {
                let val = data[i][Object.keys(data[i])[0]]; let key = Object.keys(data[i])[0];
                let input = "no input detected";let col = "";
                ;
                if (key.includes("color")) {
                  col = "style='color:"+invertColor(val[0])+";background:"+val[0]+"'";
                }
                if (val[1] === "text_input") {
                  let value = val[0];if (val[0] === null) {value = "";}
                  input = "<input type='text' "+col+" id='"+key+"' value='"+value+"' class='value'>";
                }else if(val[1] === "radio_input"){
                  input = "<div class='demo-switch'><div class='switch'><label data-on='"+val[3]+"' data-off='"+val[4]+"'>"+val[4]+"<input type='checkbox' checked='' id='"+key+"' data-on='"+val[0]+"' data-off='"+val[2]+"' class='value' value='"+val[2]+"'><span class='lever'></span>"+val[3]+"</label></div></div>";
                }else if(val[1] === "textarea"){
                  let value = val[0];if (val[0] === null) {value = "";}
                  input = "<textarea id='"+key+"' class='value' "+col+">"+value+"</textarea>";
                }else if(val[1] === "number_input"){
                  let value = val[0];if (val[0] === null) {value = "";}
                  input = "<input type='number' id='"+key+"' value='"+value+"' class='value' "+col+">";
                }
                let btns = "<a class='btn btn-danger delete_conf' data-key='"+key+"'><i class='fa fa-trash'></i></a><a><i></i></a>";
                tr += "<tr><th scope='row' data-tp='"+val[1]+"' data-index='"+(i + 1)+"'>"+(i+1)+"</th><td>"+key+"</td><td>"+input+" </td><td>"+btns+"</td></tr>";
              }
              $("#save_files,.add_new_w").css("display","");
              $(".words").html(tr);

              td_0 = $(".words tr:eq(0) th:eq(0)").width();
              td_1 = $(".words tr:eq(0) td:eq(0)").width();
              td_2 = $(".words tr:eq(0) td:eq(1)").width();
              td_3 = $(".words tr:eq(0) td:eq(2)").width();
              $("#search_id").css("display","");

            },complete:function(){
              $("#save_files").html('<i class="fa fa-save"></i>');
            }
          });
        }
        $db.on("input",".value",function(){
          if ($("tr:eq("+($(this).parents("tr").index() + 1)+") td:eq(0)").text().includes("color")) {
            if (isHexColor($(this).val().replace("#",""))) {
              $(this).attr("style","color:"+invertColor($(this).val())+";background:"+$(this).val());
            }
          }
          console.log($("tr:eq("+($(this).parents("tr").index() + 1) +") td:eq(0)").text());
        });
        $("#save_files").on("click",function(){
          var list = [];
          for (var i = 0; i < $(".words > tr").length; i++) {
            let base = ".words > tr:eq("+i+")"; let off_value = ""; let on_text = ""; let off_text ="";
            if ($(base+" td label").data("on")) {
              on_text = $(base+" td label").data("on");
              off_text = $(base+" td label").data("off");
              off_value = $(base+" td .value").data("off");
            }
            let key = $(base+" > td:eq(0)").text();
            let val = $(base+" > td:eq(1) .value").val();
            let type = $(base + "> th").data("tp");
            list.push({key,val,type,on_text,off_text,off_value});
          }
          conf_post_data(list);
          $(this).html('<i class="fa fa-refresh fa-spin"></i>');
        });
        function conf_post_data(list){
          $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
          $.ajax({
            type: 'POST',
            url: '/admin/update-configuration',
            data:{list:list},
            success:function(data){
              $('#newConfig').modal('hide');
              $(".temp_input").remove();$(".input-grp:eq(0) select option:eq(0)").prop('selected', true);
              notify(data.message,"success");
              get_configuration();
            }
          });
        }
        get_configuration();
        $db.on("change",".switch > label > input[type='checkbox']",function(){
          if ($(this).val() == $(this).data("on") | $(this).val() === $(this).data("on")) {
            $(this).val($(this).data("off"))
          }else{$(this).val($(this).data("on"))}
        });
        let div_in = function(word,name){
          return "<div class='form-group input-grp temp_input'><label>"+word+"</label><input type='text' placeholder='"+word+"...' name='"+name+"' class='form-control'></div>";
        }
        let conf_input_type = "";
        $(".input-grp:eq(0) select").on("change",function(){
          $(".temp_input").remove();
          let $t = $(this);
          conf_input_type = $t.val();
          let wds = $t.data("words").split(",");
          let inp0 = div_in(wds[4],"new_key");
          let inp1 = div_in(wds[0],"val");
          let inp2 = div_in(wds[1],"opposite");
          let inp3 = div_in(wds[2],"1th_text");
          let inp4 = div_in(wds[3],"2nd_text");
          let whole = "";
          if ($t.val() === "radio_input") {
            whole = inp0 + inp1 + inp2 + inp3 + inp4;
          }else if($t.val() === "textarea"){
            whole = inp0 + inp1;
          }else if($t.val() === "number_input"){
            whole = inp0 + inp1;
          }else if($t.val() === "text_input"){
            whole = inp0 + inp1;
          }
          $t.after(whole);
        });
        $(".add_new_conf").on("click",function(){
          let list = [];
          for (var i = 0; i < $(".words > tr").length; i++) {
            let base = ".words > tr:eq("+i+")"; let off_value = ""; let on_text = ""; let off_text ="";
            if ($(base+" td label").data("on")) {
              on_text = $(base+" td label").data("on");
              off_text = $(base+" td label").data("off");
              off_value = $(base+" td .value").data("off");
            }
            let key = $(base+" > td:eq(0)").text();
            let val = $(base+" > td:eq(1) .value").val();
            let type = $(base + "> th").data("tp");
            list.push({key,val,type,on_text,off_text,off_value});
          }

          let key = $("input[name='new_key']").val();
          let val = $("input[name='val']").val();
          let off_value = "";
          let on_text = "";
          let off_text = "";
          if ($("input[name='opposite']").length > 0) {
            off_value = $("input[name='opposite']").val();
            on_text = $("input[name='1th_text']").val();
            off_text = $("input[name='2nd_text']").val();
          }
          type = conf_input_type;
          list.push({key,val,type,on_text,off_text,off_value});
          conf_post_data(list);
        });
        $db.on("click",".delete_conf",function(){
          $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
          $.ajax({
            type: 'DELETE',
            url: '/admin/delete-configuration',
            data: {config:$(this).data("key")},
            success:function(data){
              notify(data.message,"success");
              get_configuration();
            }
          });
        });
      }
      function searchOnTable() {
        let input, filter, table, tr, td, i,k, txtValue;
        input = document.getElementById("search_id");
        filter = input.value.toUpperCase();
        table = document.getElementById("words_id");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          for (k = 0; k < 2; k++) {
            td = tr[i].getElementsByTagName("td")[k];
            if (td) {
              txtValue = td.textContent || td.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {tr[i].style.display = "none";}
            }
          }
        }
      }
      $(".static-search").on("input",function(){
        searchOnTable();
        $("#t_head tr:eq(0) th:eq(0)").css("width",td_0);
        $("#t_head tr:eq(0) th:eq(1)").css("width",td_1);
        $("#t_head tr:eq(0) th:eq(2)").css("width",td_2);
        $("#t_head tr:eq(0) th:eq(3)").css("width",td_3);
      });
    });
  }else if(page === 'list'){
    $(document).ready(function(){
      $("#copy_to_tfoot").siblings("tfoot").html($("#copy_to_tfoot").html())
    });
    const $md = $("#promodal");
    $db.on("click",".list-btns > .delete",function(){
      let wrds = $(".list-btns > .btn-danger").data("words").split(",");
      if ($(".delete").hasClass("dl_prod")) {url = "delete-product";}else if($(".delete").hasClass("dl_news")){url = "delete-news";}
      let html = "<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>"+wrds[0]+"</h4></div><div class='modal-body'><p>"+$(this).data("text")+"</p></div><div class='modal-footer'><a class='btn btn-default' data-dismiss='modal'>"+wrds[2]+"</a><a href='/admin/"+url+"/"+$(this).data("id")+"' class='btn btn-danger'>"+wrds[1]+"</a></div></div></div>";
      $md.html(html);
    });
    $db.on("click",".list-btns > .boost_it",function(){
      let wrds = $(this).data("words").split(","),
      form = "<div class='form-group'><label>"+wrds[5]+"</label><div class='form-line'><input type='number' class='form-control' name='discount_amount' step='0.01' max='"+$(this).data("max")+"' placeholder='"+wrds[5]+"' required></div></div><div class='form-group'><label>"+wrds[4]+"</label><div class='form-line'><input type='datetime-local' name='start_date' class='form-control' required></div></div><div class='form-group'><label>"+wrds[3]+"</label><div class='form-line'><input type='datetime-local' name='end_date' class='form-control' required></div></div>",
      token = $(this).siblings("input[name='_token']").val();
      console.log(token);
      let html = "<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>"+wrds[0]+"</h4></div><form action='/admin/boost-table' method='POST'><div class='modal-body'><input type='hidden' name='_token' value='"+token+"'><input type='hidden' name='prod_id' value='"+$(this).data("id")+"'>"+form+"</div><div class='modal-footer'><a class='btn btn-default' data-dismiss='modal'>"+wrds[2]+"</a><button class='btn btn-primary' type='submit'>"+wrds[1]+"</button></div></form></div></div>";
      $md.html(html);
    });
    $db.on("click",".list-btns > .dl_page",function(){
      let wrds = $(this).data("words").split(",");
      let html = "<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>"+wrds[0]+"</h4></div><div class='modal-body'><p>"+$(this).data("text")+"</p></div><div class='modal-footer'><a class='btn btn-default' data-dismiss='modal'>"+wrds[2]+"</a><a data-id='"+$(this).data("id")+"' class='btn btn-danger pg_dl_btn'>"+wrds[1]+"</a></div></div></div>";
      $md.html(html);
    });
    $db.on("click",".read_more",function(){
      let wrds = $(this).data("words").split(",");
      let html = "<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>"+wrds[0]+"</h4></div><div class='modal-body'><p>"+$(this).data("text")+"</p></div><div class='modal-footer'><a class='btn btn-default' data-dismiss='modal'>"+wrds[1]+"</a></div></div></div>";
      $md.html(html);
    });


    $db.on("click",".list-btns > .edit_page_modal",function(){
      let wrds = $(this).data("words").split(",");
      let id = $(this).data("id");
      $.ajax({
        type: 'GET',
        url: '/admin/get-page-details-for-edit',
        data:{id:id},
        success:function(data){
          let inp0 = "<label>"+wrds[6]+"</label><select class='form-control' id='pg_parent'><option>---";
          for (var i = 0; i < data.pages.length; i++) {
            if (data.page['parent_id'] == data.pages[i]['id']) {
              inp0 += "<option value='"+data.pages[i]['id']+"' selected>"+data.pages[i]['shortname']+"</option>";
            }else{
              inp0 += "<option value='"+data.pages[i]['id']+"'>"+data.pages[i]['shortname']+"</option>";
            }
          }
          inp0 += "</select>";
          let inp1 = "<br><label>"+wrds[4]+"</label><input class='form-control' id='pg_slug' type='text' value='"+data.page['slug']+"'>";
          let inp2 = "<br><label>"+wrds[8]+"</label><input class='form-control' id='pg_shortname' type='text' value='"+data.page['shortname']+"'>";
          let inp3 = "<br><label>"+wrds[5]+"</label><input class='form-control' id='pg_title' type='text' value='"+data.page['title']+"'>";
          let inp4 = "<br><label>"+wrds[7]+"</label><textarea class='form-control' id='pg_body' type='text'>"+data.page['body']+"</textarea>";
          let inputs = inp0 + inp1 + inp2 + inp3 + inp4;
          let html = "<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>"+wrds[0]+"</h4></div><div class='modal-body'>"+inputs+"</div><div class='modal-footer'><a class='btn btn-default' data-dismiss='modal'>"+wrds[2]+"</a><a class='btn btn-primary upt_pg' data-id='"+id+"'>"+wrds[3]+"</a></div></div></div>";
          $md.html(html);
        }
      });
    });
    $db.on("click",".upt_pg",function(){
      $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
      $.ajax({
        url: '/admin/update-page',
        type: 'POST',
        data:{id:$(this).data("id"),parent_id:$("#pg_parent").val(),slug:$("#pg_slug").val(),shortname: $("#pg_shortname").val(), title: $("#pg_title").val(),body:$("#pg_body").val()},
        success:function(data){
          $md.modal('hide');
          notify(data.success,"success");
        }
      });
    });
    $db.on("click",".pg_dl_btn",function(){
      $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
      $.ajax({
        url: '/admin/delete-page',
        type: 'DELETE',
        data:{id:$(this).data("id")},
        success:function(data){
          $md.modal('hide');
          notify(data.message,"danger");
        }
      });
    });


    $db.on("change",".page-list-rd-btns input",function(){
      $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
      if ($(this).data("page")) {
        $.ajax({
          url: '/admin/update-pg-head-foot',
          type: 'POST',
          data:{page:$(this).data("page"),tp:$(this).parents("label").siblings("input").attr("name"),tp_val: $(this).parents("label").siblings("input").val()},
          success:function(data){
            console.log(data);
          }
        });
        console.log("page");
      }else{
        $.ajax({
          url: '/admin/update-news-status',
          type: 'POST',
          data:{news:$(this).data("news"),status: $(this).parents("label").siblings("input").val()},
          success:function(data){
            console.log(data);
          }
        });
        console.log("news");
      }
      // console.log($(this).parents("label").siblings("input").attr("name"));
    });
  }else if(page === 'dev'){
    $(document).ready(function(){
      $("#select_file").on("change",function(){
        get_code_ontext($(this).val());
      });
      get_code_ontext($("#select_file").val());
      function get_code_ontext(file){
        let $sc = $("#save_code");
        $sc.html('<i class="fa fa-refresh fa-spin"></i>');
        $.ajax({
            type: 'GET',
            url: '/admin/get-file-data',
            data:{file:file},
            success:function(data){
              $("#code_review").val(data);
              $(".url-link").html("<a href='/admin/code-view/"+file+"'>"+file+"</a>");
              let textarea = document.getElementById('code_review');
              textarea.scrollTop = textarea.scrollHeight;
            },
            complete:function(){$sc.css("display","").html('<i class="fa fa-save"></i>');}
        });
      }
      $("#save_code").on("click",function(e){
        let $sc = $("#save_code");
        $sc.html('<i class="fa fa-refresh fa-spin"></i>');
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
          type: 'POST',
          url: '/admin/update-css-js',
          data:{file:$("#select_file").val(),val:$("#code_review").val()},
          success:function(data){
            notify(data.message,"success");
          },
          complete:function(){
              $sc.html('<i class="fa fa-save"></i>');
          }
        });
      });
    });

    var SAR = {};

      SAR.find = function(){
          // collect variables
          var txt = $("#code_review").val();
          var strSearchTerm = $("#termSearch").val();
          var isCaseSensitive = ($("#caseSensitive").attr('checked') == 'checked') ? true : false;

          // make text lowercase if search is supposed to be case insensitive
          if(isCaseSensitive == false){
              txt = txt.toLowerCase();
              strSearchTerm = strSearchTerm.toLowerCase();
          }

          // find next index of searchterm, starting from current cursor position
          var cursorPos = ($("#code_review").getCursorPosEnd());
          var termPos = txt.indexOf(strSearchTerm, cursorPos);

          // if found, select it
          if(termPos != -1){
              $("#code_review").selectRange(termPos, termPos+strSearchTerm.length);
          }else{
              // not found from cursor pos, so start from beginning
              termPos = txt.indexOf(strSearchTerm);
              if(termPos != -1){
                  $("#code_review").selectRange(termPos, termPos+strSearchTerm.length);
              }else{
                  alert("not found");
              }
          }
      };

      SAR.findAndReplace = function(){
          var origTxt = $("#code_review").val(); // needed for text replacement
          var txt = $("#code_review").val(); // duplicate needed for case insensitive search
          var strSearchTerm = $("#termSearch").val();
          var strReplaceWith = $("#termReplace").val();
          var isCaseSensitive = ($("#caseSensitive").attr('checked') == 'checked') ? true : false;
          var termPos;
          if(isCaseSensitive == false){
              txt = txt.toLowerCase();
              strSearchTerm = strSearchTerm.toLowerCase();
          }
          var cursorPos = ($("#code_review").getCursorPosEnd());
          var termPos = txt.indexOf(strSearchTerm, cursorPos);
          var newText = '';
          if(termPos != -1){
              newText = origTxt.substring(0, termPos) + strReplaceWith + origTxt.substring(termPos+strSearchTerm.length, origTxt.length)
              $("#code_review").val(newText);
              $("#code_review").selectRange(termPos, termPos+strReplaceWith.length);
          }else{
              termPos = txt.indexOf(strSearchTerm);
              if(termPos != -1){
                  newText = origTxt.substring(0, termPos) + strReplaceWith + origTxt.substring(termPos+strSearchTerm.length, origTxt.length)
                  $("#code_review").val(newText);
                  $("#code_review").selectRange(termPos, termPos+strReplaceWith.length);
              }else{
                  alert("not found");
              }
          }
      };

      SAR.replaceAll = function(){
          var origTxt = $("#code_review").val(); // needed for text replacement
          var txt = $("#code_review").val(); // duplicate needed for case insensitive search
          var strSearchTerm = $("#termSearch").val();
          var strReplaceWith = $("#termReplace").val();
          var isCaseSensitive = ($("#caseSensitive").attr('checked') == 'checked') ? true : false;
          if(isCaseSensitive == false){
              txt = txt.toLowerCase();
              strSearchTerm = strSearchTerm.toLowerCase();
          }
          var matches = [];
          var pos = txt.indexOf(strSearchTerm);
          while(pos > -1) {
              matches.push(pos);
              pos = txt.indexOf(strSearchTerm, pos+1);
          }
          for (var match in matches){
              SAR.findAndReplace();
          }
      };
      $.fn.selectRange = function(start, end) {
          return this.each(function() {
              if(this.setSelectionRange) {
                  this.focus();
                  this.setSelectionRange(start, end);
              } else if(this.createTextRange) {
                  var range = this.createTextRange();
                  range.collapse(true);
                  range.moveEnd('character', end);
                  range.moveStart('character', start);
                  range.select();
              }
          });
      };

      $.fn.getCursorPosEnd = function() {
          var pos = 0;
          var input = this.get(0);
          // IE Support
          if (document.selection) {
              input.focus();
              var sel = document.selection.createRange();
              pos = sel.text.length;
          }
          // Firefox support
          else if (input.selectionStart || input.selectionStart == '0')
              pos = input.selectionEnd;
          return pos;
      };
  }else if(page === 'create'){

  }else if(page === 'add_product'){
    $(function() {
        function reorder(){
          for (var i = 0; i < $("#cat_list tr").length; i++) {
            $("#cat_list tr:eq("+i+") th:eq(0)").html(i + ".");
          }
        }
        var isDragging = false;
        $("#cat_list tr")
        .mousedown(function() {
            reorder();
            isDragging = false;
        })
        .mouseup(function() {
            reorder();
            var wasDragging = isDragging;
            isDragging = false;
            if (!wasDragging) {
                $("#throbble").toggle();
            }
        });
        $("#cat_list").sortable();
        $("#update_cat_list").click(function(){
          let arr = [];
          for (var i = 0; i < $("#cat_list tr").length; i++) {
            let key = $("#cat_list tr:eq("+i+")").data("id");
            arr.push({key: key,val: i});
          }
          let $th = $(this);
          $th.html('<i class="fa fa-refresh fa-spin"></i>');
          $header;
          $.ajax({
            url: '/admin/update-category-order',
            type: 'POST',
            data: {arr: arr},
            success:function(t){
              notify(t.mess,"success");
            },complete:function(){
              $th.html('<i class="fa fa-save"></i>');
            }
          });
        });
    });
    if (ucheck('/change-image-order/')) {
      $db.on("click",".delete_image",function(){
        let wrds = $(this).data("words").split(",");
        let html = "<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>"+wrds[0]+"</h4></div><div class='modal-body'><p>"+$(this).data("text")+"</p><img src='"+$(this).siblings("img").attr("src")+"' class='deleting_img'></div><div class='modal-footer'><a class='btn btn-default' data-dismiss='modal'>"+wrds[2]+"</a><a data-id='"+$(this).data("id")+"' class='btn btn-danger dlt_img'>"+wrds[1]+"</a></div></div></div>";
        $("#delete_img").html(html);
      });
      $db.on("click",".dlt_img",function(){
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        console.log($(this).data("id"));
        $.ajax({
          url: '/admin/delete-image',
          type: 'DELETE',
          data: {id:$(this).data("id")},
          success:function(t){
            $('#delete_img').modal('hide');
            location.reload();
            notify(t.mess,'danger');
          }
        });
      });
      $db.on("click",".my-btn",function(){
        reorder();
        var arr = [];
        for (var i=0; i < $("ul.image-list li").length; i++) {
          let img_id = $("ul.image-list li:eq("+i+") img").data("id");
          arr.push(img_id);
        }
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
          type: 'POST',
          url: '/admin/change-images-order',
          data:{list:arr},
          success:function(data){notify(data.success,"success");}
        });
      });
      function reorder(){
        for (var i = 0; i < $("ul.image-list li").length; i++) {
          $("ul.image-list li:eq("+i+") b").html((i + 1) + ".");
        }
      }
      $(function() {
          var isDragging = false;
          $("ul.image-list li")
          .mousedown(function() {
              reorder();
              isDragging = false;
          })
          .mouseup(function() {
              reorder();
              var wasDragging = isDragging;
              isDragging = false;
              if (!wasDragging) {
                  $("#throbble").toggle();
              }
          });
          $("ul").sortable();
      });
    }else{
      $("#pcat").on("change",function(e){
        change_subcat($(this).val());
      });
      $(document).ready(function(){
        change_subcat($("#pcat").data("select"));
        if ($("#tab_table").length > 0) {
          let tbd = "#tab_table > tbody";
          let wrds = $(tbd).data("words").split(',');
          let new_input = "<tr><td><input type='text' class='tab_inputs' placeholder='"+wrds[0]+"...'> </td><td><textarea class='tab_inputs' placeholder='"+wrds[1]+"...'></textarea> </td><td><a class='btn btn-danger tab_input_delete' data-id='0'><i class='fa fa-trash'></i></a> </td></tr>";
          $("#add_new_tab").on("click",function(){
            $(tbd).append(new_input);
          });
          let urls = [
            ['delete-prod-tab','get-prod-tabs-ajax','update-products-tabs'],
            ['delete-page-tab','get-page-tabs-ajax','update-page-tabs']
          ];
          let main_id = "";
          if ($(tbd).data("page-id")) {
            urls = urls[1];
            main_id = $(tbd).data("page-id");
          }else{
            urls = urls[0];
            main_id = $(tbd).data("id");
          }
          $db.on("click",".tab_input_delete",function(){
            $("#tab_table tbody tr td:eq(2) a").html('<i class="fa fa-refresh fa-spin"></i>').removeClass(".tab_input_delete");
            $(tbd+" > tr:eq("+getCookie("number_of_tr")+")").remove();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
              url: '/admin/' + urls[0],
              type: 'DELETE',data:{id:$(this).data("id")},
              success:function(data){
                notify(data.message,"danger");
                get_prod_tabs();
              },complete:function(){
                $("#tab_table tbody tr td:eq(2) a").html('<i class="fa fa-trash"></i>').addClass(".tab_input_delete");
              }
            });
          });
          let arr = [];
          get_prod_tabs();
          function get_prod_tabs(){
            $.ajax({
              type: 'GET',
              url: '/admin/' + urls[1],
              data:{main_id:main_id},
              success:function(data){
                let html = "";
                for (var i = 0; i < data.pts.length; i++) {
                  let val = data.pts[i];
                  html += "<tr data-id='"+val['id']+"'><td><input type='text' class='tab_inputs' placeholder='"+wrds[0]+"...' value='"+val['title']+"' autocomplete='off'> </td><td><textarea class='tab_inputs' placeholder='"+wrds[1]+"...'>"+val['description']+"</textarea> </td><td><a class='btn btn-danger tab_input_delete' data-id='"+val['id']+"'><i class='fa fa-trash'></i></a> </td></tr>";
                  // console.log($("tab_inputs").eq(i));
                }
                $(tbd).html(html);
                $(tbd).append(new_input);
              }
            })
          }
          $db.on("input",".tab_inputs",function(){
            autocomplete(this, tsuggs);
          });
          $(function() {
              var isDragging = false;
              $("tbody tr")
              .mousedown(function() {
                  isDragging = false;
              })
              .mouseup(function() {
                  var wasDragging = isDragging;
                  isDragging = false;
                  if (!wasDragging) {
                      $("#throbble").toggle();
                  }
              });
              $("tbody").sortable();
          });
          $("#save_new_tabs").on("click",function(){
            let tab_list = [];
            for (var i = 0; i < $(tbd + " > tr").length; i++) {
              let title = $(tbd + " > tr:eq("+i+") > td:eq(0) > .tab_inputs").val();
              let desc = $(tbd + " > tr:eq("+i+") > td:eq(1) > .tab_inputs").val();
              let id = $(tbd + " > tr:eq("+i+") > td:eq(2) > a").data("id");
              let index = i;
              tab_list.push({
                index,id,title,desc
              });
            }
            let th = this;
            $(th).html('<i class="fa fa-refresh fa-spin"></i>')
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
              url: '/admin/' + urls[2],
              type: 'POST',
              data:{list:tab_list,main_id:main_id},
              success:function(data){
                notify(data.message,'success');
                get_prod_tabs();
              },complete:function(){
                $(th).html('<i class="fa fa-save"></i>')
              }
            });
          });
        }
      });

      const change_subcat = function(id){
        if (id !== "" && id !== null) {
          // e.preventDefault();
          $.ajax({
            url: '/admin/change-subcategory/' + id,
            type: 'GET',
            cache: false,
            success:function(data){
              let html = "<option selected disabled>-- "+$("#psubcat").data('default')+" --</option>";
              for (var i = 0; i < data.length; i++) {
                let sl = "";
                if (data[i].id == $("#psubcat").data("select")) {sl = "selected"}
                html += "<option value='"+data[i].id+"' "+sl+">"+data[i].name+"</option>";
              }
              $("#psubcat").html(html).selectpicker('refresh');
              $("#psubcat option[value='"+$("#psubcat").data("select")+"']").prop("selected",true);
              // $("#psubcat");
            }
          });
        }
      }
      // $("input[name='status'],input[name='condition']").change(function(){
      //   if ($(this).val() == 1) {
      //     $(this).val(0)
      //   }else{
      //     $(this).val(1)
      //   }
      // });
      $db.on("change","#psubcat",function(){
        $("input#hidden_sub").val($(this).val());
      });
    }
  }
}
$('form').on('focus', 'input[type=number]', function (e) {
  $(this).on('wheel.disableScroll', function (e) {
    e.preventDefault()
  })
})
$('form').on('blur', 'input[type=number]', function (e) {
  $(this).off('wheel.disableScroll')
});

$(document).ready(function(){
  for (var i = 0; i < $("#leftsidebar .menu .list > li").length; i++) {
    if ($("#leftsidebar .menu .list > li:eq("+i+") > .ml-menu > li.active").length > 0) {
      $("#leftsidebar .menu .list > li:eq("+i+") > a").addClass("toggled");
      $("#leftsidebar .menu .list > li:eq("+i+") > .ml-menu").css("display","block");
    }
  }
});
function readURL(imgID,input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $(imgID).css("display","").attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$(".update_brand_stat").change(function(){
  $header;
  $.ajax({
    url: '/admin/update-brand-status',
    type: 'POST',
    data:{id:$(this).data("id"),status:$(this).parents("label").siblings("input").val()},
    success:function(){
      // console.log("success");
    }
  });
});
$(".brand_image").change(function(){
  readURL('.show_'+$(this).data("src"),this);
  $header;
  let fd = new FormData();
  let files = $(this)[0].files[0];
  fd.append('id',$(this).data("id"));
  fd.append('brand',$(this).data("brand"));
  fd.append('status',$(".stat_"+$(this).data("src")).val());
  fd.append('file',files);
  // console.log(".stat_"+$(this).data("src"));
  $.ajax({
    url: '/admin/update-brand-image',
    type: 'POST',
    data:fd,
    contentType: false,
    processData: false,
    success:function(t){
      // console.log(t);
    }
  });
});

$("#compress_prods").click(function(){
  let t = $(this);
  t.find('i').addClass('fa-spin');
  $.ajax({
    url: '/admin/compress/images',
    type: 'GET',
    success:function(d){
      t.find('i').removeClass('fa-spin');
    }
  });
});
$(document).ready(function () {
  if ($('#prod_list').length > 0) {
    $('#prod_list').DataTable().destroy();
    $('#prod_list').dataTable({"autoWidth": false,"lengthChange": false,"pageLength": 100});
  }
  $(".mark_as_read").on("click",function(){
    let th = $(this);
    $header;
    $.ajax({
      url: '/admin/mark-order-as-seen',
      type: 'POST',
      data: {id: th.data("id")},
      success:function(d){
        if (d.st == 1) {
          th.html('<i class="fa fa-envelope-open"></i>');
        }else{
          th.html('<i class="fa fa-envelope"></i>');
        }
        notify(d.message,"success");
      },error:function(d){
        console.log(d);
      }
    });
    // $(this).html($(this).attr("title"));
  });
});
// $("#submit_loans").on("click",function(){
//   $(".new_loan_form").submit();
// });
