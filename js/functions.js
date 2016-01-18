// proccess bar function
(function(){var a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X=[].slice,Y={}.hasOwnProperty,Z=function(a,b){function c(){this.constructor=a}for(var d in b)Y.call(b,d)&&(a[d]=b[d]);return c.prototype=b.prototype,a.prototype=new c,a.__super__=b.prototype,a},$=[].indexOf||function(a){for(var b=0,c=this.length;c>b;b++)if(b in this&&this[b]===a)return b;return-1};for(u={catchupTime:100,initialRate:.03,minTime:250,ghostTime:100,maxProgressPerFrame:20,easeFactor:1.25,startOnPageLoad:!0,restartOnPushState:!0,restartOnRequestAfter:500,target:"body",elements:{checkInterval:100,selectors:["body"]},eventLag:{minSamples:10,sampleCount:3,lagThreshold:3},ajax:{trackMethods:["GET"],trackWebSockets:!0,ignoreURLs:[]}},C=function(){var a;return null!=(a="undefined"!=typeof performance&&null!==performance&&"function"==typeof performance.now?performance.now():void 0)?a:+new Date},E=window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||window.msRequestAnimationFrame,t=window.cancelAnimationFrame||window.mozCancelAnimationFrame,null==E&&(E=function(a){return setTimeout(a,50)},t=function(a){return clearTimeout(a)}),G=function(a){var b,c;return b=C(),(c=function(){var d;return d=C()-b,d>=33?(b=C(),a(d,function(){return E(c)})):setTimeout(c,33-d)})()},F=function(){var a,b,c;return c=arguments[0],b=arguments[1],a=3<=arguments.length?X.call(arguments,2):[],"function"==typeof c[b]?c[b].apply(c,a):c[b]},v=function(){var a,b,c,d,e,f,g;for(b=arguments[0],d=2<=arguments.length?X.call(arguments,1):[],f=0,g=d.length;g>f;f++)if(c=d[f])for(a in c)Y.call(c,a)&&(e=c[a],null!=b[a]&&"object"==typeof b[a]&&null!=e&&"object"==typeof e?v(b[a],e):b[a]=e);return b},q=function(a){var b,c,d,e,f;for(c=b=0,e=0,f=a.length;f>e;e++)d=a[e],c+=Math.abs(d),b++;return c/b},x=function(a,b){var c,d,e;if(null==a&&(a="options"),null==b&&(b=!0),e=document.querySelector("[data-pace-"+a+"]")){if(c=e.getAttribute("data-pace-"+a),!b)return c;try{return JSON.parse(c)}catch(f){return d=f,"undefined"!=typeof console&&null!==console?console.error("Error parsing inline pace options",d):void 0}}},g=function(){function a(){}return a.prototype.on=function(a,b,c,d){var e;return null==d&&(d=!1),null==this.bindings&&(this.bindings={}),null==(e=this.bindings)[a]&&(e[a]=[]),this.bindings[a].push({handler:b,ctx:c,once:d})},a.prototype.once=function(a,b,c){return this.on(a,b,c,!0)},a.prototype.off=function(a,b){var c,d,e;if(null!=(null!=(d=this.bindings)?d[a]:void 0)){if(null==b)return delete this.bindings[a];for(c=0,e=[];c<this.bindings[a].length;)e.push(this.bindings[a][c].handler===b?this.bindings[a].splice(c,1):c++);return e}},a.prototype.trigger=function(){var a,b,c,d,e,f,g,h,i;if(c=arguments[0],a=2<=arguments.length?X.call(arguments,1):[],null!=(g=this.bindings)?g[c]:void 0){for(e=0,i=[];e<this.bindings[c].length;)h=this.bindings[c][e],d=h.handler,b=h.ctx,f=h.once,d.apply(null!=b?b:this,a),i.push(f?this.bindings[c].splice(e,1):e++);return i}},a}(),j=window.Pace||{},window.Pace=j,v(j,g.prototype),D=j.options=v({},u,window.paceOptions,x()),U=["ajax","document","eventLag","elements"],Q=0,S=U.length;S>Q;Q++)K=U[Q],D[K]===!0&&(D[K]=u[K]);i=function(a){function b(){return V=b.__super__.constructor.apply(this,arguments)}return Z(b,a),b}(Error),b=function(){function a(){this.progress=0}return a.prototype.getElement=function(){var a;if(null==this.el){if(a=document.querySelector(D.target),!a)throw new i;this.el=document.createElement("div"),this.el.className="pace pace-active",document.body.className=document.body.className.replace(/pace-done/g,""),document.body.className+=" pace-running",this.el.innerHTML='<div class="pace-progress">\n  <div class="pace-progress-inner"></div>\n</div>\n<div class="pace-activity"></div>',null!=a.firstChild?a.insertBefore(this.el,a.firstChild):a.appendChild(this.el)}return this.el},a.prototype.finish=function(){var a;return a=this.getElement(),a.className=a.className.replace("pace-active",""),a.className+=" pace-inactive",document.body.className=document.body.className.replace("pace-running",""),document.body.className+=" pace-done"},a.prototype.update=function(a){return this.progress=a,this.render()},a.prototype.destroy=function(){try{this.getElement().parentNode.removeChild(this.getElement())}catch(a){i=a}return this.el=void 0},a.prototype.render=function(){var a,b,c,d,e,f,g;if(null==document.querySelector(D.target))return!1;for(a=this.getElement(),d="translate3d("+this.progress+"%, 0, 0)",g=["webkitTransform","msTransform","transform"],e=0,f=g.length;f>e;e++)b=g[e],a.children[0].style[b]=d;return(!this.lastRenderedProgress||this.lastRenderedProgress|0!==this.progress|0)&&(a.children[0].setAttribute("data-progress-text",""+(0|this.progress)+"%"),this.progress>=100?c="99":(c=this.progress<10?"0":"",c+=0|this.progress),a.children[0].setAttribute("data-progress",""+c)),this.lastRenderedProgress=this.progress},a.prototype.done=function(){return this.progress>=100},a}(),h=function(){function a(){this.bindings={}}return a.prototype.trigger=function(a,b){var c,d,e,f,g;if(null!=this.bindings[a]){for(f=this.bindings[a],g=[],d=0,e=f.length;e>d;d++)c=f[d],g.push(c.call(this,b));return g}},a.prototype.on=function(a,b){var c;return null==(c=this.bindings)[a]&&(c[a]=[]),this.bindings[a].push(b)},a}(),P=window.XMLHttpRequest,O=window.XDomainRequest,N=window.WebSocket,w=function(a,b){var c,d,e,f;f=[];for(d in b.prototype)try{e=b.prototype[d],f.push(null==a[d]&&"function"!=typeof e?a[d]=e:void 0)}catch(g){c=g}return f},A=[],j.ignore=function(){var a,b,c;return b=arguments[0],a=2<=arguments.length?X.call(arguments,1):[],A.unshift("ignore"),c=b.apply(null,a),A.shift(),c},j.track=function(){var a,b,c;return b=arguments[0],a=2<=arguments.length?X.call(arguments,1):[],A.unshift("track"),c=b.apply(null,a),A.shift(),c},J=function(a){var b;if(null==a&&(a="GET"),"track"===A[0])return"force";if(!A.length&&D.ajax){if("socket"===a&&D.ajax.trackWebSockets)return!0;if(b=a.toUpperCase(),$.call(D.ajax.trackMethods,b)>=0)return!0}return!1},k=function(a){function b(){var a,c=this;b.__super__.constructor.apply(this,arguments),a=function(a){var b;return b=a.open,a.open=function(d,e){return J(d)&&c.trigger("request",{type:d,url:e,request:a}),b.apply(a,arguments)}},window.XMLHttpRequest=function(b){var c;return c=new P(b),a(c),c};try{w(window.XMLHttpRequest,P)}catch(d){}if(null!=O){window.XDomainRequest=function(){var b;return b=new O,a(b),b};try{w(window.XDomainRequest,O)}catch(d){}}if(null!=N&&D.ajax.trackWebSockets){window.WebSocket=function(a,b){var d;return d=null!=b?new N(a,b):new N(a),J("socket")&&c.trigger("request",{type:"socket",url:a,protocols:b,request:d}),d};try{w(window.WebSocket,N)}catch(d){}}}return Z(b,a),b}(h),R=null,y=function(){return null==R&&(R=new k),R},I=function(a){var b,c,d,e;for(e=D.ajax.ignoreURLs,c=0,d=e.length;d>c;c++)if(b=e[c],"string"==typeof b){if(-1!==a.indexOf(b))return!0}else if(b.test(a))return!0;return!1},y().on("request",function(b){var c,d,e,f,g;return f=b.type,e=b.request,g=b.url,I(g)?void 0:j.running||D.restartOnRequestAfter===!1&&"force"!==J(f)?void 0:(d=arguments,c=D.restartOnRequestAfter||0,"boolean"==typeof c&&(c=0),setTimeout(function(){var b,c,g,h,i,k;if(b="socket"===f?e.readyState<2:0<(h=e.readyState)&&4>h){for(j.restart(),i=j.sources,k=[],c=0,g=i.length;g>c;c++){if(K=i[c],K instanceof a){K.watch.apply(K,d);break}k.push(void 0)}return k}},c))}),a=function(){function a(){var a=this;this.elements=[],y().on("request",function(){return a.watch.apply(a,arguments)})}return a.prototype.watch=function(a){var b,c,d,e;return d=a.type,b=a.request,e=a.url,I(e)?void 0:(c="socket"===d?new n(b):new o(b),this.elements.push(c))},a}(),o=function(){function a(a){var b,c,d,e,f,g,h=this;if(this.progress=0,null!=window.ProgressEvent)for(c=null,a.addEventListener("progress",function(a){return h.progress=a.lengthComputable?100*a.loaded/a.total:h.progress+(100-h.progress)/2},!1),g=["load","abort","timeout","error"],d=0,e=g.length;e>d;d++)b=g[d],a.addEventListener(b,function(){return h.progress=100},!1);else f=a.onreadystatechange,a.onreadystatechange=function(){var b;return 0===(b=a.readyState)||4===b?h.progress=100:3===a.readyState&&(h.progress=50),"function"==typeof f?f.apply(null,arguments):void 0}}return a}(),n=function(){function a(a){var b,c,d,e,f=this;for(this.progress=0,e=["error","open"],c=0,d=e.length;d>c;c++)b=e[c],a.addEventListener(b,function(){return f.progress=100},!1)}return a}(),d=function(){function a(a){var b,c,d,f;for(null==a&&(a={}),this.elements=[],null==a.selectors&&(a.selectors=[]),f=a.selectors,c=0,d=f.length;d>c;c++)b=f[c],this.elements.push(new e(b))}return a}(),e=function(){function a(a){this.selector=a,this.progress=0,this.check()}return a.prototype.check=function(){var a=this;return document.querySelector(this.selector)?this.done():setTimeout(function(){return a.check()},D.elements.checkInterval)},a.prototype.done=function(){return this.progress=100},a}(),c=function(){function a(){var a,b,c=this;this.progress=null!=(b=this.states[document.readyState])?b:100,a=document.onreadystatechange,document.onreadystatechange=function(){return null!=c.states[document.readyState]&&(c.progress=c.states[document.readyState]),"function"==typeof a?a.apply(null,arguments):void 0}}return a.prototype.states={loading:0,interactive:50,complete:100},a}(),f=function(){function a(){var a,b,c,d,e,f=this;this.progress=0,a=0,e=[],d=0,c=C(),b=setInterval(function(){var g;return g=C()-c-50,c=C(),e.push(g),e.length>D.eventLag.sampleCount&&e.shift(),a=q(e),++d>=D.eventLag.minSamples&&a<D.eventLag.lagThreshold?(f.progress=100,clearInterval(b)):f.progress=100*(3/(a+3))},50)}return a}(),m=function(){function a(a){this.source=a,this.last=this.sinceLastUpdate=0,this.rate=D.initialRate,this.catchup=0,this.progress=this.lastProgress=0,null!=this.source&&(this.progress=F(this.source,"progress"))}return a.prototype.tick=function(a,b){var c;return null==b&&(b=F(this.source,"progress")),b>=100&&(this.done=!0),b===this.last?this.sinceLastUpdate+=a:(this.sinceLastUpdate&&(this.rate=(b-this.last)/this.sinceLastUpdate),this.catchup=(b-this.progress)/D.catchupTime,this.sinceLastUpdate=0,this.last=b),b>this.progress&&(this.progress+=this.catchup*a),c=1-Math.pow(this.progress/100,D.easeFactor),this.progress+=c*this.rate*a,this.progress=Math.min(this.lastProgress+D.maxProgressPerFrame,this.progress),this.progress=Math.max(0,this.progress),this.progress=Math.min(100,this.progress),this.lastProgress=this.progress,this.progress},a}(),L=null,H=null,r=null,M=null,p=null,s=null,j.running=!1,z=function(){return D.restartOnPushState?j.restart():void 0},null!=window.history.pushState&&(T=window.history.pushState,window.history.pushState=function(){return z(),T.apply(window.history,arguments)}),null!=window.history.replaceState&&(W=window.history.replaceState,window.history.replaceState=function(){return z(),W.apply(window.history,arguments)}),l={ajax:a,elements:d,document:c,eventLag:f},(B=function(){var a,c,d,e,f,g,h,i;for(j.sources=L=[],g=["ajax","elements","document","eventLag"],c=0,e=g.length;e>c;c++)a=g[c],D[a]!==!1&&L.push(new l[a](D[a]));for(i=null!=(h=D.extraSources)?h:[],d=0,f=i.length;f>d;d++)K=i[d],L.push(new K(D));return j.bar=r=new b,H=[],M=new m})(),j.stop=function(){return j.trigger("stop"),j.running=!1,r.destroy(),s=!0,null!=p&&("function"==typeof t&&t(p),p=null),B()},j.restart=function(){return j.trigger("restart"),j.stop(),j.start()},j.go=function(){var a;return j.running=!0,r.render(),a=C(),s=!1,p=G(function(b,c){var d,e,f,g,h,i,k,l,n,o,p,q,t,u,v,w;for(l=100-r.progress,e=p=0,f=!0,i=q=0,u=L.length;u>q;i=++q)for(K=L[i],o=null!=H[i]?H[i]:H[i]=[],h=null!=(w=K.elements)?w:[K],k=t=0,v=h.length;v>t;k=++t)g=h[k],n=null!=o[k]?o[k]:o[k]=new m(g),f&=n.done,n.done||(e++,p+=n.tick(b));return d=p/e,r.update(M.tick(b,d)),r.done()||f||s?(r.update(100),j.trigger("done"),setTimeout(function(){return r.finish(),j.running=!1,j.trigger("hide")},Math.max(D.ghostTime,Math.max(D.minTime-(C()-a),0)))):c()})},j.start=function(a){v(D,a),j.running=!0;try{r.render()}catch(b){i=b}return document.querySelector(".pace")?(j.trigger("start"),j.go()):setTimeout(j.start,50)},"function"==typeof define&&define.amd?define(function(){return j}):"object"==typeof exports?module.exports=j:D.startOnPageLoad&&j.start()}).call(this);

$(function() {



//Functions Section

// JQUERY html encode
function htmlEncode(value)
{
  return $('<div/>').text(value).html();
}

// JQUERY html decode
function htmlDecode(value)
{
  return $('<div/>').html(value).text();
}


function GetPayloadList()
{
    $.ajax({
      type: "GET", dataType: "json", url: "functions.php", data: "get_payload_list",
        complete: function(data){
          var arr = JSON.parse(data.responseText);
          var out = "";
          var i;
          for(i = 0; i < arr.length; i++)
          {
            
          out+='<div class="btn-group">';
          out+='  <a class="btn btn-'+RandomBtn()+'">'+htmlEncode(arr[i].payload_value)+'</a>';
          out+='  <a class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>';
          out+='  <ul class="dropdown-menu">';
          out+='    <li id="delete_payload_waf"><a>Delete</a></li>';
          out+='  </ul>';
          out+='</div>';


          }//htmlEncode(arr[i].payload_type)  

          $("#PayloadList").html(out);

        }
    });
  return false;
}


function RandomBtn()
{
        switch (Math.ceil(Math.random() * 6)) {
          case 1:
              return 'danger';
              break;
          case 2:
              return 'primary';
              break;
          case 3:
              return 'default';
              break;
          case 4:
              return 'success';
              break;
          case 5:
              return 'info';
              break;
          case 6:
              return 'warning';
              break;

      } 
}

function RiskCalculate(RISK_value)
{

  if(RISK_value.contains_numbers && !RISK_value.contains_alpha && !JSON.parse(RISK_value.uniq_char))
  {
    return 'danger';
  }

  else if(!RISK_value.contains_numbers && RISK_value.contains_alpha && !JSON.parse(RISK_value.uniq_char))
  {
    return 'warning';
  }
  else
  {
    return 'info';
  }


}

var unconfigured_array = null;

function GetUnconfigured()
{
    $.ajax({
      type: "GET", dataType: "json", url: "functions.php", data: "get_unconfigured_param",
        complete: function(data){
            var arr = JSON.parse(data.responseText);
            var out = '<table class="table table-striped table-hover"><thead><tr>';
            out += '<th>#</th>';
            out += '<th>Name</th>';
            out += '<th>Risk</th>';
            out += '<th>Numbers</th>';
            out += '<th>Letters</th>';
            out += '<th>Special keys</th>';
            out += '<th>progress</th>';
            out += '<th>Length</th>';
            out += '</tr></thead><tbody>';
            var i;
            unconfigured_array = arr;
                for(i = 0; i < arr.length; i++) {
                    severity = RiskCalculate(arr[i]);
                    length = JSON.parse(arr[i].length).min+'-'+JSON.parse(arr[i].length).max;
                    if(JSON.parse(arr[i].length).min == JSON.parse(arr[i].length).max){length = JSON.parse(arr[i].length).min;}
                    out += '<tr class="'+severity+'">';
                    out += '<td>'+(i+1)+'</td>'; //index
                    out += '<td id="UnconfiguredPayloadName">' + htmlEncode(arr[i].name) + '</td>'; //name
                    out += '<td><span class="label label-'+severity+'">'+severity+'</span></td>';//severity
                    out += '<td>'+arr[i].contains_numbers+'</td>'; // in integer ?
                    out += '<td>'+arr[i].contains_alpha+'</td>'; // is alpha ?
                    out += '<td>'+htmlEncode(JSON.parse(arr[i].uniq_char))+'</td>'; // extra char (else then alphanumeric)
                    out += '<td><div class="progress"><div class="progress-bar progress-bar-success" style="width: '+(arr[i].values_amount*(100/arr[i].value_limit))+'%"></div></div></td>';
                    out += '<td><span class="badge">'+length+'</span></td>'; // length
                    out += '<td><a id="advanced_unconfigured" class="btn btn-success btn-xs">Filter</a></td>';
                    out += '<input type="hidden" id="index" value="'+i+'"></input>'; 
                    out += '</tr>'; 


                }
            out += '</tbody></table>';
      $("#Unconfigured").html(out);
      $("#ConfigureParam").parent().hide();

        }
    });
  return false;
}


var special_char = null;
var index;
$(document).on("click","#advanced_unconfigured",
function advanced_popup() {

  index = ($(this).parents().siblings('#index').val());
  var name = htmlEncode( unconfigured_array[index].name );
  var max = JSON.parse( unconfigured_array[index].length ).max;
  var min = JSON.parse( unconfigured_array[index].length ).min;
  special_char = unconfigured_array[index].uniq_char;

  var dataString = JSON.stringify({ param_name:htmlDecode(name) });
    $.ajax({
        type: "POST", dataType: "json", url: "functions.php?get_unconfigured_params_values", data: dataString,
          complete: function(data){
              array = JSON.parse(data.responseText);
              for (var i = array.length - 2; i >= 0; i--) {
                array[i] = ( array[i] );
              };

              $( '#advanced_values' ).html(htmlEncode(array));
        }
    });

  var out = '<div class="modal"><div class="modal-dialog"><div class="modal-content"><div class="modal-header">';
  out += '<button type="button" class="close close_popup" data-dismiss="modal" aria-hidden="true">×</button>';
  out += '<h4 class="modal-title">'+(name)+'</h4>';
  out += '</div>';
  out += '<div class="modal-body">';
  out += 'Set length limit: <span id="limit_value" class="label label-danger">'+max+'</span><input size="1" id="parameter_length_limit" type="range" name="points" min="0" max="'+max*3+'" value="'+max+'"><br>';

  out += '<div id="payload_type" class="btn-group">';
  out += '<a class="btn btn-default" id="type_numbers">Numbers</a>';
  out += '<a class="btn btn-default" id="type_letters">Letters</a>';
  out += '<a class="btn btn-default dropdown-toggle" id="type_spcial" aria-expanded="false">Extra char<span class="caret"></span></a>';
  out += '<ul class="dropdown-menu"><li id="type_special_all"><a>All</a></li><li id="type_special_history"><a>Based on values</a></li></ul>';
  out += '<input class="form-control" type="text" id="active_extra_char"></div>';
  out += '<br><br><div id="payload_example" class="alert alert-dismissible alert-success"></div>';
  out += '<div class="panel panel-default"><div class="panel-heading">Last uniq values</div><div class="panel-body" id="advanced_values"></div></div>';
  out += '</div>';
  out += '<div class="modal-footer">';
  out += '<button type="button" class="btn btn-default close_popup" data-dismiss="modal">Close?</button>';
  out += '<button type="button" class="btn btn-primary" id="submit_filter">Set Filter!</button>';
  out += '</div></div></div></div>';

  $('#body').children('#popup').html(out).children('.modal').show();
  if(unconfigured_array[index].contains_numbers){ $( "#type_numbers" ).addClass( 'active'); }
  if(unconfigured_array[index].contains_alpha){ $( "#type_letters" ).addClass( 'active'); }
  if(JSON.parse(unconfigured_array[index].uniq_char) != null){ $( "a[id|='type_special']" ).addClass( 'active'); $( "#type_special_history" ).addClass( 'active'); }
  
  // trigger update
  UpdateParameterProperties();

});


$(document).on("click",".dropdown-toggle",function()
  {
    if($(this).siblings( '.dropdown-menu' ).is(":visible")){ $(this).siblings( '.dropdown-menu' ).hide() }else{ $(this).siblings( '.dropdown-menu' ).show() };
  }
);

$(document).on("click",".dropdown-menu li",function()
  {
    if(!$(this).hasClass('active'))
      { 
        $(this).addClass('active'); 
      }
        else
          {
           $(this).removeClass('active');
          }

    $(this).siblings().removeClass('active');
    $( '.dropdown-menu' ).hide();
    UpdateParameterProperties();
  }
);

$(document).on("click","#parameter_length_limit",function()
  {
    // update parameter value selected by range input
    $("#limit_value").html($(this).val());
    // trigger update
    UpdateParameterProperties();
  }
);

$(document).on("click","#payload_type a",function()
  {
    if(!$(this).hasClass('dropdown-toggle')){
      // if clicked on inactive then activate
      if (!$(this).hasClass('active')){ $(this).addClass('active'); }
      // if clicked on active then deactivate's
      else{ $(this).removeClass('active'); }
      // trigger update
      UpdateParameterProperties();
    }
  }
);

function UpdateParameterProperties() {

  var length = $( '#limit_value' ).html();
  $( '#active_extra_char' ).hide();

  if($( "a[id|='type_letters']" ).hasClass('active')){ var letters = true; }
  if($( "a[id|='type_numbers']" ).hasClass('active')){ var numbers = true; }
  if($( "#type_special_all" ).hasClass('active')){ var special_all = true; }
  if($( "#type_special_history" ).hasClass('active')){ var special_history = true; }

  var string = 'abcdefghijklmnopqrstuvwxyz'; //to upper 
  var numeric = '0123456789';
  var punctuation = '"!@#$%^&*()_+~`|}{[]\:;?><,./-=' + "'";
  var example = '';
  while( example.length<length && (letters || numbers || special_all || special_history) ) {
      entity1 = Math.ceil(string.length * Math.random()*Math.random());
      entity2 = Math.ceil(numeric.length * Math.random()*Math.random());
      entity3 = Math.ceil(punctuation.length * Math.random()*Math.random());
      
      var generate_special = JSON.parse(special_char);
      if(special_history && generate_special != null)
      {
        generate_special = generate_special.join('');
        entity4 = Math.ceil(generate_special.length * Math.random()*Math.random());
      } 
      
      hold = string.charAt( entity1 - 1 );
      hold = (entity1%2==0)?(hold.toUpperCase()):(hold);
                      
      switch (Math.ceil(Math.random() * 4)) {
          case 1:
              if(letters) example += hold;
              break;
          case 2:
              if(numbers) example += numeric.charAt( entity2 - 1 );
              break;
          case 3:
              if(special_all) example += punctuation.charAt( entity3 - 1 );
              break;
          case 4:
              if(special_history && generate_special != null) example += generate_special.charAt( entity4 - 1 );
              break;

      } 

  }
  if(special_history) $( '#active_extra_char' ).val(generate_special).show().prop('disabled', false);
  if(special_all) $( '#active_extra_char' ).val(punctuation).show().prop('disabled', true);
  if(example.length > 57) example = example.substring(0, 57) + '...';
  $( '#payload_example' ).html(htmlEncode(example));

}


$(document).on("click","#submit_filter",
function() {

  var name = htmlDecode( unconfigured_array[index].name );
  var length = htmlDecode( $( '#limit_value' ).html() );
  var special_history_values = $( '#active_extra_char' ).val();
  if( $( "a[id|='type_letters']" ).hasClass( 'active' ) ){ var letters = true; }
  if( $( "a[id|='type_numbers']" ).hasClass( 'active' ) ){ var numbers = true; }
  if( $( "#type_special_all" ).hasClass( 'active' ) ){ var special_all = true; }
  if( $( "#type_special_history" ).hasClass( 'active' ) ){ var special_history = true; }

    // if one of the inputs is empty alert the user!
    if (!length || (!letters && !numbers && !special_all && !special_history)) {
        alert("Please Fill Atleast One Field");
    } else {
        // AJAX code to submit form.
        var dataString = JSON.stringify({ param_name:name , param_length:length, param_letters:letters, param_numbers:numbers, param_special_all:special_all, param_special_history:special_history, special_chars:special_history_values});
        $.ajax({
        type: "POST",
        dataType: "json",
        url: "functions.php?add_to_filtering",
        data: dataString,
        cache: false,
        complete: function() {
            // alert the user after successfuly added
            alert("Added To Filtering (:");
            GetUnconfigured();
            getFilterRules();
            $('.modal').hide();

            }
        });
      } 
});

// close popup window when user clicks on X or close button
$(document).on("click",".close_popup",
function(){
$(this).parents('.modal').hide();
});


$(document).on("click","#submit_payload",
function() {
  
  // get type 
  var type = $( '#payload_type' ).val();
  // get value
  var value = $( '#payload_value' ).val();
    
    // if one of the inputs is empty alert the user!
    if (type == '' || value == '') {
        alert("Please Fill All Fields");
    } else {
      // AJAX code to submit form.
        var dataString = JSON.stringify({ payload_type:type , payload_value:value});
        $.ajax({
        type: "POST",
  dataType: "json",
        url: "functions.php?add_to_payload_list",
        data: dataString,
        cache: false,
          complete: function() 
          {
            // update list
            GetPayloadList();
            // alert the user after successfuly added
            alert("Added (:");
            // reset inputs
            $( '#payload_type' ).val('');
            $( '#payload_value' ).val('');
          }

        });
    }

return false;

});






function getFilterRules()
{
    $.ajax({
      type: "GET", dataType: "json", url: "functions.php", data: "get_filters",
        complete: function(data){
            var arr = JSON.parse(data.responseText);
            var out = '<table class="table table-striped table-hover"><thead><tr>';
            out += '<th>#</th>';
            out += '<th>Name?</th>';
            out += '<th>Numbers?</th>';
            out += '<th>Letters?</th>';
            out += '<th>Special character?</th>';
            out += '<th>Length?</th>';
            out += '</tr></thead><tbody>';
            var i;
                for(i = 0; i < arr.length; i++) {
                  out += '<tr>';
                  out += '<td>'+(i+1)+'</td>'; //index
                  out += '<td id="filter_name">' + htmlEncode(arr[i].name) + '</td>'; //name
                  out += '<td>'+arr[i].numbers+'</td>'; // in integer ?
                  out += '<td>'+arr[i].letters+'</td>'; // is alpha ?
                  if(arr[i].special_history) out += '<td>'+htmlEncode(JSON.parse(arr[i].special_chars))+'</td>';
                  if(arr[i].special_all) out += '<td>'+'ALL'+'</td>'; 
                  if(!arr[i].special_all && !arr[i].special_history) out += '<td></td>'; 
                  out += '<td><span class="badge">'+arr[i].length+'</span></td>'; // length
                  out += '<td><a id="filter_remove" class="btn btn-primary btn-xs">Remove</a></td>';
                  out += '</tr>'; 


                }
            out += '</tbody></table>';
      $("#FilterRules").html(out);

        }
    });
  return false;
}

$(document).on("click","#filter_remove",
function() {
  
  var name = $(this).parents().siblings( '#filter_name' ).html();

      // AJAX code to submit form.
        var dataString = JSON.stringify({ name:htmlDecode(name) });
        $.ajax({
        type: "POST",
  dataType: "json",
        url: "functions.php?filter_remove",
        data: dataString,
        cache: false,
          complete: function() 
          {
            // alert the user after successfuly added
            alert("Successfully thrown back in the ocean!");

            // update lists
            GetUnconfigured();
            getFilterRules();

          }

        });


return false;

});


// ### CogWheel ###

function parseSystemOptions() {


    $.ajax({
    type: "GET", dataType: "json", url: "functions.php", data: "get_wheels",
      complete: function(data){
      var arr = JSON.parse(data.responseText);
      var i;
      $( '#tuning' ).html('');
        for(i = 0; i < arr.length; i++) {
          out = '';
          out += '<div class="form-group">'
          out += '<label class="control-label">'+(arr[i].name)+'</label>'
          out += '<div class="input-group">'
          out += '<span class="input-group-addon">#</span>'
          out += '<input id="value" class="form-control '+arr[i].nick+'" type="text">'
          out += '<input id="nick" type="hidden" value="'+(arr[i].nick)+'">'
          out += '<span class="input-group-btn">'
          out += '<button class="btn btn-default ' + arr[i].nick + 'click" type="button" id="weldwheel">Weld</button>'
          out += '</span></div></div>'
          $( '#tuning' ).append(out);
          $( '.'+arr[i].nick ).val(arr[i].value);
        }
        
      }
    });

}


$(document).on("click","#weldwheel",
function() {
  
  var nick = $(this).parents().siblings( '#nick' ).val();
  var value = $(this).parents().siblings( '#value' ).val();
    
    // if one of the inputs is empty alert the user!
    if (nick == '' || value == '') {
        alert("Please Fill All Fields");
    } else {
      // AJAX code to submit form.
        var dataString = JSON.stringify({ nick:htmlDecode(nick) , value:htmlDecode(value)});
        $.ajax({
        type: "POST",
  dataType: "json",
        url: "functions.php?set_wheel",
        data: dataString,
        cache: false,
          complete: function() 
          {
            // update list
            parseSystemOptions();
            // alert the user after successfuly added
            alert("Value Updated!");
            // reset inputs
          }

        });
    }

return false;

});

// refresh after password change
$(document).on("click",".encryptedpasswordclick",
function() {window.location.href = 'index.php';});


// ### End of CogWheel ###

function LoginPopup()
{

  var out = '';
  out += '';
}


//global variable
var saltkey;

function PreAuthorizationCheck(getstatus){

    $.ajax({  type: 'GET',
              dataType: 'json',
              url: 'login.php?getSalt',
              data: '',
              complete: function(data){
                var arr = JSON.parse(data.responseText);
                saltkey = arr[0].saltkey;
                console.log('Saltkey = ' + arr[0].saltkey);
                if(getstatus){ AuthorizationCheck(); }
              }

            });
}


function AuthorizationCheck(){

  $.ajax({
      type: 'POST',
      url: 'login.php?status',
      data: '',
      complete: function(jqxhr, txt_status){

        if(jqxhr.status == 200)
        {
           // alert('autherized!');
        }

        if(jqxhr.status == 401)
        {
          $( '#login_popup' ).children( '.modal' ).show();
        }

      }
  });
}

// login event by click
$(document).on("click","#submit_password",
function() {

  //login function 
  Login();

});

// login event by pressing Enter (key)
$('#password').keypress(function (e) {
  if (e.which == 13) {
    Login();
    return false;
  }
});




//login function
function Login()
{
  var psk = $( '#password' ).val();
  psk = Sha256.hash(psk);
  psk = saltkey + psk;
  console.log(psk);
  psk = Sha256.hash(psk); //hash in SHA256 before submitting
  console.log(psk);

  var rmb = $( '#remember' ).is(':checked');
  var dataString = JSON.stringify({ password:psk , remember:rmb});

  $( '#submit_password' ).html('Processing...').animate({opacity: 0.37,width: '100%'}, 277, function() {});
  $.ajax({
      type: 'POST',
      dataType: 'json',
      url: 'login.php?login',
      data: dataString,
      cache: false,
      complete: function(jqxhr, txt_status){

        if(jqxhr.status == 200)
        {
          window.location.href = 'index.php';
        }

        if(jqxhr.status == 401)
        {
          PreAuthorizationCheck(0);
          $( '#password' ).val('');
          $( '#submit_password' ).animate({opacity: 0.99,width: '20%'}, 277, function() {$(this).removeAttr('style')}).html('Try again');
        }

      }
  });  
}

// logout function 
$(document).on("click","#logout",
function() {

  $('body').html('Exiting...').animate({opacity: 0.0}, 500, function() {});
  $.ajax({
      type: 'POST',
      dataType: 'json',
      url: 'login.php?logout',
      data: 'logout=1' ,
      cache: false,
      complete: function(jqxhr, txt_status){

        if(jqxhr.status == 401)
        {
          window.location.href = 'index.php';
        }

      }
  });
});



// prevent Double Framing
if( window != top )
{
  top.location.href=location.href; 
}

// prepare JQUERY tabs
$( "#tabs" ).tabs();






$(document).on("click",".body",function() { 
  // get body functions
  GetUnconfigured();
  getFilterRules();

});

$(document).on("click",".headers",function() {
// get headers functions

});

$(document).on("click",".regex",function() { 

// get waf payload list
GetPayloadList();

});

$(document).on("click",".cogwheel",function() { 

// get cogwheels information
parseSystemOptions();

});


PreAuthorizationCheck(1);

// log check
console.log( "ready (:" );


});
