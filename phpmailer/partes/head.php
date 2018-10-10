<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<link rel="shortcut icon" href="https://www.mangoapp.co/a-recursos/img/sis/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="https://www.mangoapp.co/a-recursos/img/sis/favicon.ico" />



<link rel="stylesheet" href="css/normalize.css" />  
<link rel="stylesheet" href="css/estilos.css">

<script src="https://www.mangoapp.co/a-recursos/js/jquery-3.1.1.min.js"></script>
<script src="https://www.mangoapp.co/a-recursos/js/snackbar.js"></script>

<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"> </script>
<script src="https://cdn.jsdelivr.net/autonumeric/2.0.0/autoNumeric.min.js"></script>

<script src="https://www.mangoapp.co/a-recursos/graficos/code/highcharts.js"></script>
<script src="https://www.mangoapp.co/a-recursos/graficos/code/modules/exporting.js"></script>

<script type="text/javascript" src="https://www.mangoapp.co/a-recursos/js/push.min.js"></script>
<script type="text/javascript" src="https://www.mangoapp.co/a-recursos/js/serviceWorker.min.js"></script>

<script>
//script para desvanecer los divs de mensajes
$(document).ready(function(){

    setTimeout(function() {
        $('.mensaje_error').fadeOut('slow');
    }, 10000);

    setTimeout(function() {
        $('.mensaje_exito').fadeOut('slow');
    }, 10000);

    setTimeout(function() {
        $('.mensaje_logueo').fadeOut('slow');
    }, 10000);

});
</script>


<script>   
//script para color de fondo segun la letra del item
(function(w, d){

    function LetterAvatar (name, size) {

        name  = name || '';
        size  = size || 60;

        var colours = [
                "#F44336", "#E91E63", "#9C27B0", "#673AB7", "#3F51B5", "#2196F3", "#01579B", "#0097A7", "#009688", "#43A047", 
                "#33691E", "#827717", "#EF6C00", "#795548", "#BF360C", "#6D4C41", "#424242", "#607D8B", "#4A148C", "#7f8c8d"
            ],

            nameSplit = String(name).toUpperCase().split(' '),
            initials, charIndex, colourIndex, canvas, context, dataURI;


        if (nameSplit.length == 1) {
            initials = nameSplit[0] ? nameSplit[0].charAt(0):'?';
        } else {
            initials = nameSplit[0].charAt(0);
        }

        if (w.devicePixelRatio) {
            size = (size * w.devicePixelRatio);
        }
            
        charIndex     = (initials == '?' ? 72 : initials.charCodeAt(0)) - 64;
        colourIndex   = charIndex % 20;
        canvas        = d.createElement('canvas');
        canvas.width  = size;
        canvas.height = size;
        context       = canvas.getContext("2d");
         
        context.fillStyle = colours[colourIndex - 1];
        context.fillRect (0, 0, canvas.width, canvas.height);
        context.font = Math.round(canvas.width/2)+"px Arial";
        context.textAlign = "center";
        context.fillStyle = "#FFF";
        context.fillText(initials, size / 2, size / 1.5);

        dataURI = canvas.toDataURL();
        canvas  = null;

        return dataURI;
    }

    LetterAvatar.transform = function() {

        Array.prototype.forEach.call(d.querySelectorAll('img[avatar]'), function(img, name) {
            name = img.getAttribute('avatar');
            img.src = LetterAvatar(name, img.getAttribute('width'));
            img.removeAttribute('avatar');
            img.setAttribute('alt', name);
        });
    };


    // AMD support
    if (typeof define === 'function' && define.amd) {
        
        define(function () { return LetterAvatar; });
    
    // CommonJS and Node.js module support.
    } else if (typeof exports !== 'undefined') {
        
        // Support Node.js specific `module.exports` (which can be a function)
        if (typeof module != 'undefined' && module.exports) {
            exports = module.exports = LetterAvatar;
        }

        // But always support CommonJS module 1.1.1 spec (`exports` cannot be a function)
        exports.LetterAvatar = LetterAvatar;

    } else {
        
        window.LetterAvatar = LetterAvatar;

        d.addEventListener('DOMContentLoaded', function(event) {
            LetterAvatar.transform();
        });
    }

})(window, document);
</script>