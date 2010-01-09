/* TYPOlight Open Source CMS :: Copyright (C) 2005-2010 Leo Feyer :: LGPL license */
var SORT_INDEX;var TableSort=new Class({initialize:function(c,m){var k=$(c);if(k==null){return false}if(!k.rows||k.rows.length<1||!k.tHead||k.tHead.rows.length<1){return false}var b=null;var g=Cookie.read("TS_"+c.toUpperCase());if(g!==null){var b=g.split("|")}var l=k.tHead.rows[k.tHead.rows.length-1];for(var f=0;f<l.cells.length;f++){if(l.cells[f].className.indexOf("unsortable")!=-1){continue}var d=l.cells[f];
var e=d.innerHTML;var h=new Element("a").addClass("pointer");h.innerHTML=e;d.innerHTML="";h.addEvent("click",function(a,n){this.resort(a,n)}.pass([f,d],this));h.injectInside(d);if(b!==null&&b[0]==f){$(d).addClass((b[1]=="desc")?"asc":"desc");this.resort(b[0],d)}}},resort:function(h,b){var d=$(b);if(d==null){return false}var a=d.getParent("tr");var l=a.getParent("table");if(l==null||l.tBodies[0].rows.length<2){return false
}SORT_INDEX=h;var e=0;var c="";while(c==""&&l.tBodies[0].rows[e]){c=l.tBodies[0].rows[e].cells[h].innerHTML.replace(/<[^>]+>/i).clean();e++}var f=new Array();for(var e=0;e<l.tBodies[0].rows.length;e++){f[e]=l.tBodies[0].rows[e]}if(b.className.indexOf("date")!=-1||c.match(/^\d{1,4}[\/\. -]\d{1,2}[\/\. -]\d{1,4}$/)){f.sort(this.sortDate)}else{if(b.className.indexOf("currency")!=-1||c.match(/^[£$€Û¢´]/)||c.match(/^-?[\d\.,]+[£$€]$/)){f.sort(this.sortNumeric)
}else{if(b.className.indexOf("numeric")!=-1||c.match(/^-?[\d\.,]+(E[-+][\d]+)?$/)||c.match(/^-?[\d\.,]+%?$/)){f.sort(this.sortNumeric)}else{f.sort(this.sortCaseInsensitive)}}}if(b.className.indexOf("asc")==-1){var g=a.getChildren();for(var e=0;e<g.length;e++){g[e].removeClass("asc");g[e].removeClass("desc")}b.addClass("asc");Cookie.write("TS_"+l.id.toUpperCase(),h+"|asc",{path:"/"})}else{var g=a.getChildren();
for(var e=0;e<g.length;e++){g[e].removeClass("asc");g[e].removeClass("desc")}b.addClass("desc");Cookie.write("TS_"+l.id.toUpperCase(),h+"|desc",{path:"/"});f.reverse()}for(e=0;e<f.length;e++){var k=f[e].className;k=k.replace(/row_\d+/,"").replace(/odd|even|row_first|row_last/g,"").clean();k+=" row_"+e;if(e==0){k+=" row_first"}if(e>=(f.length-1)){k+=" row_last"}k+=(e%2==0)?" odd":" even";f[e].className=k.trim();
for(j=0;j<f[e].cells.length;j++){var k=f[e].cells[j].className;k=k.replace(/col_\d+/,"").replace(/odd|even|col_first|col_last/g,"").clean();k+=" col_"+j;if(j==0){k+=" col_first"}if(j>=(f[e].cells.length-1)){k+=" col_last"}f[e].cells[j].className=k.trim()}l.tBodies[0].appendChild(f[e])}},sortDate:function(d,c){aa=d.cells[SORT_INDEX].innerHTML.replace(/<[^>]+>/i).clean();bb=c.cells[SORT_INDEX].innerHTML.replace(/<[^>]+>/i).clean();
var e=aa.replace(/[\/\.-]/g," ").split(" ");var g=bb.replace(/[\/\.-]/g," ").split(" ");if(aa.match(/^\d{1,2}[\/\. -]\d{1,2}[\/\. -]\d{2,4}$/)){var f=((e[2].length==4)?e[2]:"19"+e[2])+((e[1].length==2)?e[1]:"0"+e[1])+((e[0].length==2)?e[0]:"0"+e[0]);var h=((g[2].length==4)?g[2]:"19"+g[2])+((g[1].length==2)?g[1]:"0"+g[1])+((g[0].length==2)?g[0]:"0"+g[0])}if(aa.match(/^\d{2,4}[\/\. -]\d{1,2}[\/\. -]\d{1,2}$/)){var f=((e[0].length==4)?e[0]:"19"+e[0])+((e[1].length==2)?e[1]:"0"+e[1])+((e[2].length==2)?e[2]:"0"+e[2]);
var h=((g[0].length==4)?g[0]:"19"+g[0])+((g[1].length==2)?g[1]:"0"+g[1])+((g[2].length==2)?g[2]:"0"+g[2])}if(f==h){return 0}if(f<h){return -1}return 1},sortNumeric:function(d,c){aa=d.cells[SORT_INDEX].innerHTML.replace(/<[^>]+>/i).replace(/[^0-9\.]/g,"").clean();bb=c.cells[SORT_INDEX].innerHTML.replace(/<[^>]+>/i).replace(/[^0-9\.]/g,"").clean();aa=parseFloat(aa);aa=(isNaN(aa)?0:aa);bb=parseFloat(bb);
bb=(isNaN(bb)?0:bb);return aa-bb},sortCaseInsensitive:function(d,c){aa=d.cells[SORT_INDEX].innerHTML.replace(/<[^>]+>/i).clean().toLowerCase();bb=c.cells[SORT_INDEX].innerHTML.replace(/<[^>]+>/i).clean().toLowerCase();if(aa==bb){return 0}if(aa<bb){return -1}return 1}});