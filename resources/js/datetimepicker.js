// resources/js/datetimepicker.js

import 'eonasdan-bootstrap-datetimepicker';

document.addEventListener('DOMContentLoaded', function() {
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        // Otros ajustes según tus necesidades
    });
});