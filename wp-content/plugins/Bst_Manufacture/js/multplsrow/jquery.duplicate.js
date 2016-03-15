/** https://github.com/ReallyGood/jQuery.duplicate */

jQuery.duplicate = function(){
  var body = jQuery('body');
  body.off('duplicate');
  var templates = {};
  var settings = {};
  var init = function(){
    jQuery('[data-duplicate]').each(function(){
      var name = jQuery(this).data('duplicate');
      var template = jQuery('<div>').html( jQuery(this).clone(true) ).html();
      var options = {};
      var min = +jQuery(this).data('duplicate-min');
      options.minimum = isNaN(min) ? 1 : min;
      options.maximum = +jQuery(this).data('duplicate-max') || Infinity;
      options.parent = jQuery(this).parent();

      settings[name] = options;
      templates[name] = template;
    });
    
    body.on('click.duplicate', '[data-duplicate-add]', add);
    body.on('click.duplicate', '[data-duplicate-remove]', remove);
  };
  
  function add(){
    var targetName = jQuery(this).data('duplicate-add');
    var selector = jQuery('[data-duplicate=' + targetName + ']');
    var target = jQuery(selector).last();
    var tarlen= target.length;
    if(!target.length) target = jQuery(settings[targetName].parent);
    var newElement = jQuery(templates[targetName]).clone(true).attr('dupl',targetName+''+tarlen).addClass(targetName+''+tarlen);
    jQuery(newElement).find("input[type='text']").val("").find("input[type='checkbox']").attr('checked','');
    
    if(jQuery(selector).length >= settings[targetName].maximum) {
      jQuery(this).trigger('duplicate.error');
      return;
    }
    target.after(newElement);
    jQuery(this).trigger('duplicate.add');
  }
  
  function remove(){
    var targetName = jQuery(this).data('duplicate-remove');
    var selector = '[data-duplicate=' + targetName + ']';
    var target = jQuery(this).closest(selector);
    if(!target.length) target = jQuery(this).siblings(selector).eq(0);
    if(!target.length) target = jQuery(selector).last();
    
    if(jQuery(selector).length <= settings[targetName].minimum) {
      jQuery(this).trigger('duplicate.error');
      return;
    }
    target.remove();
    jQuery(this).trigger('duplicate.remove');
  }
  
  jQuery(init);
};

jQuery.duplicate();