//jsWindow v0.34b | (c) 2012-2013 Mehmet Emrah TUNÇEL | http://www.jswindow.com/#p=lisans
//jsWindow BEKLEME ANİMASYONU İÇİN "SPIN" KÜTÜPHANESİNİ İÇERİR (JSWINDOW'DAN BAĞIMSI BİR KÜTÜPHANEDİR) | fgnass.github.com/spin.js#v1.2.8
var jw_konum="";var jw_website_cerceve_id="jswindow_website_cerceve";var jswindow=function(){function g(){var e=t("<div>").addClass("jw-d-simge1");var n=t("<div>").addClass("jw-d-simge1-C1");var r=t("<div>").addClass("jw-d-simge1-P1");var i=t("<div>").addClass("jw-d-simge1-C2");var s=t("<div>").addClass("jw-d-simge1-P2");var o=e.append(n.append(r)).append(i.append(s));return o}var t=window.jQuery;if(typeof t=="undefined"){window.onload=function(){alert("jQuery kütüphanesi bulunamadı! \n\n JsWindow çalışmak için jQuery 1.8.1 veya üzeri sürümüne ihtiyaç duyar. \n\n Lütfen JsWindow'un bulunduğu sayfalara jQuery kütüphanesini ekleyiniz.")};return false}var n=new Object;n.pencere=new Array;n.kPNO=new Array;var r=new Object;r.pencere=new Array;r.kPNO=new Array;var i=new Object;var s=new Object;var o=new Object;t(function(){if(!t("#jswindow").length){var n=t("<div>").attr("id","jswindow");var r=t("<div>").attr("id","jw-dinamik");var i=t("<div>").attr("id","jw-dinamikT");var s=t("<div>").attr("id","jw-statik");t("body").append(n.append(i).append(s));t("#"+jw_website_cerceve_id).append(r)}});t(function(){o.position=t("#"+jw_website_cerceve_id).css("position");o.overflowX=t("#"+jw_website_cerceve_id).css("overflow-x");o.overflowY=t("#"+jw_website_cerceve_id).css("overflow-y");o.width=document.getElementById(jw_website_cerceve_id).style.width;o.top=t("#"+jw_website_cerceve_id).css("top");o.status=false;i.X=t("body").css("overflow-x");i.Y=t("body").css("overflow-y")});this.statikPencere=function(e,r){var i=new Object;var o=true;var a=false,f=false,l=null,c=false,d=250,v=false,m=false,g=false,b=false,w=false;var E,S,x,T,N;i.htmlYarat=function(){this.cerceve=t("<div>").addClass("jw-s-cerceve");E=this.cerceve;this.perde=t("<div>").addClass("jw-s-perde");S=this.perde;this.perdeTABLE=t("<table>").addClass("jw-s-perdeTABLE");this.perdeTR=t("<tr>");this.perdeTD=t("<td>").addClass("jw-s-perdeTD");this.pencereTABLE=t("<div>").addClass("jw-s-pencereTABLE");this.pencereTD=t("<div>").addClass("jw-s-pencereTD");this.pencere=t("<div>").addClass("jw-s-pencere");x=this.pencere;this.baslikSatir=t("<div>").addClass("jw-s-baslikSatir");baslikSatir=this.baslikSatir;this.baslikDIV=t("<div>").addClass("jw-s-baslikDIV");this.kapatTus=t("<img>").addClass("jw-s-carpiImg").attr("src",jw_konum+"jswindow/resim/carpi.png").attr("title","Kapat");this.govde=t("<div>").addClass("jw-s-govde");T=this.govde;this.govdeTABLE=t("<table>").addClass("jw-s-govdeTABLE");this.govdeTR=t("<tr>").addClass("jw-s-govdeTR");this.icerikTD=t("<td>").addClass("jw-s-icerikTD");this.icerikDIV1=t("<div>").addClass("jw-s-icerikDIV1");this.icerikDIV2=t("<div>").addClass("jw-s-icerikDIV2");this.tusSatir=t("<div>").addClass("jw-s-tusDiv");N=this.tusSatir;this.akilliKapat=function(){if(o)i.kapat()};this.cerceve.attr("kod",e).attr("tur",r).mousedown(this.akilliKapat);this.pencere.on({mousedown:function(){o=false},mouseup:function(){o=true}});this.kapatTus.click(i.kapat);return this};i.kod=function(e){w=u().kod(e);if(!w)this.cerceve.attr("kod",e);return this};i.tur=function(e){this.cerceve.attr("tur",e);return this};i.en=function(e){this.pencere.css("width",e);return this};i.boy=function(e){this.govdeTABLE.css("height",e);return this};i.baslik=function(e,t,n){var r=0;if(typeof t=="string"&&typeof n=="string"){this.baslikDIV.css(t,n);r=1}else if(typeof t=="object"){this.baslikDIV.css(t);r=1}if(typeof e=="string"||typeof e=="number")this.baslikDIV.html(e);else if(typeof e=="object")this.baslikDIV.append(e);else if(!r)return this.baslikDIV.html();return this};i.icerik=function(e,t,n){var r=0;if(typeof t=="string"&&typeof n=="string"){this.icerikTD.css(t,n);r=1}else if(typeof t=="object"){this.icerikTD.css(t);r=1}if(typeof e=="string"||typeof e=="number")this.icerikDIV2.html(e);else if(typeof e=="object")this.icerikDIV2.append(e);else if(!r)return this.icerikDIV2.html();g=true;this.icerikDIV2.css("display","block");if(b)this.icerikDIV1.css("marginBottom","0");return this};i.bekleAnimasyon=function(e){if(e==undefined)this.icerikDIV1.spin(y);else this.icerikDIV1.spin(e);this.icerikDIV1.find(".spinner").css("margin","auto");b=true;this.icerikDIV1.css("display","block");if(g)this.icerikDIV1.css("marginBottom","0");else this.icerikDIV2.css("display","none");return this};i.baslikCss=function(e,t){if(typeof e=="string"&&typeof t=="string")this.baslikDIV.css(e,t);else if(typeof e=="object")this.baslikDIV.css(e);return this};i.icerikCss=function(e,t){if(typeof e=="string"&&typeof t=="string")this.icerikTD.css(e,t);else if(typeof e=="object")this.icerikTD.css(e);return this};i.css=function(e,t){if(typeof e=="string"&&typeof t=="string")this.pencere.css(e,t);else if(typeof e=="object")this.pencere.css(e);return this};i.sinifEkle=function(e){this.pencere.addClass(e);return this};i.sinifKaldir=function(e){this.pencere.removeClass(e);return this};i.govdeKapat=function(e){T.slideUp(e,function(){T.css("display","none")});this.tusSatir.slideUp(e,function(){N.css("display","none")});return this};i.govdeAc=function(e){T.slideDown(e);this.tusSatir.slideDown(e);return this};i.baslikSatirKapat=function(e){this.baslikSatir.slideUp(e,function(){baslikSatir.css("display","none")});return this};i.baslikSatirAc=function(e){this.baslikSatir.slideDown(e);return this};i.akilliKapatPasif=function(){this.cerceve.off("mousedown",this.akilliKapat);return this};i.akilliKapatAktif=function(){this.cerceve.on("mousedown",this.akilliKapat);return this};i.kapatPasif=function(){var e=this.kapatTus;e.fadeOut(300,function(){e.css("display","none")});return this};i.kapatAktif=function(){this.kapatTus.fadeIn(300);return this};i.kilitle=function(){i.akilliKapatPasif();i.kapatPasif();return this};i.kilitlePasif=function(){i.akilliKapatAktif();i.kapatAktif();return this};i.tamamTus=function(e,n){if(!f){f=true;if(typeof e=="function"){var n=e;var e=false}var r=t("<button>").text("Tamam").addClass("jw-t-standart").click(i.kapat).click(n).css("display","none");if(e)r.text(e);this.tusSatir.append(r);r.fadeIn(300);if(l)this.tusSatir.show(300);else this.tusSatir.css("display","block")}return this};i.secimTus=function(e,n,r){if(!a){a=true;var s=t("<button>").text("Evet").addClass("jw-t-standart").click(i.kapat).click(function(){e(1)}).css("display","none");var o=t("<button>").text("Hayır").addClass("jw-t-standart").click(i.kapat).click(function(){e(0)}).css("display","none");if(n!=undefined)s.text(n);if(r!=undefined)o.text(r);this.tusSatir.append(s);this.tusSatir.append(o);s.fadeIn(300);o.fadeIn(300);if(l){this.tusSatir.show(300)}else{this.tusSatir.css("display","block")}}return this};i.tusEkle=function(e,n){var r=t("<button>").text("Tamam").addClass("jw-t-standart").css("display","none");if(e!=undefined&&e!=false)r.text(e);if(typeof n=="function")r.click(function(){n()});this.tusSatir.append(r);r.fadeIn(300);if(l){this.tusSatir.show(300)}else this.tusSatir.css("display","block");return this};i.efekt=function(e,t){c=e;if(t!=undefined&&t!=false){d=t}this.cerceve.attr("efekt",e);return this};i.kapaninca=function(e){m=e;return this};i.ac=function(){if(E.attr("no")==undefined&&l==null&&w==false){{var e=t("#jw-statik .jw-s-cerceve[no]").length;if(h(n.kPNO)>0){v=p(n.kPNO);delete n.kPNO[v]}else v=e;n.pencere[v]=this;this.cerceve.attr("no",v);this.no=v}if(e==0)t("#jw-statik").css({display:"block"});{t("#jw-statik").append(this.cerceve);this.cerceve.append(this.perde.append(this.perdeTABLE.append(this.perdeTR.append(this.perdeTD))));this.pencere.append(this.baslikSatir.append(this.baslikDIV).append(this.kapatTus)).append(this.govde.append(this.govdeTABLE.append(this.govdeTR.append(this.icerikTD.append(this.icerikDIV1).append(this.icerikDIV2))))).append(this.tusSatir);this.cerceve.append(this.pencereTABLE.append(this.pencereTD.append(this.pencere)));l=1;this.cerceve.fadeIn(d);switch(c){case 1:this.pencere.fadeIn(d);break;case 2:this.pencere.show(d);break;case 3:this.pencere.slideDown(d);break;default:this.pencere.slideDown(d);break}s.pasif()}}return this};i.kapat=function(){function e(){E.remove();var e=t("#jw-statik 	.jw-s-cerceve[no]").length;var n=t("#jw-dinamik 	.jw-d-pencere[no][tamekran]").length;var r=t("#jw-dinamik 	.jw-d-pencere[no][tamekran][kucuk]").length;if(e==0)t("#jw-statik").css({display:"none"});if(e+n-r<1)s.aktif();if(m)m()}E.stop();x.stop();{l=false;n.kPNO[v]=v;delete n.pencere[v];E.removeAttr("no")}E.fadeOut(d,e);switch(c){case 1:x.fadeOut(d);break;case 2:x.hide(d);break;case 3:x.slideUp(d);break;default:x.slideUp(d);break}};return i};var u=this.statikPencereEris=function(){var e=new Object;e.no=function(e){if(n.pencere[e]!=undefined)return n.pencere[e];else return false};e.kod=function(e){var r=t("#jw-statik .jw-s-cerceve[kod='"+e+"'][no]");var i=r.attr("no");if(i!=undefined)return n.pencere[i];else return false};e.sira=function(e){var r,i=false;switch(e){case"max":r=t("#jw-statik .jw-s-cerceve[no]").eq(-1);break;case"min":r=t("#jw-statik .jw-s-cerceve[no]").eq(0);break;default:r=t("#jw-statik .jw-s-cerceve[no]").eq(e);break}if(r)i=r.attr("no");if(i)return n.pencere[i];else return false};e.tur=function(e){var r=false;var i=new Array;r=t("#jw-statik .jw-s-cerceve[no][tur='"+e+"']");r.each(function(){var e=t(this).attr("no");i[e]=n.pencere[e]});if(i.length>0)return i;else return false};return e};this.statikPencereTumunuKapat=function(){var e=t("#jw-statik .jw-s-cerceve[no]").each(function(){var e=t(this).attr("no");n.pencere[e].kapat()})};this.dinamikPencere=function(n,i){var o=new Object;var u=new Object;var f=new Object;var d=new Object;var v=new Object;v.kucult=true;v.temsil=true;var y=new Object;y.min=new Object;y.min.en=200;y.min.boy=120;y.max=new Object;y.max.en=false;y.max.boy=false;var b=new Object;b.ac=200;b.kapat=200;b.tamEkran=75;b.tamEkranTers=75;b.kucult=300;b.buyut=300;var w=new Object;w.ac=1;w.kapat=1;var E=false,S=null,x=false,T=false;var N,C,k,L;o.htmlYarat=function(){this.pencere=t("<div>").addClass("jw-d-pencere");N=this.pencere;this.baslikSatir=t("<div>").addClass("jw-d-baslikSatir");baslikSatir=this.baslikSatir;this.baslikSatirTABLE=t("<table>").addClass("jw-d-baslikSatirTABLE");this.baslikSatirTR=t("<tr>");this.baslikTD=t("<td>").addClass("jw-d-baslikTD");this.baslikDIV=t("<div>").addClass("jw-d-baslikDIV");this.tusTD=t("<td>").addClass("jw-d-tusTD");this.tusDiv=t("<div>").addClass("jw-d-tusDIV");this.kucultTus=t("<img>").addClass("jw-d-tus1").attr("src",jw_konum+"jswindow/resim/kucult.png").attr("title","Küçült");this.tamEkranTus=t("<img>").addClass("jw-d-tus1").attr("src",jw_konum+"jswindow/resim/tamekran.png").attr("title","Tam Ekran");this.kapatTus=t("<img>").addClass("jw-d-tus1").attr("src",jw_konum+"jswindow/resim/carpi.png").attr("title","Kapat");this.govdeCerceve=t("<div>").addClass("jw-d-govdeCerceve");this.govde=t("<div>").addClass("jw-d-govde");L=this.govde;this.govdePerde=t("<div>").addClass("jw-d-govdePerde");this.govdeTABLE=t("<table>").addClass("jw-d-govdeTABLE");this.govdeTR=t("<tr>");this.icerikTD=t("<td>").addClass("jw-d-icerikTD");this.boyutla=t("<div>").addClass("jw-d-boyutla");this.boyutlaSag=t("<div>").addClass("jw-d-boyutlaSag");this.boyutlaAlt=t("<div>").addClass("jw-d-boyutlaAlt");this.boyutlaKose=t("<div>").addClass("jw-d-boyutlaKose").html('<div class="jw-d-boyutlaKN" style="right:8px; 	bottom:8px;"></div>'+'<div class="jw-d-boyutlaKN" style="right:10px; bottom:8px;"></div>'+'<div class="jw-d-boyutlaKN" style="right:12px; bottom:8px;"></div>'+'<div class="jw-d-boyutlaKN" style="right:14px; bottom:8px;"></div>'+'<div class="jw-d-boyutlaKN" style="right:8px; 	bottom:10px;"></div>'+'<div class="jw-d-boyutlaKN" style="right:8px; 	bottom:12px;"></div>'+'<div class="jw-d-boyutlaKN" style="right:8px; 	bottom:14px;"></div>'+'<div class="jw-d-boyutlaKN" style="right:10px;	bottom:10px;"></div>'+'<div class="jw-d-boyutlaKN" style="right:10px; bottom:12px;"></div>'+'<div class="jw-d-boyutlaKN" style="right:12px; bottom:10px;"></div>');this.temsilKutu=t("<div>").addClass("jw-d-temsilKutu");C=this.temsilKutu;{this.temsilDIV2=t("<div>").addClass("jw-d-temsilDIV2");k=this.temsilDIV2;this.temsilDIV1=t("<div>").addClass("jw-d-temsilDIV1");this.temsilSimgeDIV=t("<div>").addClass("jw-d-temsilSimgeDIV").append(g());this.temsilBaslikDIV=t("<div>").addClass("jw-d-temsilBaslikDIV");this.temsilKapatDIV=t("<div>").addClass("jw-d-temsilKapatDIV").attr("title","Kapat");this.temsilKapatTus=t("<img>").addClass("jw-d-temsilKapatTus").attr("src",jw_konum+"jswindow/resim/carpi2.png")}d.surukle=function(){l.mBas(N)};d.tamEkran=function(){o.tamEkranVeTers()};d.kucult=function(){o.kucult()};d.temsilKutuBas=function(){o.temsilKutuBas()};d.oneAl=function(){o.oneAl()};d.ekranDisindaysaGetir=function(){o.ekranDisindaysaGetir()};this.pencere.attr("kod",n).attr("tur",i).on("mousedown",d.oneAl);this.baslikTD.mousedown(d.surukle);this.baslikSatir.dblclick(d.tamEkran);this.boyutlaKose.mousedown(function(){c.mBas(L,undefined,y)});this.boyutlaSag.mousedown(function(){c.mBas(L,"x",y)});this.boyutlaAlt.mousedown(function(){c.mBas(L,"y",y)});this.kapatTus.click(o.kapat);this.tamEkranTus.click(d.tamEkran);this.kucultTus.click(d.kucult);this.temsilKutu.click(d.temsilKutuBas);this.temsilKapatDIV.click(o.kapat);return this};o.kod=function(e){T=a().kod(e);if(!T)this.pencere.attr("kod",e);return this};o.tur=function(e){this.pencere.attr("tur",e);return this};o.minEn=function(e){y.min.en=e;return this};o.minBoy=function(e){y.min.boy=e;return this};o.maxEn=function(e){y.max.en=e;return this};o.maxBoy=function(e){y.max.boy=e;return this};o.en=function(e){var e=m("en",e);this.govde.css("width",e);return this};o.boy=function(e){var e=m("boy",e);this.govde.css("height",e);return this};o.x=function(e){this.pencere.css("left",e);return this};o.y=function(e){this.pencere.css("top",e);return this};o.baslik=function(e,t,n){var r=0;if(typeof t=="string"&&typeof n=="string"){this.baslikDIV.css(t,n);r=1}else if(typeof t=="object"){this.baslikDIV.css(t);r=1}if(typeof e=="string"||typeof e=="number")this.baslikDIV.html(e);else if(typeof e=="object")this.baslikDIV.append(e);else if(!r)return this.baslikDIV.html();return this};o.icerik=function(e,t,n){var r=0;if(typeof t=="string"&&typeof n=="string"){this.icerikTD.css(t,n);r=1}else if(typeof t=="object"){this.icerikTD.css(t);r=1}if(typeof e=="string"||typeof e=="number")this.icerikTD.html(e);else if(typeof e=="object")this.icerikTD.append(e);else if(!r)return this.icerikTD.html();return this};o.baslikCss=function(e,t){if(typeof e=="string"&&typeof t=="string")this.baslikDIV.css(e,t);else if(typeof e=="object")this.baslikDIV.css(e);return this};o.icerikCss=function(e,t){if(typeof e=="string"&&typeof t=="string")this.icerikTD.css(e,t);else if(typeof e=="object")this.icerikTD.css(e);return this};o.css=function(e,t){if(typeof e=="string"&&typeof t=="string")this.pencere.css(e,t);else if(typeof e=="object")this.pencere.css(e);return this};o.acEfekt=function(e,t){w.ac=e;if(t!=undefined){b.ac=t}return this};o.kapatEfekt=function(e,t){w.kapat=e;if(t!=undefined){b.kapat=t}return this};o.kucultEfekt=function(e){if(e!=undefined){b.kucult=e}return this};o.buyutEfekt=function(e){if(e!=undefined){b.buyut=e}return this};o.tamEkranEfekt=function(e){if(e!=undefined){b.tamEkran=e}return this};o.tamEkranTersEfekt=function(e){if(e!=undefined){b.tamEkranTers=e}return this};o.sinifEkle=function(e){this.pencere.addClass(e);return this};o.sinifKaldir=function(e){this.pencere.removeClass(e);return this};o.baslikSatirKapat=function(){e=this.baslikSatir;e.slideUp(function(){e.css("display","none")});return this};o.baslikSatirAc=function(){this.baslikSatir.slideDown();return this};o.kapatPasif=function(){var e=this.kapatTus;var t=this.temsilKapatDIV;e.hide(300,function(){e.css("display","none")});t.hide(300,function(){t.css("display","none")});return this};o.kapatAktif=function(){this.kapatTus.show(300);this.temsilKapatDIV.show(300);return this};o.tamEkranPasif=function(){var e=this.tamEkranTus;e.hide(300,function(){e.css("display","none")});this.baslikSatir.off("dblclick",d.tamEkran);return this};o.tamEkranAktif=function(){this.tamEkranTus.show(300);this.baslikSatir.on("dblclick",d.tamEkran);return this};o.kucultPasif=function(){v.kucult=false;var e=this.kucultTus;e.hide(300,function(){e.css("display","none")});return this};o.kucultAktif=function(){v.kucult=true;this.kucultTus.show(300);return this};o.temsilPasif=function(){o.kucultPasif();v.temsil=false;if(S)C.hide(b.kapat);return this};o.temsilAktif=function(){o.kucultAktif();v.temsil=true;if(S)C.show(b.ac);return this};o.boyutlaPasif=function(e){if(e==undefined){var t=this.boyutlaKose;t.hide(300,function(){t.css("display","none")});this.boyutlaSag.css("display","none");this.boyutlaAlt.css("display","none");return this}else{if(e=="x"){var t=this.boyutlaSag;t.hide(300,function(){t.css("display","none")});var n=this.boyutlaKose;n.hide(300,function(){n.css("display","none")});return this}else if(e=="y"){var t=this.boyutlaAlt;t.hide(300,function(){t.css("display","none")});var n=this.boyutlaKose;n.hide(300,function(){n.css("display","none")});return this}}};o.boyutlaAktif=function(e){if(e==undefined){this.boyutlaKose.show(300);this.boyutlaSag.css("display","block");this.boyutlaAlt.css("display","block");return this}else{if(e=="x"){if(this.boyutlaAlt.css("display")!="none")this.boyutlaKose.show(300);this.boyutlaSag.css("display","block");return this}else if(e=="y"){if(this.boyutlaSag.css("display")!="none")this.boyutlaKose.show(300);this.boyutlaAlt.css("display","block");return this}}};o.ortala=function(e,n){if(e==undefined)e=300;var r=new Object;var i=new Object;r.boy=t(window).height();r.en=t(window).width();r.st=t(window).scrollTop();r.sl=t(window).scrollLeft();i.en=this.pencere.width();i.boy=this.pencere.height();var s=i.boy-i.gBoy;var o=i.en-i.gEn;var u=parseInt(t("#"+jw_website_cerceve_id).css("top"));if(!isNaN(u))r.st=r.st-u;var a=(r.boy-i.boy)/2+r.st;var f=(r.en-i.en)/2+r.sl;if(a<0)a=0;if(f<0)f=0;var l=this.pencere;if(S==null){if(n==undefined)l.css("top",a).css("left",f);else if(n=="y")l.css("top",a);else if(n=="x")l.css("left",f)}else if(S){if(n==undefined)l.animate({top:a,left:f},e);else if(n=="y")l.animate({top:a},e);else if(n=="x")l.animate({left:f},e)}return this};o.altaYapistir=function(){var e=N.height();var n=t(window).height();var r=t(document).scrollTop();var i=parseInt(t("#"+jw_website_cerceve_id).css("top"));if(!isNaN(i))r=r-i;var s=n-e+r;this.pencere.animate({top:s},250)};o.usteYapistir=function(){var e=parseInt(t("#"+jw_website_cerceve_id).css("top"));if(!isNaN(e))var n=-e;else var n=t(document).scrollTop();this.pencere.animate({top:n},250)};o.ekranDisindaysaGetir=function(){var e=N.position().top;var n=N.height();var r=t(window).height();var i=t(document).scrollTop();var s=parseInt(t("#"+jw_website_cerceve_id).css("top"));if(!isNaN(s))i=i-s;var o=e<i;var u=e-i+n>r;var a=function(){N.animate({top:i},250)};var f=function(){N.animate({top:r-n+i},250)};var l=false;if(o||u){if(o&&!u){var c=e-i+n;var h=c<200;if(h){if(n>r)f();else a();l=true}}else if(!o&&u){var p=i+r-e;var h=p<200;if(h){if(n>r)a();else f();l=true}}else{}}return l};o.simge=function(e){if(typeof e=="string")this.temsilSimgeDIV.html(e);if(typeof e=="object"){this.temsilSimgeDIV.html("");this.temsilSimgeDIV.append(e)}return this};o.kapaninca=function(e){x=e;return this};o.ac=function(){if(N.attr("no")==undefined&&S==null&&T==false){var e=h(r.pencere);var n=e;if(h(r.kPNO)>0){E=p(r.kPNO);delete r.kPNO[E]}else E=e;if(e>0)a().zIndex("max").pasifPencereEfekt();r.pencere[E]=this;this.pencere.css("z-index",n).attr("no",E);this.no=E;{this.baslikSatir.append(this.baslikSatirTABLE.append(this.baslikSatirTR.append(this.baslikTD.append(this.baslikDIV)).append(this.tusTD.append(this.tusDiv.append(this.kucultTus).append(this.tamEkranTus).append(this.kapatTus)))));this.govdeCerceve.append(this.govde.append(this.govdePerde).append(this.govdeTABLE.append(this.govdeTR.append(this.icerikTD))));this.boyutla.append(this.boyutlaSag).append(this.boyutlaAlt).append(this.boyutlaKose);t("#jw-dinamik").append(this.pencere.append(this.baslikSatir).append(this.govdeCerceve).append(this.boyutla));t("#jw-dinamikT").append(this.temsilKutu.append(this.temsilDIV2).append(this.temsilDIV1.append(this.temsilSimgeDIV).append(this.temsilBaslikDIV).append(this.temsilKapatDIV.append(this.temsilKapatTus))))}if(parseInt(this.govde.css("width"))<1)this.govde.css("width",y.min.en);if(parseInt(this.govde.css("height"))<1)this.govde.css("height",y.min.boy);var i=this.pencere.css("left");var s=this.pencere.css("top");if((!i||i=="auto")&&(!s||s=="auto")){this.ortala()}else if(!i||i=="auto"){this.ortala(false,"x")}else if(!s||s=="auto"){this.ortala(false,"y")}{var u=parseInt(this.pencere.css("top"));var f=parseInt(this.pencere.css("left"));for(var l in r.pencere){if(l!=E){var c=parseInt(r.pencere[l].pencere.css("top"));var d=parseInt(r.pencere[l].pencere.css("left"));if(u==c){this.pencere.css({top:u+20});u+=20}if(f==d){this.pencere.css({left:f+20});f+=20}}}}S=1;this.temsilBaslikDIV.html(this.baslikDIV.html());o.aktifPencereEfekt();switch(w.ac){case 1:N.fadeIn(b.ac);break;case 2:N.show(b.ac);break;case 3:N.slideDown(b.ac);break;default:N.fadeIn(b.ac);break}if(v.temsil)C.show(b.ac)}else if(T)T.oneAl();return this};o.kapat=function(){var e=N.attr("no");if(e){var n=t("#jw-dinamik .jw-d-pencere[no]").length;var i=n-1;var o=parseInt(N.css("z-index"));var u=o+1;var a=N.attr("tamekran");{S=false;delete r.pencere[e];r.kPNO[e]=e;N.removeAttr("no")}for(var f=u;f<=i;f++){var l=t('#jw-dinamik [style*="z-index: '+f+'"][no]');l.css("z-index",f-1)}var c=function(){N.remove();C.remove();if(x)x()};switch(w.kapat){case 1:N.fadeOut(b.kapat,c);break;case 2:N.hide(b.kapat,c);break;case 3:N.slideUp(b.kapat,c);break;default:N.fadeOut(b.kapat,c);break}C.hide(b.kapat);var h=t("#jw-statik 	.jw-s-perde[no]").length;var p=t("#jw-dinamik 	.jw-d-pencere[no][tamekran]").length;var d=t("#jw-dinamik 	.jw-d-pencere[no][tamekran][kucuk]").length;if(h+p-d<1&&a==1){s.aktif()}}return this};o.oneAl=function(){var e=N.attr("no");var n=t("#jw-dinamik .jw-d-pencere[no]").length;var r=n-1;var i=parseInt(N.css("z-index"));var s=this.ekranDisindaysaGetir();if(e!=undefined&&i<r){var u=i+1;a().zIndex("max").pasifPencereEfekt();for(var f=u;f<=r;f++){var l=t('#jw-dinamik [style*="z-index: '+f+'"][no]');l.css("z-index",f-1)}N.css("z-index",r)}o.aktifPencereEfekt();return this};o.tamEkran=function(){var e=N.attr("no");if(e!=undefined){var n=N.attr("tamekran");if(n!=1){s.pasif();var r=t(window).height();var i=t(window).width();var o=t(window).scrollTop();var a=N.height();var f=N.width();u.x=parseInt(N.css("left"));u.y=parseInt(N.css("top"));var l=u.boy=this.govde.height();var c=u.en=this.govde.width();var h=a-l;var p=f-c;var v=parseInt(t("#"+jw_website_cerceve_id).css("top"));var m=-v+o;var g=0;var y=r-h-53;var w=i-p;this.tamEkranTus.attr("title","Önceki Boyut");this.baslikTD.off("mousedown",d.surukle);this.boyutla.css("display","none");this.pencere.attr("tamEkran",1);var E=b.tamEkran;this.pencere.animate({top:m,left:g},E*2);L.animate({width:w,height:y},E*2);this.pencere.animate({top:m+10,left:g+10},E);L.animate({width:w-20,height:y-20},E);this.pencere.animate({top:m,left:g},E);L.animate({width:w,height:y},E);this.pencere.animate({top:m+3,left:g+3},E);L.animate({width:w-6,height:y-6},E);this.pencere.animate({top:m,left:0},E);L.animate({width:w,height:y},E)}}return this};o.tamEkranTers=function(){var e=N.attr("no");if(e!=undefined){var n=N.attr("tamekran");if(n==1){this.pencere.on("mousedown",d.ekranDisindaysaGetir);var r=t("#jw-statik 	.jw-s-perde[no]").length;var i=t("#jw-dinamik 	.jw-d-pencere[no][tamekran]").length;var a=t("#jw-dinamik 	.jw-d-pencere[no][tamekran][kucuk]").length;if(r+i-a<2){s.aktif()}var f=new Object;f.en=u.en;f.boy=u.boy;f.top=u.y;f.left=u.x;this.tamEkranTus.attr("title","Tam Ekran");this.baslikTD.on("mousedown",d.surukle);this.boyutla.css("display","block");this.pencere.removeAttr("tamEkran");var l=b.tamEkranTers;this.pencere.animate({top:f.top,left:f.left},l*2);this.govde.animate({width:f.en,height:f.boy},l*2);this.pencere.animate({top:f.top-10,left:f.left-10},l);this.govde.animate({width:f.en+20,height:f.boy+20},l);this.pencere.animate({top:f.top,left:f.left},l);this.govde.animate({width:f.en,height:f.boy},l);this.pencere.animate({top:f.top-3,left:f.left-3},l);this.govde.animate({width:f.en+6,height:f.boy+6},l);this.pencere.animate({top:f.top,left:f.left},l);this.govde.animate({width:f.en,height:f.boy},l,function(){o.ekranDisindaysaGetir()});u=new Object}}return this};o.tamEkranVeTers=function(){var e=this.pencere.attr("no");if(e!=undefined){durum=this.pencere.attr("tamEkran");if(durum==1)o.tamEkranTers();else o.tamEkran()}return this};o.kucult=function(){if(v.kucult){var e=this.pencere.attr("no");var n=this.pencere.attr("kucuk");var r=this.ekranDisindaysaGetir();if(e!=undefined&&n==undefined&&r==false){var i=t("#jw-statik 	.jw-s-perde[no]").length;var o=t("#jw-dinamik 	.jw-d-pencere[no][tamekran]").length;var u=t("#jw-dinamik 	.jw-d-pencere[no][tamekran][kucuk]").length;if(i+o-u<2){if(this.pencere.attr("tamekran")){s.aktif()}}C.off("click",d.temsilKutuBas);var l=t("#jw-dinamikT");var c=new Object;c.cerY=l.position().top;c.cerX=l.position().left;c.en=this.temsilKutu.width();c.boy=this.temsilKutu.height();c.x=this.temsilKutu.position().left;c.y=this.temsilKutu.position().top;f.en=this.pencere.width();f.boy=this.pencere.height();f.x=parseInt(this.pencere.css("left"));f.y=parseInt(this.pencere.css("top"));function h(){C.on("click",d.temsilKutuBas);N.attr("kucuk",1);N.css("visibility","hidden");var e=t("#jw-dinamik .jw-d-pencere[no]").length;while(e>0){var n=e-1;var r=a().zIndex(n);if(r.pencere.attr("kucuk")!=1){r.oneAl();return}e--}}var p=t(document).scrollTop();this.pencere.animate({width:c.en,height:c.boy,top:c.y+c.cerY+p,left:c.x+c.cerX,opacity:0},b.kucult,h)}}return this};o.buyut=function(){var e=this.pencere.attr("no");var n=this.pencere.attr("kucuk");if(e!=undefined&&n==1){if(this.pencere.attr("tamekran")){s.pasif()}var r=t("#jw-dinamikT");var i=new Object;i.cerY=r.position().top;i.cerX=r.position().left;i.en=this.temsilKutu.width();i.boy=this.temsilKutu.height();i.x=this.temsilKutu.position().left;i.y=this.temsilKutu.position().top;var u=parseInt(t("#"+jw_website_cerceve_id).css("top"));if(isNaN(u))u=0;var a=t(document).scrollTop();var l=i.y+i.cerY+a-u;this.pencere.css({top:l,left:i.x+i.cerX});o.oneAl();N.css("visibility","visible");if(this.pencere.attr("tamekran")){var c=-u+t(document).scrollTop()}else{var c=f.y}var h=this.oneAl;this.pencere.animate({width:f.en,height:f.boy,top:c,left:f.x,opacity:1},b.buyut,function(){N.css({width:"auto",height:"auto"});N.removeAttr("kucuk");o.ekranDisindaysaGetir()});f=new Object}return this};o.temsilKutuBas=function(){var e=this.pencere.attr("kucuk");var t=this.pencere.attr("class");if(e==1)o.buyut();else if(t.indexOf("jw-d-pencereAktif")==-1)o.oneAl();else o.kucult();return this};o.aktifPencereEfekt=function(){N.addClass("jw-d-pencereAktif");C.addClass("jw-d-temsilKutuAktif");k.addClass("jw-d-temsilDIV2Aktif");return this};o.pasifPencereEfekt=function(){N.removeClass("jw-d-pencereAktif");C.removeClass("jw-d-temsilKutuAktif");k.removeClass("jw-d-temsilDIV2Aktif");return this};return o};var a=this.dinamikPencereEris=function(){var e=new Object;e.no=function(e){if(r.pencere[e]!=undefined)return r.pencere[e];else return false};e.kod=function(e){var n=t("#jw-dinamik .jw-d-pencere[kod='"+e+"'][no]");var i=n.attr("no");if(i!=undefined)return r.pencere[i];else return false};e.zIndex=function(e){switch(e){case"max":var n=h(r.pencere);var i=t('#jw-dinamik [style*="z-index: '+(n-1)+'"][no]');break;case"min":var i=t('#jw-dinamik [style*="z-index: 0"][no]');break;default:if(e!=undefined)var i=t('#jw-dinamik [style*="z-index: '+e+'"][no]')}if(i!=undefined)var s=i.attr("no");if(s!=undefined)return r.pencere[s];else return false};e.tur=function(e){var n=new Array;pencere=t("#jw-dinamik .jw-d-pencere[no][tur='"+e+"']");pencere.each(function(){var e=t(this).attr("no");n[e]=r.pencere[e]});if(n.length>0)return n;else return false};e.tumu=function(){var e=new Array;pencere=t("#jw-dinamik .jw-d-pencere[no]");pencere.each(function(){var n=t(this).attr("no");e[n]=r.pencere[n]});if(e.length>0)return e;else return false};return e};this.dinamikPencereTumunuKapat=function(){for(var e in r.pencere){r.pencere[e].kapat()}};var f=new Object;var l=new Object;l.durum=false;var c=new Object;c.durum=false;c.min=new Object;c.max=new Object;c.min.en=false;c.min.boy=false;c.max.en=false;c.max.boy=false;l.mBas=function(e){var n=e.position().left;var r=e.position().top;l.elm=e;l.rmeX=f.x-n;l.rmeY=f.y-r;l.durum=true;t(".jw-d-govdePerde").css("display","block");d(t(document));d(e)};l.hareket=function(){var e=f.x-l.rmeX;var t=f.y-l.rmeY;if(t<0)t=0;l.elm.css("left",e);l.elm.css("top",t)};l.mKaldir=function(){l.durum=false;t(".jw-d-govdePerde").css("display","none");v(t(document));v(l.elm)};c.mBas=function(e,n,r){var i=e.width();var s=e.height();c.elm=e;c.yon=n;c.min=r.min;c.max=r.max;c.rmbX=f.x-i;c.rmbY=f.y-s;c.durum=true;t(".jw-d-govdePerde").css("display","block");d(t(document));d(e)};c.hareket=function(){if(c.yon==undefined||c.yon=="x"){var e=f.x-c.rmbX;var e=m("en",e);c.elm.css("width",e)}if(c.yon==undefined||c.yon=="y"){var t=f.y-c.rmbY;t=m("boy",t);c.elm.css("height",t)}};c.mKaldir=function(){c.durum=false;t(".jw-d-govdePerde").css("display","none");v(t(document));v(c.elm)};t(window).mousemove(function(e){if(l.durum){l.hareket()}if(c.durum){c.hareket()}f.x=e.pageX;f.y=e.pageY});t(window).mouseup(function(){if(l.durum){l.mKaldir()}if(c.durum){c.mKaldir()}});var h=function(e){var t=0;for(var n in e)t++;return t};var p=function(e){for(var t in e)return t};var d=function(e){e.attr("unselectable","on").css({"user-select":"none",MozUserSelect:"none"}).on("selectstart",false)};var v=function(e){e.attr("unselectable","off").css({"user-select":"auto",MozUserSelect:"auto"}).off("selectstart",false)};var m=function(e,t){if(e=="en"){if(c.min.en&&t<c.min.en)return c.min.en;else if(c.max.en&&t>c.max.en)return c.max.en}else if(e=="boy"){if(c.min.boy&&t<c.min.boy)return c.min.boy;else if(c.max.boy&&t>c.max.boy)return c.max.boy}return t};s.pasif=function(){if(o.status!="fixed"){var e=t(document).height();var n=t(window).height();if(e>n&&i.Y!="hidden"){t("body").css({overflowY:"scroll"})}var r=t(window).scrollTop();t("#"+jw_website_cerceve_id).css({position:"fixed",width:"100%",top:-r})}o.status="fixed"};s.aktif=function(){var e=parseInt(t("#"+jw_website_cerceve_id).css("top"));if(isNaN(e))e=0;t("#"+jw_website_cerceve_id).css({position:o.position,width:o.width,top:o.top});var n=t(document).height();var r=t(window).height();if(n>r&&i.Y!="hidden"){t("body").css({overflowY:"visible"});t(window).scrollTop(-e)}o.status=false};this.bildirim=function(e,t){var n=new Object;var r=this.statikPencere(e,t);n.genel=function(e){var t=r.htmlYarat().baslik("BİLDİRİM").tamamTus(e);return t};n.olumlu=function(e){var t=r.htmlYarat().baslik("TAMAM").icerik("İşlem Başarıyla Tamamlandı!").sinifEkle("jw-ap1").tamamTus(e);return t};n.olumsuz=function(e){var t=r.htmlYarat().baslik("OLUMSUZ!",{color:"#EEE",textShadow:"-1px -1px 0 rgba(0,0,0,0.3)"}).icerik("İşlem Başarısız!",{color:"#EEE",textShadow:"-1px -1px 0 rgba(0,0,0,0.3)"}).sinifEkle("jw-ap4").tamamTus(e);return t};n.secim=function(e){var t=r.htmlYarat().baslik("SEÇİM").icerik("İşlemin yapılmasını onaylıyormusunuz?").sinifEkle("jw-ap3").secimTus(e);return t};n.bekle=function(){var e=r.htmlYarat().en(160).icerik("Lütfen Bekleyiniz...").bekleAnimasyon();e.baslikSatir.css({backgroundColor:"rgba(0,0,0,0)",boxShadow:"0 0 0"});e.icerikDIV1.css({marginTop:"0"});e.icerikDIV2.css({fontWeight:"bold",textShadow:"none"});return e};return n};this.kisa=function(e,t,n,r){var i=false;if(typeof t=="function"){var r=t;var t=false;var n=false}if(typeof n=="function"){var r=n;var n=false}switch(e){case"s":i=this.statikPencere(t,n).htmlYarat();break;case"s?":i=this.statikPencereEris();break;case"s!":i=this.statikPencereTumunuKapat();break;case"d":i=this.dinamikPencere(t,n).htmlYarat();break;case"d?":i=this.dinamikPencereEris();break;case"d!":i=this.dinamikPencereTumunuKapat();break;case"b":i=this.bildirim(t,n).genel(r);break;case"b olumlu":i=this.bildirim(t,n).olumlu(r);break;case"b olumsuz":i=this.bildirim(t,n).olumsuz(r);break;case"b secim":i=this.bildirim(t,n).secim(r);break;case"b bekle":i=this.bildirim(t,n).bekle();break;default:i=this.statikPencere(t,n).htmlYarat();break}return i};!function(e,t,n){function o(e,n){var r=t.createElement(e||"div"),i;for(i in n)r[i]=n[i];return r}function u(e){for(var t=1,n=arguments.length;t<n;t++)e.appendChild(arguments[t]);return e}function f(e,t,n,r){var o=["opacity",t,~~(e*100),n,r].join("-"),u=.01+n/r*100,f=Math.max(1-(1-e)/t*(100-u),e),l=s.substring(0,s.indexOf("Animation")).toLowerCase(),c=l&&"-"+l+"-"||"";if(!i[o]){a.insertRule("@"+c+"keyframes "+o+"{"+"0%{opacity:"+f+"}"+u+"%{opacity:"+e+"}"+(u+.01)+"%{opacity:1}"+(u+t)%100+"%{opacity:"+e+"}"+"100%{opacity:"+f+"}"+"}",a.cssRules.length);i[o]=1}return o}function l(e,t){var i=e.style,s,o;if(i[t]!==n)return t;t=t.charAt(0).toUpperCase()+t.slice(1);for(o=0;o<r.length;o++){s=r[o]+t;if(i[s]!==n)return s}}function c(e,t){for(var n in t)e.style[l(e,n)||n]=t[n];return e}function h(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var i in r)if(e[i]===n)e[i]=r[i]}return e}function p(e){var t={x:e.offsetLeft,y:e.offsetTop};while(e=e.offsetParent)t.x+=e.offsetLeft,t.y+=e.offsetTop;return t}function v(e){if(!this.spin)return new v(e);this.opts=h(e||{},v.defaults,d)}var r=["webkit","Moz","ms","O"],i={},s;var a=function(){var e=o("style",{type:"text/css"});u(t.getElementsByTagName("head")[0],e);return e.sheet||e.styleSheet}();var d={lines:12,length:7,width:5,radius:10,rotate:0,corners:1,color:"#FFF",speed:1,trail:100,opacity:1/4,fps:20,zIndex:2e9,className:"spinner",top:"auto",left:"auto",position:"relative"};v.defaults={};h(v.prototype,{spin:function(e){this.stop();var t=this,n=t.opts,r=t.el=c(o(0,{className:n.className}),{position:n.position,width:0,zIndex:n.zIndex}),i=n.radius+n.length+n.width,u,a;if(e){e.insertBefore(r,e.firstChild||null);a=p(e);u=p(r);c(r,{left:(n.left=="auto"?a.x-u.x+(e.offsetWidth>>1):parseInt(n.left,10)+i)+"px",top:(n.top=="auto"?a.y-u.y+(e.offsetHeight>>1):parseInt(n.top,10)+i)+"px"})}r.setAttribute("aria-role","progressbar");t.lines(r,t.opts);if(!s){var f=0,l=n.fps,h=l/n.speed,d=(1-n.opacity)/(h*n.trail/100),v=h/n.lines;(function m(){f++;for(var e=n.lines;e;e--){var i=Math.max(1-(f+e*v)%h*d,n.opacity);t.opacity(r,n.lines-e,i,n)}t.timeout=t.el&&setTimeout(m,~~(1e3/l))})()}return t},stop:function(){var e=this.el;if(e){clearTimeout(this.timeout);if(e.parentNode)e.parentNode.removeChild(e);this.el=n}return this},lines:function(e,t){function i(e,r){return c(o(),{position:"absolute",width:t.length+t.width+"px",height:t.width+"px",background:e,boxShadow:r,transformOrigin:"left",transform:"rotate("+~~(360/t.lines*n+t.rotate)+"deg) translate("+t.radius+"px"+",0)",borderRadius:(t.corners*t.width>>1)+"px"})}var n=0,r;for(;n<t.lines;n++){r=c(o(),{position:"absolute",top:1+~(t.width/2)+"px",transform:t.hwaccel?"translate3d(0,0,0)":"",opacity:t.opacity,animation:s&&f(t.opacity,t.trail,n,t.lines)+" "+1/t.speed+"s linear infinite"});if(t.shadow)u(r,c(i("#000","0 0 4px "+"#000"),{top:2+"px"}));u(e,u(r,i(t.color,"0 0 1px rgba(0,0,0,.1)")))}return e},opacity:function(e,t,n){if(t<e.childNodes.length)e.childNodes[t].style.opacity=n}});(function(){function e(e,t){return o("<"+e+' xmlns="urn:schemas-microsoft.com:vml" class="spin-vml">',t)}var t=c(o("group"),{behavior:"url(#default#VML)"});if(!l(t,"transform")&&t.adj){a.addRule(".spin-vml","behavior:url(#default#VML)");v.prototype.lines=function(t,n){function s(){return c(e("group",{coordsize:i+" "+i,coordorigin:-r+" "+ -r}),{width:i,height:i})}function l(t,i,o){u(a,u(c(s(),{rotation:360/n.lines*t+"deg",left:~~i}),u(c(e("roundrect",{arcsize:n.corners}),{width:r,height:n.width,left:n.radius,top:-n.width>>1,filter:o}),e("fill",{color:n.color,opacity:n.opacity}),e("stroke",{opacity:0}))))}var r=n.length+n.width,i=2*r;var o=-(n.width+n.length)*2+"px",a=c(s(),{position:"absolute",top:o,left:o}),f;if(n.shadow)for(f=1;f<=n.lines;f++)l(f,-2,"progid:DXImageTransform.Microsoft.Blur(pixelradius=2,makeshadow=1,shadowopacity=.3)");for(f=1;f<=n.lines;f++)l(f);return u(t,a)};v.prototype.opacity=function(e,t,n,r){var i=e.firstChild;r=r.shadow&&r.lines||0;if(i&&t+r<i.childNodes.length){i=i.childNodes[t+r];i=i&&i.firstChild;i=i&&i.firstChild;if(i)i.opacity=n}}}else s=l(t,"animation")})();if(typeof define=="function"&&define.amd)define(function(){return v});else e.Spinner=v}(window,document);t.fn.spin=function(e){this.each(function(){var n=t(this),r=n.data();if(r.spinner){r.spinner.stop();delete r.spinner}if(e!==false){r.spinner=(new Spinner(t.extend({color:n.css("color")},e))).spin(this)}});return this};var y={lines:10,length:4,width:6,radius:12,corners:.7,rotate:0,color:"#FFFFFF",speed:1.2,trail:40,shadow:true,hwaccel:false,className:"spinner",zIndex:2e9,top:"auto",left:"auto"}};var jw;var $jswindow=new jswindow;jw=function(e,t,n){return $jswindow.kisa(e,t,n)}