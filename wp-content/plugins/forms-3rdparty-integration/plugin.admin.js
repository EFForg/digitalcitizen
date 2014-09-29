(function($){
	var lib = {
		id: function() {
			/// generate a "unique" id
			
			// "GUID" (Math.random()*16|0).toString(16) // http://stackoverflow.com/a/2117523/1037948
			return (Date.now || function() { return +new Date; })(); // http://stackoverflow.com/a/221357/1037948
		}//--	fn	id
		,
		action: function(e) {
			/// Do what the button says, usually involving a target and an after-effect

			var $o = $(this)
				, $target = $o.closest( $o.data('rel') )	//get the target off the link "rel", and find it from the parent-chain
				, after = $o.data('after')
				, action = $o.data('actn')
				;

			// toggling not handled by link, so allow...not the cleanest, maybe add another data- ?
			if(action.indexOf('toggle') < 0) e.preventDefault();

			switch(action) {
				case 'clone': lib.clone($target, after); break;
				case 'remove': lib.remove($target, after); break;
				case 'toggle':
				case 'toggle-sibling': lib.toggle($target, after, action); break;
			}

		}//--	fn	action
		,
		clone: function($target, after) {
			var	$clone = $target.clone();	//clone the target so we can add it later
			
			// perform requested post-operation
			lib.afterClone[after]($target, $clone, lib.id());

			//some more row properties
			$clone.toggleClass('alt');
			
			//add the clone after the target
			$target.after( $clone );
		}//--	fn	clone
		,
		remove: function($target, after) {
			$target.empty().remove();
			//lib.afterRemove[after]($target);
		}//--	fn	remove
		,
		toggle: function($container, after, action) {
			/// toggle the given container, or maybe a sibling, depending on the action
			var $target = action == 'toggle' ? $container : $container.find(after);

			$target.toggleClass('collapsed');
		}
		,
		afterClone: {
			row: function($target, $clone, newid) {
				lib.updateClonedRow(newid, $clone, /(mapping\]\[)([\d]+)/);
			}//--	fn	afterClone.row
			,
			metabox: function($target, $clone, newid) {
				//delete extra rows, fix title
				$clone.find('tr.fields').slice(1).empty().remove(); // only save the first row
				var $title = $clone.find('h3 span:last');
				$title.html( $title.html().split(':')[0] );

				// toggle hooks appropriately -- since the next call will 'reset' all fields, force collapsed
				$clone.find('.hook-example').addClass('collapsed');
				
				//reset clone values and update indices
				lib.updateClonedRow(newid, $clone, /(\[)([\d])/);
			}//--	fn	afterClone.metabox
		}//--	afterClone
		,
		updateClonedRow: function(newid, $clone, regex) {
			//reset clone values and update indices
			$clone.find('input,select').each(function(i, o){
				var $o = $(o)
					, id = $o.attr('id').split('-')
					, name = $o.attr('name')
					;
				
				$o.attr('id', id[0]+'-'+newid);
				$o.attr('name', name.replace(regex, '$1' + newid));
				
				//reset values
				if( $o.attr('type') != 'checkbox' ){
					$o.val('');
				}
				else {
					$o.removeAttr('checked');
				}
			});
			$clone.find('label').each(function(i, o){
				var $o = $(o);
				
				//set the for equal to its closest input's id
				$o.attr('for', $o.siblings('input').attr('id'));
			});
		}//--	fn	lib.updateClonedRow
	};

	$(function() {
		// setup elements
		var $plugin = $('#' + Forms3rdPartyIntegration_admin.N)
			, $metaboxes = $plugin.find('.meta-box')
		;

		// clone / delete row or metabox, toggle container or sibling, etc
		$plugin.on('click', '.actn', lib.action);
		// checkbox
		$plugin.on('change', '.change-actn', lib.action); // custom target to avoid checkbox pitfall...ugh

		//collapse all metabox sections initially
		var $postbox = $plugin.find('div.postbox');

		$postbox
			.addClass('collapsed')
			.each(function(i,o) {
				$(o).find('h3')
					.prepend('<span>[' + ($(o).data('icon') || '+') + ']</span> ')
					.addClass('actn')
					.data('actn', "toggle")
					.data('rel', ".postbox")
					;
			})
			;

		// sortable
		$plugin.find('table.mappings tbody').sortable({
			// fix width -- http://www.foliotek.com/devblog/make-table-rows-sortable-using-jquery-ui-sortable/
			helper: function(e, ui) {
					ui.children().each(function() {
						$(this).width($(this).width());
					});
					return ui;
				}
			, placeholder: "ui-state-highlight"
		}).disableSelection()
			.end()
			.find('div.meta-box-sortables').sortable({distance:30, tolerance:'pointer'});

	});
})(jQuery);