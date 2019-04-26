/**
 * @package    hubzero-cms
 * @copyright  Copyright 2005-2019 HUBzero Foundation, LLC.
 * @license    http://opensource.org/licenses/MIT MIT
 */
var JFormValidator=function(){this.initialize=function(){this.handlers=Object(),this.custom=Object(),this.setHandler("username",function(e){return regex=new RegExp("[<|>|\"|'|%|;|(|)|&]","i"),!regex.test(e)}),this.setHandler("password",function(e){return regex=/^\S[\S ]{2,98}\S$/,regex.test(e)}),this.setHandler("numeric",function(e){return regex=/^(\d|-)?(\d|,)*\.?\d*$/,regex.test(e)}),this.setHandler("email",function(e){return regex=/^[a-zA-Z0-9.!#$%&’*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/,regex.test(e)}),$("form.form-validate").each(function(e,t){this.attachToForm(t)},this)},this.setHandler=function(e,t,a){a=""==a||a,this.handlers[e]={enabled:a,exec:t}},this.attachToForm=function(e){e.find("input,textarea,select,button").each(function(e,t){(t=$(t)).hasClass("required")&&(t.attr("aria-required","true"),t.attr("required","required")),"input"!=t.prop("tagName")&&"button"!=$(t).prop("tagName")||"submit"!=$(t).attr("type")?(t.on("blur",function(){return document.formvalidator.validate(this)}),t.hasClass("validate-email")&&this.inputemail&&t.attr("type","email")):t.hasClass("validate")&&t.on("click",function(){return document.formvalidator.isValid(this.form)})})},this.inputemail=function(){var e=document.createElement("input");return e.setAttribute("type","email"),"text"!==e.type},this.validate=function(e){if((e=$(e)).attr("disabled")&&!e.hasClass("required"))return this.handleResponse(!0,e),!0;if(e.hasClass("required"))if("fieldset"==e.prop("tagName")&&(e.hasClass("radio")||e.hasClass("checkboxes")))for(var t=e.find("input"),a=0;a<t.length;a++){if(!$("#"+e.attr("id")+a).length)return this.handleResponse(!1,e),!1;if($("#"+e.attr("id")+a).checked)break}else if(!e.val())return this.handleResponse(!1,e),!1;var i=e.className&&-1!=e.className.search(/validate-([a-zA-Z0-9\_\-]+)/)?e.className.match(/validate-([a-zA-Z0-9\_\-]+)/)[1]:"";return""==i?(this.handleResponse(!0,e),!0):i&&"none"!=i&&this.handlers[i]&&e.get("value")&&1!=this.handlers[i].exec(e.get("value"))?(this.handleResponse(!1,e),!1):(this.handleResponse(!0,e),!0)},this.isValid=function(e){for(var t=!0,a=$(e).find("input,textarea,select"),i=0;i<a.length;i++)0==this.validate(a[i])&&(t=!1);return t},this.handleResponse=function(e,t){t.labelref||$("label").each(function(e){null!=(e=$(e)).attr("for")&&e.attr("for")==t.attr("id")&&(t.labelref=e)});0==e?(t.addClass("invalid"),t.attr("aria-invalid","true"),null!=t.labelref&&($(t.labelref).addClass("invalid"),$(t.labelref).attr("aria-invalid","true"))):(t.removeClass("invalid"),t.attr("aria-invalid","false"),null!=t.labelref&&(t.labelref.removeClass("invalid"),t.labelref.attr("aria-invalid","false")))}};document.formvalidator=null,jQuery(document).ready(function(e){document.formvalidator=new JFormValidator});
