var vibrator = vibrator || {};

(function(){

    vibrator = {

        slow: function() {
            var pattern = [1000,1000,1000,1000]; 
            vibration(pattern);
        },

        middle: function() {
            var pattern = [500,500,500,500,500,500,500,500]; 
            vibration(pattern);
        },

        fast: function() {
            var pattern = [250,250,250,250,250,250,250,250,250,250,250,250,250,250,250,250]; 
            vibration(pattern);
        }

    };

    function vibration(params) {
        if (navigator.vibrate == undefined)
            return false;

        navigator.vibrate(params);
            
        return this;
    }

})();
