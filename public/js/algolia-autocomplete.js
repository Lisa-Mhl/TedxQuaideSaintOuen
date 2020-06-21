$(document).ready(function() {
    $('.js-search-autocomplete').autocomplete({hint: false}, [
        {
            source: function(query, cb) {
                cb([
                    {value: 'foo'},
                    {value: 'bar'}
                ])
            }
        }
    ]);
});