/*
	Script: jQuery.xdCheckbox.js
	Plug-in for jQuery to conventional styling checkbox in custom
*/

/*
	Author:
		Valeriy Chupurnov <leroy@xdan.ru>, <http://xdan.ru>
	License:
		LGPL - Lesser General Public License

	Posted <http://xdan.ru/projects/xdCheckbox/index.html>
	
	A simple search of the empty positions, so it works very slowly.
	Warning: not recommended for more than 50 objects
*/
(function($){
jQuery.fn.xdCheckbox = function (options){
	var settings = {
		width:-1,
		checked:-1,
		disabled:-1,
	}
	options = $.extend(settings,options);
	var setStatus = function ($cb,check,status){
		if(check)$cb.addClass(status);else $cb.removeClass(status);
		$("input", $cb).attr(status, check);
	}
	return this.each(function(){
		var $this = $(this);
		if(!$this.is('input'))return false;
		if( $this.attr('type').toLowerCase()!='checkbox' )return false;
		if( !$this.data('xdcb') ){
			$this.data('xdcb',true);
			$this.wrap('<span class="checkbox"></span>').after('<span class="check"></span>');
			var $cb = $this.parent();
			if( options.width!=-1 ){
				$cb.find('span.check').css({width:options.width,height:options.width});
				$cb.css({width:options.width,height:options.width});
			}
			if( $this.is(':checked') )$cb.addClass('checked');
			if( $this.is(':disabled') )$cb.addClass('disabled');
			$cb.click(function(){
				if($(this).hasClass('disabled'))return false;
				$(this).toggleClass('checked');
				var src = $("input", this);
				src.attr("checked", !src.is(':checked'));
			})
		}else 
			var $cb = $this.parent();
		if( options.checked!=-1 ){
			setStatus($cb,options.checked,'checked');
		}
		if( options.disabled!=-1 ){
			setStatus($cb,options.disabled,'disabled');
		}
	})
}
})(jQuery);