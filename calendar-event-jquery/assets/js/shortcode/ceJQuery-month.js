jQuery(document).ready(function(){
    var object_data = object_date_picker, disabledDays = [], counter = 0, y = object_date_picker.year, m = object_date_picker.month, taxonomy = object_date_picker.taxonomy;
    jQuery( "#cej-datepicker").datepicker({
        inline: true,
        isRTL: true,
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        changeMonth: true,
        showMonthAfterYear: true,
        beforeShowDay: function(date) {
            var d = date.getDate();
            m = parseInt(m);
            m = String((m<10) ? '0'+m : m);
            d = String((d<10) ? '0'+d : d);
            if(counter == 0) {
                counter++;
                var data_responce = null;
                jQuery.ajax({
                    method: 'post',
                    dataType : "json",
                    url: object_data.url,
                    async: false,
                    data: {
                        action: 'cej_ajax_public',
                        year: y,
                        month: m,
                        taxonomy: taxonomy,
                    },
                    beforeSend: function() {
                        disabledDays = [];
                    },
                    success: function(data) {
                        data_responce = data;
                    },
                });
                if(data_responce.ok) {
                    jQuery('.cej-datetime-result').html(data_responce.theme);
                    for(var i=0 ; i<data_responce.posts.length ; i++) {
                        for(var j=0 ; j<data_responce.posts[i].ranges.length ; j++) {
                            disabledDays.push(data_responce.posts[i].ranges[j]);
                        }
                    }
                    for (i=0 ; i<disabledDays.length ; i++) {
                        if(jQuery.inArray(y + '/' + m + '/' + d, disabledDays) != -1) {
                            return [false, 'ui-state-active', ''];
                        }
                    }
                    return [true];
                } else {
                    jQuery('.cej-datetime-result').html(data_responce.theme);
                    return [true];
                }
            } else {
                counter++;
                for (i = 0; i < disabledDays.length; i++) {
                    if(jQuery.inArray(y + '/' + m + '/' + d, disabledDays) != -1) {
                        return [true, 'ui-state-active', ''];
                    }
                }
                return [true];
            }
        },
        onChangeMonthYear: function(year, month) {
            counter = 0;
            y = year;
            m = month;
        },
    });
});