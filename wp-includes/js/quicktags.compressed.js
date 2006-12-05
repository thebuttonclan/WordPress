var edButtons=new Array();var edLinks=new Array();var edOpenTags=new Array();function edButton(id,_2,_3,_4,_5,_6){this.id=id;this.display=_2;this.tagStart=_3;this.tagEnd=_4;this.access=_5;this.open=_6;}function zeroise(_7,_8){var _9=_7.toString();if(_7<0){_9=_9.substr(1,_9.length);}while(_9.length<_8){_9="0"+_9;}if(_7<0){_9="-"+_9;}return _9;}var now=new Date();var datetime=now.getUTCFullYear()+"-"+zeroise(now.getUTCMonth()+1,2)+"-"+zeroise(now.getUTCDate(),2)+"T"+zeroise(now.getUTCHours(),2)+":"+zeroise(now.getUTCMinutes(),2)+":"+zeroise(now.getUTCSeconds(),2)+"+00:00";edButtons[edButtons.length]=new edButton("ed_strong","b","<strong>","</strong>","b");edButtons[edButtons.length]=new edButton("ed_em","i","<em>","</em>","i");edButtons[edButtons.length]=new edButton("ed_link","link","","</a>","a");edButtons[edButtons.length]=new edButton("ed_block","b-quote","\n\n<blockquote>","</blockquote>\n\n","q");edButtons[edButtons.length]=new edButton("ed_del","del","<del datetime=\""+datetime+"\">","</del>","d");edButtons[edButtons.length]=new edButton("ed_ins","ins","<ins datetime=\""+datetime+"\">","</ins>","s");edButtons[edButtons.length]=new edButton("ed_img","img","","","m",-1);edButtons[edButtons.length]=new edButton("ed_ul","ul","<ul>\n","</ul>\n\n","u");edButtons[edButtons.length]=new edButton("ed_ol","ol","<ol>\n","</ol>\n\n","o");edButtons[edButtons.length]=new edButton("ed_li","li","\t<li>","</li>\n","l");edButtons[edButtons.length]=new edButton("ed_code","code","<code>","</code>","c");edButtons[edButtons.length]=new edButton("ed_more","more","<!--more-->","","t",-1);function edLink(){this.display="";this.URL="";this.newWin=0;}edLinks[edLinks.length]=new edLink("WordPress","http://wordpress.org/");edLinks[edLinks.length]=new edLink("alexking.org","http://www.alexking.org/");function edShowButton(_a,i){if(_a.id=="ed_img"){document.write("<input type=\"button\" id=\""+_a.id+"\" accesskey=\""+_a.access+"\" class=\"ed_button\" onclick=\"edInsertImage(edCanvas);\" value=\""+_a.display+"\" />");}else{if(_a.id=="ed_link"){document.write("<input type=\"button\" id=\""+_a.id+"\" accesskey=\""+_a.access+"\" class=\"ed_button\" onclick=\"edInsertLink(edCanvas, "+i+");\" value=\""+_a.display+"\" />");}else{document.write("<input type=\"button\" id=\""+_a.id+"\" accesskey=\""+_a.access+"\" class=\"ed_button\" onclick=\"edInsertTag(edCanvas, "+i+");\" value=\""+_a.display+"\"  />");}}}function edShowLinks(){var _c="<select onchange=\"edQuickLink(this.options[this.selectedIndex].value, this);\"><option value=\"-1\" selected>(Quick Links)</option>";for(i=0;i<edLinks.length;i++){_c+="<option value=\""+i+"\">"+edLinks[i].display+"</option>";}_c+="</select>";document.write(_c);}function edAddTag(_d){if(edButtons[_d].tagEnd!=""){edOpenTags[edOpenTags.length]=_d;document.getElementById(edButtons[_d].id).value="/"+document.getElementById(edButtons[_d].id).value;}}function edRemoveTag(_e){for(i=0;i<edOpenTags.length;i++){if(edOpenTags[i]==_e){edOpenTags.splice(i,1);document.getElementById(edButtons[_e].id).value=document.getElementById(edButtons[_e].id).value.replace("/","");}}}function edCheckOpenTags(_f){var tag=0;for(i=0;i<edOpenTags.length;i++){if(edOpenTags[i]==_f){tag++;}}if(tag>0){return true;}else{return false;}}function edCloseAllTags(){var _11=edOpenTags.length;for(o=0;o<_11;o++){edInsertTag(edCanvas,edOpenTags[edOpenTags.length-1]);}}function edQuickLink(i,_13){if(i>-1){var _14="";if(edLinks[i].newWin==1){_14=" target=\"_blank\"";}var _15="<a href=\""+edLinks[i].URL+"\""+_14+">"+edLinks[i].display+"</a>";_13.selectedIndex=0;edInsertContent(edCanvas,_15);}else{_13.selectedIndex=0;}}function edSpell(_16){var _17="";if(document.selection){_16.focus();var sel=document.selection.createRange();if(sel.text.length>0){_17=sel.text;}}else{if(_16.selectionStart||_16.selectionStart=="0"){var _19=_16.selectionStart;var _1a=_16.selectionEnd;if(_19!=_1a){_17=_16.value.substring(_19,_1a);}}}if(_17==""){_17=prompt("Enter a word to look up:","");}if(_17!==null&&/^\w[\w ]*$/.test(_17)){window.open("http://www.answers.com/"+escape(_17));}}function edToolbar(){document.write("<div id=\"ed_toolbar\">");for(i=0;i<edButtons.length;i++){edShowButton(edButtons[i],i);}document.write("<input type=\"button\" id=\"ed_spell\" class=\"ed_button\" onclick=\"edSpell(edCanvas);\" title=\"Dictionary lookup\" value=\"lookup\" />");document.write("<input type=\"button\" id=\"ed_close\" class=\"ed_button\" onclick=\"edCloseAllTags();\" title=\"Close all open tags\" value=\"Close Tags\" />");document.write("</div>");}function edInsertTag(_1b,i){if(document.selection){_1b.focus();sel=document.selection.createRange();if(sel.text.length>0){sel.text=edButtons[i].tagStart+sel.text+edButtons[i].tagEnd;}else{if(!edCheckOpenTags(i)||edButtons[i].tagEnd==""){sel.text=edButtons[i].tagStart;edAddTag(i);}else{sel.text=edButtons[i].tagEnd;edRemoveTag(i);}}_1b.focus();}else{if(_1b.selectionStart||_1b.selectionStart=="0"){var _1d=_1b.selectionStart;var _1e=_1b.selectionEnd;var _1f=_1e;var _20=_1b.scrollTop;if(_1d!=_1e){_1b.value=_1b.value.substring(0,_1d)+edButtons[i].tagStart+_1b.value.substring(_1d,_1e)+edButtons[i].tagEnd+_1b.value.substring(_1e,_1b.value.length);_1f+=edButtons[i].tagStart.length+edButtons[i].tagEnd.length;}else{if(!edCheckOpenTags(i)||edButtons[i].tagEnd==""){_1b.value=_1b.value.substring(0,_1d)+edButtons[i].tagStart+_1b.value.substring(_1e,_1b.value.length);edAddTag(i);_1f=_1d+edButtons[i].tagStart.length;}else{_1b.value=_1b.value.substring(0,_1d)+edButtons[i].tagEnd+_1b.value.substring(_1e,_1b.value.length);edRemoveTag(i);_1f=_1d+edButtons[i].tagEnd.length;}}_1b.focus();_1b.selectionStart=_1f;_1b.selectionEnd=_1f;_1b.scrollTop=_20;}else{if(!edCheckOpenTags(i)||edButtons[i].tagEnd==""){_1b.value+=edButtons[i].tagStart;edAddTag(i);}else{_1b.value+=edButtons[i].tagEnd;edRemoveTag(i);}_1b.focus();}}}function edInsertContent(_21,_22){if(document.selection){_21.focus();sel=document.selection.createRange();sel.text=_22;_21.focus();}else{if(_21.selectionStart||_21.selectionStart=="0"){var _23=_21.selectionStart;var _24=_21.selectionEnd;_21.value=_21.value.substring(0,_23)+_22+_21.value.substring(_24,_21.value.length);_21.focus();_21.selectionStart=_23+_22.length;_21.selectionEnd=_23+_22.length;}else{_21.value+=_22;_21.focus();}}}function edInsertLink(_25,i,_27){if(!_27){_27="http://";}if(!edCheckOpenTags(i)){var URL=prompt("Enter the URL",_27);if(URL){edButtons[i].tagStart="<a href=\""+URL+"\">";edInsertTag(_25,i);}}else{edInsertTag(_25,i);}}function edInsertImage(_29){var _2a=prompt("Enter the URL of the image","http://");if(_2a){_2a="<img src=\""+_2a+"\" alt=\""+prompt("Enter a description of the image","")+"\" />";edInsertContent(_29,_2a);}}