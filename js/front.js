

String.prototype.toSlug = function() {

  return this.replace(/^\s+|\s+$/gm,'')
    .replace(/[^a-z0-9-]/gi, '-')
    .replace(/-+/g, '-')
    .replace(/^-|-$/g, '')
    .toLowerCase();
};

BathHacked = {
  Options: {
    themes: {
      dark: {title: '#333', value: '#333', label: '#666', gauge: '#ddd'},
      light: {title: '#fff', value: '#fff', label: '#888', gauge: '#fff'}
    },
    sectors: function(range) {
      return [
        {color:'#d9392c', lo: 0, hi: range * 0.25},
        {color:'#f5821f', lo: range * 0.25, hi: range * 0.5},
        {color:'#50a64a', lo: range * 0.5, hi: range}
      ];
    },
    refreshInterval: 2 * 60000
  }
};

BathHacked.RadialGauge = function($elt, $) {

  var that= this;
  this.$elt = $elt;
  this.gauge = null;

  this.init = function() {

    var range = this.$elt.data('max') - this.$elt.data('min');

    var theme = BathHacked.Options.themes[this.$elt.data('theme')];

    this.gauge = new JustGage({
      id: this.$elt.attr('id'),
      min: this.$elt.data('min'),
      max: this.$elt.data('max'),
      value: this.$elt.data('value'),
      title: this.$elt.data('title'),
      gaugeColor: theme.gauge,
      titleFontColor: theme.title,
      valueFontColor: theme.value,
      labelFontColor: theme.label,
      label: this.$elt.data('label'),
      showInnerShadow: true,
      shadowSize: 3,
      shadowOpacity: 0.2,
      customSectors: BathHacked.Options.sectors(range),
      levelColorsGradient: false,
      startAnimationTime: 2000,
      startAnimationType: 'bounce',
      refreshAnimationTime: 2000,
      refreshAnimationType: 'bounce'
    });

    var $labelContainer = $('<div data-ui-label></div>').insertAfter(this.$elt);

    this.refresh();
  };

  this.refresh = function() {

    var $labelContainer = this.$elt.parent().find('[data-ui-label]');

    var label = this.$elt.data('percentage') + '% full at ' + this.$elt.data('updated');
    label += '<br/><span class="status ' + this.$elt.data('status').toLowerCase() + '">' + this.$elt.data('status') + '</span>';

    $labelContainer.html(label);

    this.gauge.refresh(this.$elt.data('value'));
  };

  this.init();
};

BathHacked.LinearGauge = function($elt, $) {
  var that= this;
  this.$elt = $elt;

  this.init = function() {

    var theme = BathHacked.Options.themes[this.$elt.data('theme')];

    this.$elt.css('background-color', theme.gauge);

    var $title = $('<p data-title></p>').insertBefore(this.$elt);
    var $bar = $('<div data-bar></div>').appendTo(this.$elt);
    var $bounds = $('<p data-bounds></p>').insertAfter(this.$elt);

    this.refresh();
  };

  this.refresh = function() {

    var theme = BathHacked.Options.themes[this.$elt.data('theme')];

    var $title = this.$elt.parent().find('[data-title]');

    var title = '<h4 class="title">' + this.$elt.data('title') + '</h4>';
    title += ' <span class="available"><strong>' + this.$elt.data('value') + '</strong> Available</span>';
    title += ' / <span class="percentage"><strong>' + this.$elt.data('percentage') + '%</strong> full</span>';
    title += ' <span class="updated">at <strong>' + this.$elt.data('updated') + '</strong></span>';

    $title.html(title);
    $title.css('color', theme.label);
    $title.find('.title').css('color', theme.title);

    var $bar = this.$elt.find('[data-bar]');

    var range = this.$elt.data('max') - this.$elt.data('min');
    var value = this.$elt.data('value');
    var widthPercent = range > 0 ? 100 * (value - this.$elt.data('min')) / range : 0;

    window.setTimeout(function(){
      $bar.css('width', widthPercent + '%');
    },200);

    $.each(BathHacked.Options.sectors(range), function(i,sector){
      if(value >= sector.lo && value < sector.hi) {
        $bar.css('background-color', sector.color);
      }
    });

    var $bounds = this.$elt.parent().find('[data-bounds]');

    var bounds = '<span class="min">' + this.$elt.data('min') + '</span>';
    bounds += '<span class="status ' + this.$elt.data('status').toLowerCase() + '">' + this.$elt.data('status') + '</span>';
    bounds += '<span class="max">' + this.$elt.data('max') + '</span>';

    $bounds.html(bounds);
    $bounds.css('color', theme.label);
  };

  this.init();
};

BathHacked.CarParks = function($, $elt, url, index, style, theme) {

  var that = this;
  this.$elt = $elt;
  this.url = url;
  this.style = style || 'radial';
  this.theme = theme || 'dark';
  this.values = [];
  this.index = index;

  this.init = function() {
    this.refresh();

    setInterval(this.refresh, BathHacked.Options.refreshInterval);
  };

  this.refresh = function() {
    $.ajax(url)
      .done(function(data){
        that.setValues(data);
        that.repaint();
      });
  };

  this.setValues = function(data) {

    this.values = [];

    $.each(data, function(i, value){

      value.occupancy = parseInt(value.occupancy);
      value.capacity = parseInt(value.capacity);
      value.percentage = parseInt(value.percentage);

      if(value.occupancy > value.capacity) {
        value.occupancy = value.capacity;
      }

      if(value.percentage > 100) {
        value.percentage = 100;
      }

      value.available = value.capacity - value.occupancy;

      value.updated = moment(this.lastupdate).format('HH:mm');

      that.values.push(value);
    });

    that.values.sort(function(a,b){
      return a.available < b.available ? 1 : ( a.available > b.available ? -1 : 0 );
    });
  };

  this.repaint = function() {

    $.each(this.values, function(){

      var slug = this.name.toSlug() + '_' + that.index;

      var $gauge = that.$elt.find('[data-gauge]#' + slug);

      if($gauge.length == 0) {
        $gauge = $('<div id="' + slug + '" data-gauge="' + that.style + '"><div  id="ui_' + slug + '" data-ui-container></div></div>').appendTo(that.$elt);
      }

      var $uiContainer = $gauge.find('[data-ui-container]');

      $uiContainer.data('min', 0);
      $uiContainer.data('max', this.capacity);
      $uiContainer.data('value', this.available);
      $uiContainer.data('title', this.name);
      $uiContainer.data('label', 'AVAILABLE');
      $uiContainer.data('theme', that.theme);
      $uiContainer.data('percentage', this.percentage);
      $uiContainer.data('status', this.status);
      $uiContainer.data('updated', this.updated);

      if(that.style == 'radial' && 'undefined' == typeof $uiContainer.data('gauge')) {
        $uiContainer.data('gauge', new BathHacked.RadialGauge($uiContainer, $));
      }
      else if(that.style == 'linear' && 'undefined' == typeof $uiContainer.data('gauge')) {
        $uiContainer.data('gauge', new BathHacked.LinearGauge($uiContainer, $));
      }
      else {
        var gauge = $uiContainer.data('gauge');

        gauge.refresh();
      }

    });
  };

  this.init();
};

(function ($) {
  $(function () {

    $('[data-car-parks][data-url]').each(function(index,value){

      var $this = $(this);

      var carParks = new BathHacked.CarParks($, $this, $this.data('url'),index, $this.data('style'), $this.data('theme'));

      $this.after('<p class="bath-hacked-credit">Built by <a href="https://twitter.com/@azazell0" target="_blank">@azazell0</a> / Powered by <a href="http://bathhacked.org" target="_blank">Bath: Hacked</a> / Data supplied by <a href="http://www.bathnes.gov.uk" target="_blank">BANES Council</a> for information purposes only</p>');

    });

  });
}(jQuery));