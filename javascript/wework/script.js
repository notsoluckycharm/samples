jQuery(document).ready(function($) {
    var widgets = {
        weatherWidget : function(el) {
            var widget = {
                el: undefined,
                local: false,
                key : '804c76cfad39462c',
                init: function(el)
                {
                    this.el = $(el);
                    this.el.html( $("#weather-widget").html() );
                    if( this.el.hasClass('local') ) {
                        this.localize();
                    } else {
                        this.renderPosition('San Fransisco', 'CA',false);
                        this.getWeather('San Fransisco', 'CA', this.renderWeather);
                    }
                    return this;
                },
                localize: function() {
                    if (navigator.geolocation)
                    {
                        var self = this;
                        navigator.geolocation.getCurrentPosition(function(position){
                            self.doCall('geolookup',
                                position.coords.latitude+','+position.coords.longitude+'.json',
                                function(json){
                                    self.getWeather(json.location.city, json.location.state, self.renderWeather);
                                    self.renderPosition(json.location.city, json.location.state,true);
                                }
                            );
                        });
                    } else {
                        this.el.html("Geolocation is not supported by this browser.");
                    }
                },
                getWeather: function(city,state,callback) {
                    var self = this;
                    this.renderLoading(true);
                    this.doCall('conditions', state.replace(/\s/g, '_')+'/'+city.replace(/\s/g,'_')+'.json', function(json){
                        if( callback !== undefined )
                            callback.call( self, json );
                    });
                },
                renderWeather: function(params){
                    this.el.find('.weather').html(
                        _.template( $('#weather').html(), params.current_observation )
                    );
                    this.renderLoading(false);
                },
                renderPosition: function(city,state,local){
                    var self = this;
                    this.el.on('click', 'input[type=submit]', function(event){
                        var city = self.el.find('input[name=city]').val();
                        var state = self.el.find('input[name=state]').val();
                        self.getWeather(city, state, self.renderWeather);
                        event.preventDefault();
                    });
                    this.el.find('.location').html(
                        _.template( $('#location').html(),{
                            city: city,
                            state: state,
                            local: local
                        })
                    );
                },
                renderLoading: function(bool){
                    bool ? this.el.find('.loading').show() : this.el.find('.loading').hide();
                },
                doCall: function( call, query, callback ){
                    $.ajax({
                        url : 'http://api.wunderground.com/api/'+this.key+'/'+call+'/q/'+query,
                        dataType : "jsonp",
                        success : function(json){
                            callback(json);
                        }
                    });
                }
            }
            return widget.init(el);
        }
    }
    _.each($(".weather-widget"), function(el){
        var weatherWidget = new widgets.weatherWidget(el);
    }, this);
});